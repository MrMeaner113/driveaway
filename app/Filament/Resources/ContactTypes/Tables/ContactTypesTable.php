<?php

namespace App\Filament\Resources\ContactTypes\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('category.name')->label('Category')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('slug')->label('Slug'),
                IconColumn::make('is_active')->boolean()->label('Active'),
                TextColumn::make('sort_order')->sortable()->label('Order'),
            ])
            ->recordActions([EditAction::make()]);
    }
}
