<?php

namespace App\Filament\Resources\AddressTypes\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('description')->limit(50)->toggleable(),
                IconColumn::make('is_active')->boolean()->label('Active'),
                TextColumn::make('sort_order')->sortable()->label('Order'),
            ])
            ->recordActions([EditAction::make()]);
    }
}
