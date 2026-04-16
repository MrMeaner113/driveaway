<?php

namespace App\Filament\Widgets;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkOrderExpenseSummaryWidget extends BaseWidget
{
    use InteractsWithRecord;

    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $record = $this->getRecord();

        if (! $record) {
            return [];
        }

        $expensesTotal  = $record->expenses()->sum('amount');
        $fuelTotal      = $record->fuelExpenses()->sum('total_cost');
        $combinedTotal  = $expensesTotal + $fuelTotal;

        return [
            Stat::make('Total Expenses', '$' . number_format($expensesTotal / 100, 2))
                ->description('General expense records'),

            Stat::make('Total Fuel Costs', '$' . number_format($fuelTotal / 100, 2))
                ->description('Fuel expense records'),

            Stat::make('Combined Total', '$' . number_format($combinedTotal / 100, 2))
                ->description('All expenses combined'),
        ];
    }
}
