<?php

namespace App\Filament\Resources\TripPlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TripPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quoteRequest.id')
                    ->label('Quote Request')
                    ->formatStateUsing(fn ($state, $record) => "#{$state} — {$record->quoteRequest?->full_name}")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('driver.user.name')
                    ->label('Driver')
                    ->default('—'),
                TextColumn::make('quoteRequest.origin_city_display')
                    ->label('From')
                    ->default('—'),
                TextColumn::make('quoteRequest.destination_city_display')
                    ->label('To')
                    ->default('—'),
                TextColumn::make('adjusted_distance_km')
                    ->label('Distance')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 0) . ' km')
                    ->sortable(),
                TextColumn::make('pickup_date')
                    ->label('Pickup')
                    ->date()
                    ->sortable(),
                TextColumn::make('latest_delivery_date')
                    ->label('Latest Delivery')
                    ->date()
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => '$' . number_format((float) $state, 2))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([TrashedFilter::make()])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
