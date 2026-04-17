<?php

namespace App\Filament\Resources\TripPlans\Schemas;

use App\Models\AddOnService;
use App\Models\FuelType;
use App\Models\InsuranceRate;
use App\Models\QuoteRequest;
use App\Models\TaxRate;
use App\Models\TransportPlateRate;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class TripPlanForm
{
    public static function schema(): array
    {
        return [
            // ── Section 1: Quote Request ─────────────────────────────────────
            Section::make('Quote Request')
                ->schema([
                    Select::make('quote_request_id')
                        ->label('Quote Request')
                        ->searchable()
                        ->required()
                        ->options(function () {
                            static $qrOptions = null;
                            $qrOptions ??= QuoteRequest::whereIn('status', ['new', 'reviewed', 'quoted'])
                                ->get()
                                ->mapWithKeys(fn ($qr) => [$qr->id => "#{$qr->id} — {$qr->full_name}"])
                                ->toArray();
                            return $qrOptions;
                        })
                        ->default(fn () => ($id = request('quote_request_id')) ? (int) $id : null),
                ]),

            // ── Section 2: Route ─────────────────────────────────────────────
            Section::make('Route')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('origin_display')
                                ->label('Origin')
                                ->getStateUsing(function ($record) {
                                    $qr = $record?->quoteRequest
                                        ?? (request('quote_request_id')
                                            ? \App\Models\QuoteRequest::find((int) request('quote_request_id'))
                                            : null);
                                    return $qr
                                        ? $qr->origin_city_display . ', ' . $qr->origin_province_display
                                        : '—';
                                })
                                ->dehydrated(false),
                            TextEntry::make('destination_display')
                                ->label('Destination')
                            ->getStateUsing(function ($record) {
                                $qr = $record?->quoteRequest
                                    ?? (request('quote_request_id')
                                        ? \App\Models\QuoteRequest::find((int) request('quote_request_id'))
                                        : null);
                                return $qr
                                    ? $qr->destination_city_display . ', ' . $qr->destination_province_display
                                    : '—';
                            })
                                ->dehydrated(false),
                        ]),
                ]),

            // ── Section 3: Distance ──────────────────────────────────────────
            Section::make('Distance')
                ->columns(3)
                ->schema([
                    TextInput::make('distance_km')
                        ->label('Distance')
                        ->numeric()
                        ->required()
                        ->suffix('km'),
                    TextInput::make('detour_buffer_pct')
                        ->label('Detour buffer')
                        ->numeric()
                        ->default(5)
                        ->suffix('%')
                        ->helperText('Added to distance for detours'),
                    TextEntry::make('adjusted_distance_km')
                        ->label('Adjusted distance')
                        ->getStateUsing(fn ($record) => $record ? number_format($record->adjusted_distance_km) . ' km' : '—')
                        ->dehydrated(false),
                ]),

            // ── Section 4: Timing ────────────────────────────────────────────
            Section::make('Timing')
                ->schema([
                    // Row 1 — inputs
                    Grid::make(3)
                        ->schema([
                            TextInput::make('speed_kmh')
                                ->label('Average speed')
                                ->numeric()
                                ->default(90)
                                ->suffix('km/h'),
                            TextInput::make('drive_hours_per_day')
                                ->label('Drive hours / day')
                                ->numeric()
                                ->default(10)
                                ->suffix('hrs'),
                            TextInput::make('delay_day_per_km')
                                ->label('Delay: 1 buffer day per X km')
                                ->numeric()
                                ->default(2000),
                        ]),
                    // Row 2 — computed
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('km_per_day')
                                ->label('Km per day')
                                ->getStateUsing(fn ($record) => $record ? number_format($record->km_per_day) . ' km' : '—')
                                ->dehydrated(false),
                            TextEntry::make('drive_days')
                                ->label('Drive days')
                                ->getStateUsing(fn ($record) => $record ? $record->drive_days . ' days' : '—')
                                ->dehydrated(false),
                            TextEntry::make('delay_days')
                                ->label('Delay days')
                                ->getStateUsing(fn ($record) => $record ? $record->delay_days . ' days' : '—')
                                ->dehydrated(false),
                        ]),
                    // Row 3 — computed
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('total_days')
                                ->label('Total days (drive + buffer)')
                                ->getStateUsing(fn ($record) => $record ? $record->total_days . ' days' : '—')
                                ->dehydrated(false),
                            TextEntry::make('hotel_nights')
                                ->label('Hotel nights (drive days only)')
                                ->getStateUsing(fn ($record) => $record ? $record->hotel_nights . ' nights' : '—')
                                ->dehydrated(false),
                        ]),
                ]),

            // ── Section 5: Fuel ──────────────────────────────────────────────
            Section::make('Fuel')
                ->columns(2)
                ->schema([
                    Select::make('fuel_type_id')
                        ->label('Fuel type')
                        ->nullable()
                        ->searchable()
                        ->options(function () {
                            static $fuelOptions = null;
                            $fuelOptions ??= FuelType::where('is_active', true)
                                ->orderBy('sort_order')
                                ->pluck('name', 'id')
                                ->toArray();
                            return $fuelOptions;
                        }),
                    TextInput::make('fuel_economy_per_100km')
                        ->label('Fuel economy')
                        ->numeric()
                        ->default(10)
                        ->step(0.1)
                        ->suffix('L/100km'),
                    TextInput::make('avg_fuel_price_cents')
                        ->label('Avg fuel price')
                        ->prefix('$')
                        ->suffix('/L')
                        ->step(0.01)
                        ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : '')
                        ->dehydrateStateUsing(fn ($state) => $state ? (int) round($state * 100) : 0),
                    TextEntry::make('fuel_cost_cents')
                        ->label('Fuel cost')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->fuel_cost_cents / 100, 2) : '—')
                        ->dehydrated(false),
                ]),

            // ── Section 6: Driver & Accommodation ───────────────────────────
            Section::make('Driver & Accommodation')
                ->columns(2)
                ->schema([
                    TextInput::make('driver_rate_cents_per_km')
                        ->label('Driver rate')
                        ->prefix('$')
                        ->suffix('/km')
                        ->step(0.01)
                        ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : '0.50')
                        ->dehydrateStateUsing(fn ($state) => $state ? (int) round($state * 100) : 50),
                    TextEntry::make('driver_cost_cents')
                        ->label('Driver cost')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->driver_cost_cents / 100, 2) : '—')
                        ->dehydrated(false),
                    TextInput::make('hotel_rate_cents')
                        ->label('Hotel rate / night')
                        ->prefix('$')
                        ->step(0.01)
                        ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : '150.00')
                        ->dehydrateStateUsing(fn ($state) => $state ? (int) round($state * 100) : 15000),
                    TextEntry::make('hotel_cost_cents')
                        ->label('Hotel cost (drive days only)')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->hotel_cost_cents / 100, 2) : '—')
                        ->dehydrated(false),
                    TextInput::make('meal_cost_cents')
                        ->label('Meal cost')
                        ->prefix('$')
                        ->step(0.01)
                        ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : '20.00')
                        ->dehydrateStateUsing(fn ($state) => $state ? (int) round($state * 100) : 2000),
                    TextInput::make('meals_per_day')
                        ->label('Meals / day')
                        ->numeric()
                        ->default(3),
                    TextEntry::make('meal_cost_total_cents')
                        ->label('Meal cost (drive days only)')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->meal_cost_total_cents / 100, 2) : '—')
                        ->dehydrated(false),
                ]),

            // ── Section 7: Insurance & Plates ────────────────────────────────
            Section::make('Insurance & Plates')
                ->columns(2)
                ->schema([
                    Select::make('insurance_rate_id')
                        ->label('Insurance rate')
                        ->nullable()
                        ->searchable()
                        ->options(function () {
                            static $ins = null;
                            $ins ??= InsuranceRate::with('vehicleCategory')
                                ->get()
                                ->mapWithKeys(fn ($r) => [$r->id => $r->vehicleCategory->name . ' — $' . number_format($r->daily_rate / 100, 2) . '/day'])
                                ->toArray();
                            return $ins;
                        }),
                    TextInput::make('insurance_cost_override_cents')
                        ->label('Override daily rate ($)')
                        ->prefix('$')
                        ->nullable()
                        ->step(0.01)
                        ->helperText('Leave blank to use the selected rate. Enter a value to override for this job.')
                        ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : '')
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? (int) round((float) $state * 100) : null),
                    TextEntry::make('insurance_cost_cents')
                        ->label('Insurance cost (total days)')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->insurance_cost_cents / 100, 2) : '—')
                        ->dehydrated(false),
                    Select::make('transport_plate_rate_id')
                        ->label('Transport plate rate')
                        ->nullable()
                        ->searchable()
                        ->options(function () {
                            static $plates = null;
                            $plates ??= TransportPlateRate::with('vehicleCategory')
                                ->get()
                                ->mapWithKeys(fn ($r) => [$r->id => $r->vehicleCategory->name . ' — $' . number_format($r->daily_rate / 100, 2) . '/day'])
                                ->toArray();
                            return $plates;
                        }),
                    TextInput::make('transport_plate_cost_override_cents')
                        ->label('Override daily rate ($)')
                        ->prefix('$')
                        ->nullable()
                        ->step(0.01)
                        ->helperText('Leave blank to use the selected rate. Enter a value to override for this job.')
                        ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : '')
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? (int) round((float) $state * 100) : null),
                    TextEntry::make('transport_plate_cost_cents')
                        ->label('Transport plate cost (total days)')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->transport_plate_cost_cents / 100, 2) : '—')
                        ->dehydrated(false),
                ]),

            // ── Section 8: Extras ────────────────────────────────────────────
            Section::make('Extras')
                ->schema([
                    TextInput::make('tolls_and_ferry_cents')
                        ->label('Tolls / ferry')
                        ->prefix('$')
                        ->numeric()
                        ->default(0)
                        ->step(0.01)
                        ->formatStateUsing(fn ($state) => number_format(($state ?? 0) / 100, 2))
                        ->dehydrateStateUsing(fn ($state) => (int) round($state * 100)),
                ]),

            // ── Section 9: Add-On Services ───────────────────────────────────
            Section::make('Add-On Services')
                ->schema([
                    Repeater::make('addOnServices')
                        ->label('Add-On Services')
                        ->default([])
                        ->addActionLabel('Add service')
                        ->reorderable(false)
                        ->columns(3)
                        ->schema([
                            Select::make('add_on_service_id')
                                ->label('Service')
                                ->required()
                                ->options(function () {
                                    static $aos = null;
                                    $aos ??= AddOnService::where('is_active', true)
                                        ->orderBy('sort_order')
                                        ->get()
                                        ->mapWithKeys(fn ($s) => [
                                            $s->id => $s->name . ' (' . match ($s->rate_type) {
                                                'per_km'  => 'Per km',
                                                'per_day' => 'Per day',
                                                default   => 'Flat fee',
                                            } . ')',
                                        ])
                                        ->toArray();
                                    return $aos;
                                }),
                            TextInput::make('quantity')
                                ->label('Qty')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required(),
                            TextInput::make('calculated_cost_cents')
                                ->label('Charge ($)')
                                ->prefix('$')
                                ->default(0)
                                ->step(0.01)
                                ->helperText('Auto-calculated on save. Override by entering a value.')
                                ->formatStateUsing(fn ($state) => number_format(($state ?? 0) / 100, 2))
                                ->dehydrateStateUsing(fn ($state) => (int) round($state * 100)),
                            TextEntry::make('rate_type')
                                ->label('Rate type')
                                ->hiddenOn('create')
                                ->getStateUsing(fn ($state) => match ($state) {
                                    'flat'    => 'Flat fee',
                                    'per_km'  => 'Per km',
                                    'per_day' => 'Per day',
                                    default   => '—',
                                })
                                ->dehydrated(false),
                            TextEntry::make('unit_cost_cents')
                                ->label('Base rate')
                                ->hiddenOn('create')
                                ->getStateUsing(fn ($state) => $state !== null ? '$' . number_format($state / 100, 4) : '—')
                                ->dehydrated(false),
                        ]),
                ]),

            // ── Section 10: Tax & Totals ─────────────────────────────────────
            Section::make('Tax & Totals')
                ->columns(2)
                ->schema([
                    Select::make('tax_rate')
                        ->label('Tax rate (destination province)')
                        ->required()
                        ->searchable()
                        ->options(fn () => self::getTaxRateOptions())
                        ->default(function () {
                            $qrId = request('quote_request_id');
                            $qr   = $qrId ? QuoteRequest::find((int) $qrId) : null;
                            $code = $qr?->destinationProvince?->code;
                            return $code ? self::federalTaxRateForProvinceCode($code) : '0.1300';
                        })
                        ->formatStateUsing(function ($state, $record) {
                            if (! $state) return '0.1300';
                            $pct = number_format((float)$state * 100, 0);
                            $type = in_array((float)$state, [0.13, 0.14, 0.15]) ? 'HST' : 'GST';
                            
                            // Get province code from record or URL param
                            $qr = $record?->quoteRequest
                                ?? (request('quote_request_id') 
                                    ? \App\Models\QuoteRequest::find((int)request('quote_request_id')) 
                                    : null);
                            $code = $qr?->destinationProvince?->code ?? '';
                            
                            return $code 
                                ? "{$code} — {$pct}% {$type}"
                                : "{$pct}% {$type}";
                        })
                        ->label('Notes')
                        ->nullable()
                        ->columnSpanFull(),
                    TextEntry::make('subtotal_cents')
                        ->label('Subtotal')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->subtotal_cents / 100, 2) : '—')
                        ->dehydrated(false),
                    TextEntry::make('tax_amount_cents')
                        ->label('Tax')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->tax_amount_cents / 100, 2) : '—')
                        ->dehydrated(false),
                    TextEntry::make('total_cents')
                        ->label('Total quote price')
                        ->hiddenOn('create')
                        ->getStateUsing(fn ($record) => $record ? '$' . number_format($record->total_cents / 100, 2) : '—')
                        ->dehydrated(false),
                ]),
        ];
    }

    // ── Tax helpers ──────────────────────────────────────────────────────────

    private static function getTaxRateOptions(): array
    {
        static $options = null;
        if ($options !== null) {
            return $options;
        }

        $rates = TaxRate::with('province')
            ->whereIn('tax_type_id', [1, 2])
            ->whereIn('province_id', range(1, 13))
            ->where('is_active', true)
            ->whereNull('expiry_date')
            ->orderBy('rate_pct')
            ->get();

        $grouped = [];
        foreach ($rates as $rate) {
            $key                        = $rate->rate_pct;
            $grouped[$key]['codes'][]   = $rate->province->code;
            $grouped[$key]['rate_pct']  = $rate->rate_pct;
            $grouped[$key]['type']      = $rate->tax_type_id === 2 ? 'HST' : 'GST';
        }

        $options = [];
        foreach ($grouped as $rate_pct => $data) {
            $pct               = number_format($data['rate_pct'] / 100, 0);
            $codes             = implode(', ', $data['codes']);
            $decimal           = number_format($data['rate_pct'] / 10000, 4);
            $options[$decimal] = "{$codes} — {$pct}% {$data['type']}";
        }

        ksort($options);
        return $options;
    }

    private static function federalTaxRateForProvinceCode(string $code): string
    {
        static $byCode = null;
        if ($byCode !== null) {
            return $byCode[$code] ?? '0.1300';
        }

        $rates = TaxRate::with('province')
            ->whereIn('tax_type_id', [1, 2])
            ->whereIn('province_id', range(1, 13))
            ->where('is_active', true)
            ->whereNull('expiry_date')
            ->get();

        $byCode = [];
        foreach ($rates as $rate) {
            $byCode[$rate->province->code] = number_format($rate->rate_pct / 10000, 4);
        }

        return $byCode[$code] ?? '0.1300';
    }
}
