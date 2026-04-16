<?php

namespace App\Filament\Resources\InsuranceRates\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InsuranceRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleCategory.name')->label('Category')->sortable(),
                TextColumn::make('daily_rate')
                    ->label('Daily Rate')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2)),
                IconColumn::make('requires_transport_plates')
                    ->label('Requires Plates')
                    ->boolean(),
            ])
            ->actions([EditAction::make()]);
    }
}
