<?php

namespace App\Filament\Resources\QuoteRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuoteRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('originProvince.name')
                    ->label('From')
                    ->sortable(),
                TextColumn::make('destinationProvince.name')
                    ->label('To')
                    ->sortable(),
                TextColumn::make('vehicles_count')
                    ->label('Vehicles')
                    ->counts('vehicles')
                    ->alignCenter(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'new'      => 'warning',
                        'reviewed' => 'info',
                        'quoted'   => 'primary',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'expired'  => 'gray',
                        default    => 'gray',
                    }),
                // Warning badge shown when any city/province/vehicle field is unresolved custom text
                IconColumn::make('has_unresolved_fields')
                    ->label('')
                    ->icon('heroicon-m-exclamation-triangle')
                    ->color('warning')
                    ->tooltip('Contains unverified cities or vehicles')
                    ->boolean()
                    ->trueIcon('heroicon-m-exclamation-triangle')
                    ->falseIcon('')
                    ->getStateUsing(fn ($record) => $record->hasUnresolvedFields()),
                TextColumn::make('preferred_date')
                    ->label('Preferred Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
