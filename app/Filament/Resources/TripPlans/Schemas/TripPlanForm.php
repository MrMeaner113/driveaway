<?php

namespace App\Filament\Resources\TripPlans\Schemas;

use App\Models\AddOnService;
use App\Models\Contact;
use App\Models\DiscountReason;
use App\Models\Driver;
use App\Models\FuelType;
use App\Models\QuoteRequest;
use App\Models\RateType;
use App\Models\TaxRate;
use App\Models\TaxType;
use App\Models\TravelMode;
use App\Models\Vehicle;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TripPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(self::sections());
    }

    public static function sections(): array
    {
        return [
            // ── 1. Quote Request ─────────────────────────────────────────────
            Section::make('Quote Request')
                ->columns(2)
                ->schema([
                    Select::make('quote_request_id')
                        ->label('Quote Request')
                        ->searchable()
                        ->required()
                        ->options(fn () => QuoteRequest::whereIn('status', ['new', 'in_progress', 'reviewed', 'quoted'])
                            ->get()
                            ->mapWithKeys(fn ($qr) => [$qr->id => "#{$qr->id} — {$qr->full_name}"])
                            ->toArray())
                        ->default(fn () => ($id = request('quote_request_id')) ? (int) $id : null)
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            if (! $state) return;
                            $qr = QuoteRequest::find($state);
                            if (! $qr) return;
                            // Pre-populate tax rate from destination province
                            $code = $qr->destinationProvince?->code;
                            if ($code) {
                                $rate = self::taxRateForProvinceCode($code);
                                if ($rate) {
                                    $set('tax_rate', $rate['decimal']);
                                    $set('tax_type_id', $rate['tax_type_id']);
                                }
                            }
                        }),
                    Select::make('currency')
                        ->label('Currency')
                        ->options(['CAD' => 'CAD', 'USD' => 'USD'])
                        ->default('CAD')
                        ->required()
                        ->live(),
                    TextInput::make('fx_rate')
                        ->label('FX Rate (CAD → USD)')
                        ->numeric()
                        ->step(0.000001)
                        ->placeholder('e.g. 0.730000')
                        ->visible(fn (Get $get) => $get('currency') === 'USD')
                        ->requiredIf('currency', 'USD'),
                ]),

            // ── 2. Assignment ────────────────────────────────────────────────
            Section::make('Assignment')
                ->columns(2)
                ->schema([
                    Select::make('driver_id')
                        ->label('Assigned Driver')
                        ->searchable()
                        ->nullable()
                        ->options(fn () => Driver::with('user')
                            ->get()
                            ->mapWithKeys(fn ($d) => [$d->id => $d->user?->name ?? "Driver #{$d->id}"])
                            ->toArray())
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            if (! $state) return;
                            $driver = Driver::find($state);
                            if ($driver?->default_rate_per_km !== null) {
                                $set('driver_rate_per_km', $driver->default_rate_per_km);
                                self::recalculate($get, $set);
                            }
                        }),
                    Select::make('vehicle_id')
                        ->label('Assigned Vehicle')
                        ->searchable()
                        ->nullable()
                        ->options(fn () => Vehicle::query()
                            ->get()
                            ->mapWithKeys(fn ($v) => [$v->id => trim("{$v->year} {$v->vehicleMake?->name} {$v->vehicleModel?->name}")])
                            ->toArray())
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            if (! $state) return;
                            $vehicle = Vehicle::find($state);
                            if ($vehicle?->fuel_economy_l100 !== null) {
                                $set('fuel_economy_l100', $vehicle->fuel_economy_l100);
                                self::recalculate($get, $set);
                            }
                        }),
                    Select::make('origin_contact_id')
                        ->label('Origin Contact')
                        ->searchable()
                        ->nullable()
                        ->options(fn () => Contact::orderBy('first_name')
                            ->get()
                            ->mapWithKeys(fn ($c) => [$c->id => $c->full_name])
                            ->toArray()),
                    Select::make('destination_contact_id')
                        ->label('Destination Contact')
                        ->searchable()
                        ->nullable()
                        ->options(fn () => Contact::orderBy('first_name')
                            ->get()
                            ->mapWithKeys(fn ($c) => [$c->id => $c->full_name])
                            ->toArray()),
                ]),

            // ── 3. Schedule ──────────────────────────────────────────────────
            Section::make('Schedule')
                ->columns(2)
                ->schema([
                    DatePicker::make('pickup_date')
                        ->label('Pickup Date')
                        ->nullable()
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('latest_delivery_date')
                        ->label('Latest Delivery Date')
                        ->placeholder('Calculated from pickup + extended drive time')
                        ->readOnly()
                        ->dehydrated(false),
                ]),

            // ── 4. Route ─────────────────────────────────────────────────────
            Section::make('Route')
                ->columns(4)
                ->schema([
                    TextInput::make('distance_km')
                        ->label('Distance (km)')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->step(0.01)
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('detour_pct')
                        ->label('Detour %')
                        ->readOnly()
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state * 100, 0) . '%' : '—')
                        ->helperText('Auto-calculated from distance'),
                    TextInput::make('out_of_route_km')
                        ->label('Out of Route (km)')
                        ->readOnly()
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 1) : '—'),
                    TextInput::make('adjusted_distance_km')
                        ->label('Adjusted Distance (km)')
                        ->readOnly()
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 1) : '—'),
                ]),

            // ── 5. Duration ──────────────────────────────────────────────────
            Section::make('Duration')
                ->columns(3)
                ->schema([
                    TextInput::make('avg_speed_kph')
                        ->label('Avg Speed (kph)')
                        ->numeric()
                        ->required()
                        ->default(90)
                        ->minValue(50)
                        ->maxValue(130)
                        ->step(0.1)
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('drive_hours')
                        ->label('Drive Hours')
                        ->readOnly()
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2) . ' hrs' : '—'),
                    TextInput::make('nights')
                        ->label('Nights (billed)')
                        ->readOnly()
                        ->dehydrated(false)
                        ->helperText('floor(hours ÷ 10)'),
                    Toggle::make('ferry_involved')
                        ->label('Ferry Involved')
                        ->default(false)
                        ->helperText('Uses +3 buffer instead of +2')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('drive_days')
                        ->label('Drive Days')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('floor(hours ÷ 12) — edit to override')
                        ->disabled(fn (Get $get) => ! $get('drive_days_override'))
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    Toggle::make('drive_days_override')
                        ->label('Override Drive Days')
                        ->default(false)
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            if (! $state) {
                                // Re-lock: recalculate drive_days from formula
                                $hours = (float) ($get('drive_hours') ?: 0);
                                $set('drive_days', (int) floor($hours / 12));
                            }
                        }),
                    TextInput::make('extended_drive_time')
                        ->label('Extended Drive Time (days)')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Nights + 2 (or +3 ferry) — planning only, never billed')
                        ->disabled(fn (Get $get) => ! $get('extended_drive_time_override'))
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    Toggle::make('extended_drive_time_override')
                        ->label('Override Ext. Drive Time')
                        ->default(false)
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            if (! $state) {
                                $nights = (int) ($get('nights') ?: 0);
                                $ferry  = (bool) $get('ferry_involved');
                                $set('extended_drive_time', $nights + ($ferry ? 3 : 2));
                                self::recalculate($get, $set);
                            }
                        }),
                ]),

            // ── 6. Fuel ──────────────────────────────────────────────────────
            Section::make('Fuel')
                ->columns(3)
                ->schema([
                    Select::make('fuel_type_id')
                        ->label('Fuel Type')
                        ->nullable()
                        ->options(fn () => FuelType::where('is_active', true)
                            ->orderBy('sort_order')
                            ->pluck('name', 'id')
                            ->toArray()),
                    TextInput::make('fuel_economy_l100')
                        ->label('Fuel Economy (L/100km)')
                        ->numeric()
                        ->required()
                        ->default(12)
                        ->minValue(1)
                        ->maxValue(50)
                        ->step(0.01)
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('fuel_price_per_litre')
                        ->label('Fuel Price ($/L)')
                        ->numeric()
                        ->required()
                        ->default(2.00)
                        ->minValue(0.50)
                        ->step(0.0001)
                        ->prefix('$')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('estimated_fuel_litres')
                        ->label('Estimated Fuel (L)')
                        ->readOnly()
                        ->dehydrated(false)
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 1) . ' L' : '—'),
                    TextInput::make('fuel_cost')
                        ->label('Fuel Cost')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2) : '—'),
                ]),

            // ── 7. Driver & Rates ────────────────────────────────────────────
            Section::make('Driver & Rates')
                ->columns(3)
                ->schema([
                    Select::make('rate_type_id')
                        ->label('Rate Type')
                        ->nullable()
                        ->options(fn () => RateType::where('is_active', true)
                            ->orderBy('sort_order')
                            ->pluck('name', 'id')
                            ->toArray()),
                    TextInput::make('driver_rate_per_km')
                        ->label('Driver Rate ($/km)')
                        ->numeric()
                        ->required()
                        ->default(0.20)
                        ->minValue(0.01)
                        ->step(0.0001)
                        ->prefix('$')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('driver_cost')
                        ->label('Driver Cost')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2) : '—'),
                ]),

            // ── 8. Accommodations & Meals ────────────────────────────────────
            Section::make('Accommodations & Meals')
                ->columns(3)
                ->schema([
                    TextInput::make('hotel_rate')
                        ->label('Hotel Rate ($/night)')
                        ->numeric()
                        ->required()
                        ->default(150.00)
                        ->minValue(0)
                        ->step(0.01)
                        ->prefix('$')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('accommodations_cost')
                        ->label('Accommodations Cost')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2) : '—'),
                    TextInput::make('meal_rate')
                        ->label('Meal Rate ($/meal)')
                        ->numeric()
                        ->required()
                        ->default(15.00)
                        ->minValue(0)
                        ->step(0.01)
                        ->prefix('$')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('meals_per_day')
                        ->label('Meals / Day')
                        ->numeric()
                        ->required()
                        ->default(3)
                        ->minValue(0)
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('meals_cost')
                        ->label('Meals Cost')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state ? number_format((float) $state, 2) : '—'),
                ]),

            // ── 9. Add-On Services ───────────────────────────────────────────
            Section::make('Add-On Services')
                ->schema([
                    Repeater::make('tripPlanAddOnServices')
                        ->relationship('tripPlanAddOnServices')
                        ->label('')
                        ->addActionLabel('Add service')
                        ->orderColumn('sort_order')
                        ->columns(4)
                        ->schema([
                            Select::make('add_on_service_id')
                                ->label('Service')
                                ->nullable()
                                ->searchable()
                                ->options(fn () => AddOnService::where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->pluck('name', 'id')
                                    ->toArray())
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                    if (! $state) return;
                                    $svc = AddOnService::find($state);
                                    if ($svc) {
                                        $set('description', $svc->name);
                                        $set('rate', $svc->base_rate ?? 0);
                                        $set('charge', $svc->base_rate ?? 0);
                                    }
                                }),
                            TextInput::make('description')
                                ->label('Description')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('rate')
                                ->label('Rate ($)')
                                ->numeric()
                                ->default(0)
                                ->step(0.01)
                                ->prefix('$'),
                            TextInput::make('charge')
                                ->label('Charge ($)')
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->step(0.01)
                                ->prefix('$'),
                        ]),
                ]),

            // ── 10. Extra Travel ─────────────────────────────────────────────
            Section::make('Extra Travel')
                ->description('Return trip and out-of-route fares (air, bus, ferry, etc.) — not the drive itself')
                ->schema([
                    Repeater::make('tripPlanExtraTravel')
                        ->relationship('tripPlanExtraTravel')
                        ->label('')
                        ->addActionLabel('Add travel item')
                        ->orderColumn('sort_order')
                        ->columns(3)
                        ->schema([
                            Select::make('travel_mode_id')
                                ->label('Mode')
                                ->nullable()
                                ->options(fn () => TravelMode::orderBy('name')->pluck('name', 'id')->toArray()),
                            TextInput::make('description')
                                ->label('Description')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. Return flight YKF to YVR'),
                            TextInput::make('charge')
                                ->label('Charge ($)')
                                ->numeric()
                                ->required()
                                ->default(0)
                                ->step(0.01)
                                ->prefix('$'),
                        ]),
                ]),

            // ── 11. Discount ─────────────────────────────────────────────────
            Section::make('Discount')
                ->columns(2)
                ->schema([
                    Select::make('discount_reason_id')
                        ->label('Discount Reason')
                        ->nullable()
                        ->options(fn () => DiscountReason::orderBy('name')->pluck('name', 'id')->toArray())
                        ->live(),
                    Select::make('discount_type')
                        ->label('Discount Type')
                        ->options(['flat' => 'Flat ($)', 'percent' => 'Percent (%)'])
                        ->nullable()
                        ->required(fn (Get $get) => (bool) $get('discount_reason_id'))
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('discount_value')
                        ->label('Discount Value')
                        ->numeric()
                        ->minValue(0)
                        ->step(0.01)
                        ->nullable()
                        ->required(fn (Get $get) => (bool) $get('discount_reason_id'))
                        ->prefix(fn (Get $get) => $get('discount_type') === 'percent' ? null : '$')
                        ->suffix(fn (Get $get) => $get('discount_type') === 'percent' ? '%' : null)
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('discount_amount')
                        ->label('Discount Amount')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 2) : '—'),
                ]),

            // ── 12. Tax & Totals ─────────────────────────────────────────────
            Section::make('Tax & Totals')
                ->columns(3)
                ->schema([
                    Select::make('tax_type_id')
                        ->label('Tax Type')
                        ->nullable()
                        ->options(fn () => TaxType::where('is_active', true)->pluck('name', 'id')->toArray())
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            // If quote_request is set, try to find the matching rate
                            if ($state && $qrId = $get('quote_request_id')) {
                                $qr = QuoteRequest::find($qrId);
                                $provinceId = $qr?->destination_province_id;
                                if ($provinceId) {
                                    $taxRate = TaxRate::where('tax_type_id', $state)
                                        ->where('province_id', $provinceId)
                                        ->where('is_active', true)
                                        ->whereNull('expiry_date')
                                        ->first();
                                    if ($taxRate) {
                                        $set('tax_rate', number_format($taxRate->rate_pct / 10000, 4));
                                    }
                                }
                            }
                            self::recalculate($get, $set);
                        }),
                    TextInput::make('tax_rate')
                        ->label('Tax Rate')
                        ->numeric()
                        ->required()
                        ->default(0)
                        ->step(0.0001)
                        ->minValue(0)
                        ->helperText('Decimal: e.g. 0.0500 for 5% GST')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('cc_rate')
                        ->label('CC Rate')
                        ->numeric()
                        ->required()
                        ->default(0.03)
                        ->step(0.0001)
                        ->minValue(0)
                        ->helperText('Default 3% (0.0300)')
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                    TextInput::make('line_total')
                        ->label('Line Total')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 2) : '—'),
                    TextInput::make('discount_amount_display')
                        ->label('Discount')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn (Get $get) => number_format((float) ($get('discount_amount') ?: 0), 2)),
                    TextInput::make('subtotal')
                        ->label('Subtotal (post-discount)')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 2) : '—'),
                    TextInput::make('tax_amount')
                        ->label('Tax Amount')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 2) : '—'),
                    TextInput::make('cc_fee')
                        ->label('CC Fee (3%)')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 2) : '—'),
                    TextInput::make('total')
                        ->label('Total')
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('$')
                        ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 2) : '—'),
                ]),

            // ── 13. Notes ────────────────────────────────────────────────────
            Section::make('Notes')
                ->schema([
                    Textarea::make('notes')
                        ->label('Internal Notes')
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ];
    }

    // ── Reactive Calculation Engine ──────────────────────────────────────────

    /**
     * Recalculate all derived form fields. Call from any live input's afterStateUpdated.
     * This provides live preview only — the model's computeFields() is the authoritative
     * calculation that runs on every save.
     */
    public static function recalculate(Get $get, Set $set): void
    {
        $distance  = (float) ($get('distance_km') ?: 0);
        $speed     = (float) ($get('avg_speed_kph') ?: 90);

        // ── Route ─────────────────────────────────────────────────────────────
        $detourPct = match (true) {
            $distance < 1000 => 0.05,
            $distance < 4500 => 0.10,
            default          => 0.15,
        };
        $outOfRoute = round($distance * $detourPct, 2);
        $adjusted   = round($distance + $outOfRoute, 2);

        $set('detour_pct', $detourPct);
        $set('out_of_route_km', $outOfRoute);
        $set('adjusted_distance_km', $adjusted);

        // ── Duration ──────────────────────────────────────────────────────────
        $hours = $speed > 0 ? round($adjusted / $speed, 2) : 0;
        $set('drive_hours', $hours);

        if (! $get('drive_days_override')) {
            $set('drive_days', (int) floor($hours / 12));
        }

        $nights = (int) floor($hours / 10);
        $set('nights', $nights);

        $ferry = (bool) $get('ferry_involved');
        if (! $get('extended_drive_time_override')) {
            $extDriveTime = $nights + ($ferry ? 3 : 2);
            $set('extended_drive_time', $extDriveTime);
        } else {
            $extDriveTime = (int) ($get('extended_drive_time') ?: 0);
        }

        $pickupDate = $get('pickup_date');
        if ($pickupDate && $extDriveTime > 0) {
            $set('latest_delivery_date', Carbon::parse($pickupDate)->addDays($extDriveTime)->toDateString());
        }

        // ── Fuel ──────────────────────────────────────────────────────────────
        $fuelEcon      = (float) ($get('fuel_economy_l100') ?: 12);
        $fuelPrice     = (float) ($get('fuel_price_per_litre') ?: 2);
        $estimatedFuel = round($adjusted * $fuelEcon / 100, 2);
        $fuelCost      = round($estimatedFuel * $fuelPrice, 2);

        $set('estimated_fuel_litres', $estimatedFuel);
        $set('fuel_cost', $fuelCost);

        // ── Driver ────────────────────────────────────────────────────────────
        $driverRate = (float) ($get('driver_rate_per_km') ?: 0.20);
        $driverCost = round($adjusted * $driverRate, 2);
        $set('driver_cost', $driverCost);

        // ── Accommodations & Meals ────────────────────────────────────────────
        $hotelRate  = (float) ($get('hotel_rate') ?: 150);
        $accomCost  = round($nights * $hotelRate, 2);
        $mealRate   = (float) ($get('meal_rate') ?: 15);
        $mealsPerDay = (int) ($get('meals_per_day') ?: 3);
        $mealsCost  = round($nights * $mealsPerDay * $mealRate, 2);

        $set('accommodations_cost', $accomCost);
        $set('meals_cost', $mealsCost);

        // ── Totals (direct costs only — repeater totals not available in form state) ──
        $lineTotal = round($fuelCost + $driverCost + $accomCost + $mealsCost, 2);
        $set('line_total', $lineTotal);

        // ── Discount ──────────────────────────────────────────────────────────
        $discountType  = $get('discount_type');
        $discountValue = (float) ($get('discount_value') ?: 0);
        $discountAmount = match ($discountType) {
            'flat'    => $discountValue,
            'percent' => round($lineTotal * $discountValue / 100, 2),
            default   => 0.0,
        };
        $set('discount_amount', $discountAmount);

        // ── Tax & CC ──────────────────────────────────────────────────────────
        $subtotal  = round($lineTotal - $discountAmount, 2);
        $taxRate   = (float) ($get('tax_rate') ?: 0);
        $ccRate    = (float) ($get('cc_rate') ?: 0.03);
        $taxAmount = round($subtotal * $taxRate, 2);
        $ccFee     = round($subtotal * $ccRate, 2);

        $set('subtotal', $subtotal);
        $set('tax_amount', $taxAmount);
        $set('cc_fee', $ccFee);
        $set('total', round($subtotal + $taxAmount + $ccFee, 2));
    }

    // ── Tax Helpers ──────────────────────────────────────────────────────────

    private static function taxRateForProvinceCode(string $code): ?array
    {
        static $byCode = null;

        if ($byCode === null) {
            $byCode = [];
            $rates  = TaxRate::with(['province', 'taxType'])
                ->where('is_active', true)
                ->whereNull('expiry_date')
                ->get();

            foreach ($rates as $rate) {
                $c = $rate->province?->code;
                if ($c) {
                    $byCode[$c] = [
                        'decimal'     => number_format($rate->rate_pct / 10000, 4),
                        'tax_type_id' => $rate->tax_type_id,
                    ];
                }
            }
        }

        return $byCode[$code] ?? null;
    }
}
