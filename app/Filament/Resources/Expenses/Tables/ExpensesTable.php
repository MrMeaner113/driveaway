<?php

namespace App\Filament\Resources\Expenses\Tables;

use App\Models\ExpenseCategory;
use App\Models\WorkOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('workOrder.work_order_number')
                    ->label('Work Order')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->searchable(),

                TextColumn::make('driver.user.name')
                    ->label('Driver')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2))
                    ->sortable(),

                TextColumn::make('expense_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('recordedBy.name')
                    ->label('Recorded By')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('expense_date', 'desc')
            ->filters([
                SelectFilter::make('expense_category_id')
                    ->label('Category')
                    ->options(ExpenseCategory::orderBy('name')->pluck('name', 'id')),

                SelectFilter::make('work_order_id')
                    ->label('Work Order')
                    ->options(WorkOrder::orderBy('work_order_number')->pluck('work_order_number', 'id'))
                    ->searchable(),

                Filter::make('date_range')
                    ->label('Date Range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('From'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('expense_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('expense_date', '<=', $date));
                    }),

                TrashedFilter::make(),
            ])
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
