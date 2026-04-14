<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('vehicle_make_id')
                            ->relationship('make', 'name')
                            ->label('Make')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('vehicle_model_id')
                            ->relationship('model', 'name')
                            ->label('Model')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('year')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 2),
                        TextInput::make('color')->required(),
                        TextInput::make('vin')->label('VIN')->nullable(),
                        Select::make('driveline_id')
                            ->relationship('driveline', 'name')
                            ->required()
                            ->preload(),
                        Select::make('fuel_type_id')
                            ->relationship('fuelType', 'name')
                            ->label('Fuel Type')
                            ->required()
                            ->preload(),
                        TextInput::make('odometer')
                            ->numeric()
                            ->suffix('km')
                            ->default(0),
                        Toggle::make('is_active')->default(true),
                    ]),
            ]);
    }
}
