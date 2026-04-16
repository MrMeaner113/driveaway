<?php

namespace App\Filament\Resources\QuoteRequests\Schemas;

use App\Models\VehicleCategory;
use App\Models\VehicleMake;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuoteRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('first_name')->required(),
                        TextInput::make('last_name')->required(),
                        TextInput::make('email')->email(),
                        TextInput::make('phone')->tel(),
                    ]),

                Section::make('Origin')
                    ->columns(3)
                    ->schema([
                        Select::make('origin_country_id')
                            ->relationship('originCountry', 'name')
                            ->label('Country')
                            ->required()
                            ->preload()
                            ->searchable(),
                        Select::make('origin_province_id')
                            ->relationship('originProvince', 'name')
                            ->label('Province / State')
                            ->required()
                            ->searchable(),
                        Select::make('origin_city_id')
                            ->relationship('originCity', 'name')
                            ->label('City')
                            ->required()
                            ->searchable(),
                    ]),

                Section::make('Destination')
                    ->columns(3)
                    ->schema([
                        Select::make('destination_country_id')
                            ->relationship('destinationCountry', 'name')
                            ->label('Country')
                            ->required()
                            ->preload()
                            ->searchable(),
                        Select::make('destination_province_id')
                            ->relationship('destinationProvince', 'name')
                            ->label('Province / State')
                            ->required()
                            ->searchable(),
                        Select::make('destination_city_id')
                            ->relationship('destinationCity', 'name')
                            ->label('City')
                            ->required()
                            ->searchable(),
                    ]),

                Section::make('Vehicles')
                    ->schema([
                        Select::make('vehicle_category_id')
                            ->label('Vehicle Category')
                            ->options(VehicleCategory::pluck('name', 'id'))
                            ->nullable()
                            ->searchable()
                            ->helperText('Assign category during review'),
                        Repeater::make('vehicles')
                            ->relationship('vehicles')
                            ->schema([
                                TextInput::make('vehicle_year')
                                    ->label('Year')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(date('Y') + 2)
                                    ->required(),
                                TextInput::make('vehicle_make')
                                    ->label('Make')
                                    ->datalist(fn () => VehicleMake::where('is_active', true)
                                        ->orderBy('name')
                                        ->pluck('name')
                                        ->toArray())
                                    ->required(),
                                TextInput::make('vehicle_model')
                                    ->label('Model')
                                    ->required(),

                                // ── Post-acceptance details ──────────────
                                Section::make('Post-Acceptance Details')
                                    ->columnSpanFull()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('vehicle_vin')
                                            ->label('VIN')
                                            ->nullable()
                                            ->maxLength(50),
                                        TextInput::make('vehicle_colour')
                                            ->label('Colour')
                                            ->nullable()
                                            ->maxLength(50),
                                        TextInput::make('license_plate')
                                            ->label('License Plate')
                                            ->nullable()
                                            ->maxLength(20),
                                        TextInput::make('license_province')
                                            ->label('License Province/State')
                                            ->nullable()
                                            ->maxLength(10),
                                        Toggle::make('is_licensed')
                                            ->label('Currently Licensed')
                                            ->default(true),
                                        Toggle::make('requires_transport_plates')
                                            ->label('Requires Transport Plates')
                                            ->default(false),
                                        TextInput::make('mileage')
                                            ->label('Mileage (km)')
                                            ->numeric()
                                            ->nullable(),
                                        Textarea::make('modifications')
                                            ->label('Modifications')
                                            ->nullable()
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columns(3)
                            ->minItems(1)
                            ->defaultItems(1)
                            ->reorderable(false),
                    ]),

                Section::make('Add-on Services')
                    ->schema([
                        Select::make('addOnServices')
                            ->relationship('addOnServices', 'name')
                            ->multiple()
                            ->preload(),
                    ]),

                Section::make('Details')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('preferred_date'),
                        Select::make('status')
                            ->options([
                                'new'      => 'New',
                                'reviewed' => 'Reviewed',
                                'quoted'   => 'Quoted',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                                'expired'  => 'Expired',
                            ])
                            ->required(),
                        Textarea::make('notes')->columnSpanFull(),
                        Textarea::make('notes_internal')
                            ->label('Internal Notes (staff only — never shown to client)')
                            ->helperText('Visible to staff only')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
