<?php

namespace App\Filament\Resources\Quotes\Schemas;

use App\Models\Contact;
use App\Models\DiscountReason;
use App\Models\TripPlan;
use App\Models\VehicleCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Quote Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('quote_number')->required(),
                        Select::make('quote_status_id')
                            ->relationship('status', 'name')
                            ->required()
                            ->preload(),
                        Select::make('contact_id')
                            ->relationship('contact', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn (Contact $record) => "{$record->first_name} {$record->last_name}")
                            ->required()
                            ->searchable(),
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->nullable(),
                        DatePicker::make('expires_at'),
                        Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->label('Created By')
                            ->required(),
                    ]),

                Section::make('Route')
                    ->columns(2)
                    ->schema([
                        Select::make('origin_city_id')
                            ->relationship('originCity', 'name')
                            ->label('Origin City')
                            ->required()
                            ->searchable(),
                        Select::make('origin_province_id')
                            ->relationship('originProvince', 'name')
                            ->label('Origin Province')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('destination_city_id')
                            ->relationship('destinationCity', 'name')
                            ->label('Destination City')
                            ->required()
                            ->searchable(),
                        Select::make('destination_province_id')
                            ->relationship('destinationProvince', 'name')
                            ->label('Destination Province')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                Section::make('Pricing (all amounts in cents)')
                    ->columns(2)
                    ->schema([
                        Select::make('rate_type_id')
                            ->relationship('rateType', 'name')
                            ->required()
                            ->preload(),
                        Select::make('distance_unit_id')
                            ->relationship('distanceUnit', 'name')
                            ->required()
                            ->preload(),
                        TextInput::make('estimated_distance')->numeric()->default(0),
                        TextInput::make('rate_per_unit')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('estimated_fuel')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('estimated_accommodations')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('estimated_add_ons')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('subtotal')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('tax_amount')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('total')->numeric()->default(0)->suffix('¢'),
                    ]),

                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')->columnSpanFull(),
                    ]),

                Section::make('Pricing')
                    ->columns(2)
                    ->schema([
                        // Trip plan suggested total (read-only)
                        Placeholder::make('trip_plan_suggested_total')
                            ->label('Trip Plan Suggested Total')
                            ->content(fn ($record) => $record?->tripPlan
                                ? '$' . number_format($record->tripPlan->total_cents / 100, 2)
                                : 'No trip plan linked'),

                        Select::make('trip_plan_id')
                            ->label('Trip Plan')
                            ->options(fn ($record) => TripPlan::when($record, fn ($q) =>
                                    $q->where('quote_request_id', $record->quote_request_id ?? null)
                                )
                                ->get()
                                ->mapWithKeys(fn ($p) => [
                                    $p->id => "#{$p->id} — " . '$' . number_format($p->total_cents / 100, 2),
                                ]))
                            ->nullable()
                            ->searchable(),

                        Select::make('vehicle_category_id')
                            ->label('Vehicle Category')
                            ->options(VehicleCategory::pluck('name', 'id'))
                            ->nullable()
                            ->searchable(),

                        Select::make('discount_type')
                            ->label('Discount Type')
                            ->options([
                                'percentage' => 'Percentage',
                                'flat'       => 'Flat Amount',
                            ])
                            ->nullable()
                            ->live(),

                        TextInput::make('discount_value')
                            ->label(fn ($get) => $get('discount_type') === 'percentage'
                                ? 'Discount % (basis points, e.g. 1000 = 10%)'
                                : 'Discount Amount ($)')
                            ->numeric()
                            ->nullable()
                            ->visible(fn ($get) => filled($get('discount_type')))
                            ->dehydrateStateUsing(fn ($state, $get) =>
                                $get('discount_type') === 'flat'
                                    ? (int) round($state * 100)
                                    : (int) $state
                            )
                            ->formatStateUsing(fn ($state, $get) =>
                                ($get('discount_type') === 'flat' && $state)
                                    ? number_format($state / 100, 2)
                                    : $state
                            ),

                        Select::make('discount_reason_id')
                            ->label('Discount Reason')
                            ->options(DiscountReason::pluck('name', 'id'))
                            ->nullable()
                            ->visible(fn ($get) => filled($get('discount_type'))),

                        Placeholder::make('discount_amount_cents')
                            ->label('Computed Discount')
                            ->content(fn ($record) => $record
                                ? '$' . number_format($record->discount_amount_cents / 100, 2)
                                : '—')
                            ->visible(fn ($get) => filled($get('discount_type'))),

                        Placeholder::make('final_price')
                            ->label('Final Price (after discount + tax)')
                            ->content(fn ($record) => $record
                                ? '$' . number_format(($record->total - $record->discount_amount_cents) / 100, 2)
                                : '—'),
                    ]),
            ]);
    }
}
