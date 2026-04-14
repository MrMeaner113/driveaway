<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')->searchable()->sortable(),
                TextColumn::make('workOrder.work_order_number')->label('Work Order')->searchable(),
                TextColumn::make('contact.first_name')->label('Client')->searchable(),
                TextColumn::make('organization.name')->label('Organization')->toggleable()->searchable(),
                TextColumn::make('invoice_date')->date()->sortable(),
                TextColumn::make('due_date')->date()->sortable()->toggleable(),
                TextColumn::make('total')->label('Total (¢)')->numeric()->sortable(),
                IconColumn::make('paid_at')->label('Paid')->boolean()->getStateUsing(fn ($record) => (bool) $record->paid_at),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('invoice_date', 'desc')
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
