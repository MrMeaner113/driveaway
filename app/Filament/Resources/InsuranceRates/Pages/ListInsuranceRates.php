<?php

namespace App\Filament\Resources\InsuranceRates\Pages;

use App\Filament\Resources\InsuranceRates\InsuranceRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInsuranceRates extends ListRecords
{
    protected static string $resource = InsuranceRateResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
