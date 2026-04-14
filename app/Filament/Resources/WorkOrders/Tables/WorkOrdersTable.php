<?php

namespace App\Filament\Resources\WorkOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class WorkOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('work_order_number')->searchable()->sortable(),
                TextColumn::make('status.name')->label('Status')->badge(),
                TextColumn::make('originProvince.name')->label('From')->toggleable(),
                TextColumn::make('destinationProvince.name')->label('To')->toggleable(),
                TextColumn::make('scheduled_pickup')->label('Pickup')->date()->sortable(),
                TextColumn::make('scheduled_delivery')->label('Delivery')->date()->sortable()->toggleable(),
                TextColumn::make('actual_pickup')->label('Actual Pickup')->date()->sortable()->toggleable(),
                TextColumn::make('actual_delivery')->label('Actual Delivery')->date()->sortable()->toggleable(),
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
