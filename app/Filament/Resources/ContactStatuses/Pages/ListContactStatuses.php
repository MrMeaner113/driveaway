<?php

namespace App\Filament\Resources\ContactStatuses\Pages;

use App\Filament\Resources\ContactStatuses\ContactStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactStatuses extends ListRecords
{
    protected static string $resource = ContactStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
