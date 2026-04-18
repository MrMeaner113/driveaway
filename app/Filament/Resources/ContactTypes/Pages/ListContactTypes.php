<?php

namespace App\Filament\Resources\ContactTypes\Pages;

use App\Filament\Resources\ContactTypes\ContactTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactTypes extends ListRecords
{
    protected static string $resource = ContactTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
