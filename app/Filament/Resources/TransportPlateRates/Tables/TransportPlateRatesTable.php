<?php

namespace App\Filament\Resources\TransportPlateRates\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransportPlateRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleCategory.name')->label('Category')->sortable(),
                TextColumn::make('daily_rate')
                    ->label('Daily Rate')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2)),
                TextColumn::make('effective_date')->date()->sortable(),
            ])
            ->actions([EditAction::make()]);
    }
}
