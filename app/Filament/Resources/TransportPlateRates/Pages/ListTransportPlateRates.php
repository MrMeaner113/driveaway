<?php

namespace App\Filament\Resources\TransportPlateRates\Pages;

use App\Filament\Resources\TransportPlateRates\TransportPlateRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransportPlateRates extends ListRecords
{
    protected static string $resource = TransportPlateRateResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
