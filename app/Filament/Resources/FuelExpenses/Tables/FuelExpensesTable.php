<?php

namespace App\Filament\Resources\FuelExpenses\Tables;

use App\Models\Vehicle;
use App\Models\WorkOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FuelExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('workOrder.work_order_number')
                    ->label('Work Order')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vehicle.id')
                    ->label('Vehicle')
                    ->formatStateUsing(fn ($record) => trim("{$record->vehicle?->year} {$record->vehicle?->make?->name} {$record->vehicle?->model?->name}"))
                    ->searchable(),

                TextColumn::make('driver.user.name')
                    ->label('Driver')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('litres')
                    ->numeric(2)
                    ->suffix(' L')
                    ->sortable(),

                TextColumn::make('cost_per_litre')
                    ->label('Cost/L')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 4))
                    ->sortable(),

                TextColumn::make('total_cost')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2))
                    ->sortable(),

                TextColumn::make('fuel_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('odometer_reading')
                    ->label('Odometer')
                    ->numeric()
                    ->suffix(' km')
                    ->toggleable(),

                TextColumn::make('station_name')
                    ->label('Station')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('fuel_date', 'desc')
            ->filters([
                SelectFilter::make('work_order_id')
                    ->label('Work Order')
                    ->options(WorkOrder::orderBy('work_order_number')->pluck('work_order_number', 'id'))
                    ->searchable(),

                SelectFilter::make('vehicle_id')
                    ->label('Vehicle')
                    ->options(
                        Vehicle::orderBy('id')
                            ->get()
                            ->mapWithKeys(fn ($v) => [$v->id => trim("{$v->year} {$v->make?->name} {$v->model?->name}")])
                    )
                    ->searchable(),

                Filter::make('date_range')
                    ->label('Date Range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('From'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('fuel_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('fuel_date', '<=', $date));
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
