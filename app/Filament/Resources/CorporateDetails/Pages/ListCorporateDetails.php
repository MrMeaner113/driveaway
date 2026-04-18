<?php

namespace App\Filament\Resources\CorporateDetails\Pages;

use App\Filament\Resources\CorporateDetails\CorporateDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCorporateDetails extends ListRecords
{
    protected static string $resource = CorporateDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
