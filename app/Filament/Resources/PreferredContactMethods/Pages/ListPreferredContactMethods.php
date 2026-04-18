<?php

namespace App\Filament\Resources\PreferredContactMethods\Pages;

use App\Filament\Resources\PreferredContactMethods\PreferredContactMethodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPreferredContactMethods extends ListRecords
{
    protected static string $resource = PreferredContactMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
