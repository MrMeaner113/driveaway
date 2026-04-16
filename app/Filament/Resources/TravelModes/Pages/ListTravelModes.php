<?php

namespace App\Filament\Resources\TravelModes\Pages;

use App\Filament\Resources\TravelModes\TravelModeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTravelModes extends ListRecords
{
    protected static string $resource = TravelModeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
