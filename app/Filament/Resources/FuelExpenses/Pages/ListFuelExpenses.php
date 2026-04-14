<?php

namespace App\Filament\Resources\FuelExpenses\Pages;

use App\Filament\Resources\FuelExpenses\FuelExpenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFuelExpenses extends ListRecords
{
    protected static string $resource = FuelExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
