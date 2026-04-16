<?php

namespace App\Filament\Resources\TransportPlateRates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransportPlateRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('vehicle_category_id')
                ->relationship('vehicleCategory', 'name')
                ->label('Vehicle Category')
                ->required()
                ->preload()
                ->searchable(),
            TextInput::make('daily_rate')
                ->label('Daily Rate ($)')
                ->required()
                ->numeric()
                ->minValue(0)
                ->step(0.01)
                ->prefix('$')
                ->dehydrateStateUsing(fn ($state) => (int) round($state * 100))
                ->formatStateUsing(fn ($state) => $state ? number_format($state / 100, 2) : null),
            DatePicker::make('effective_date')
                ->required(),
        ]);
    }
}
