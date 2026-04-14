<?php

namespace App\Filament\Resources\FuelExpenses\Pages;

use App\Filament\Resources\FuelExpenses\FuelExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFuelExpense extends CreateRecord
{
    protected static string $resource = FuelExpenseResource::class;
}
