<?php

namespace App\Filament\Resources\FuelExpenses\Pages;

use App\Filament\Resources\FuelExpenses\FuelExpenseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFuelExpense extends ViewRecord
{
    protected static string $resource = FuelExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
