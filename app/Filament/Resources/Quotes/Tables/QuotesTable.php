<?php

namespace App\Filament\Resources\Quotes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class QuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quote_number')->searchable()->sortable(),
                TextColumn::make('contact.first_name')->label('Client')->searchable(),
                TextColumn::make('organization.name')->label('Organization')->toggleable()->searchable(),
                TextColumn::make('originProvince.name')->label('From')->toggleable(),
                TextColumn::make('destinationProvince.name')->label('To')->toggleable(),
                TextColumn::make('status.name')->label('Status')->badge(),
                TextColumn::make('total')->label('Total (¢)')->numeric()->sortable(),
                TextColumn::make('expires_at')->label('Expires')->date()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([TrashedFilter::make()])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
