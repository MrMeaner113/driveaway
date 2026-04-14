<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('workOrder.work_order_number')->label('Work Order')->searchable(),
                TextColumn::make('driver.user.name')->label('Driver')->searchable(),
                TextColumn::make('category.name')->label('Category')->searchable(),
                TextColumn::make('vendor.name')->label('Vendor')->toggleable()->searchable(),
                TextColumn::make('amount')->label('Amount (¢)')->numeric()->sortable(),
                TextColumn::make('receipt_date')->date()->sortable(),
                TextColumn::make('receiptType.name')->label('Receipt')->toggleable(),
                TextColumn::make('paymentMethod.name')->label('Payment')->toggleable(),
                IconColumn::make('is_reimbursable')->label('Reimb.')->boolean(),
            ])
            ->defaultSort('receipt_date', 'desc')
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
