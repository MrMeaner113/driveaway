<?php

namespace App\Filament\Resources\TripPlans\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TripPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quoteRequest.id')
                    ->label('Quote Request')
                    ->formatStateUsing(fn ($state, $record) => "#{$state} — {$record->quoteRequest->full_name}")
                    ->searchable(),
                TextColumn::make('adjusted_distance_km')
                    ->label('Distance (km)')
                    ->formatStateUsing(fn ($state) => number_format($state) . ' km'),
                TextColumn::make('total_days')
                    ->label('Total Days'),
                TextColumn::make('total_cents')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2)),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
