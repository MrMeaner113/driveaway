<?php

namespace App\Filament\Resources\ContactStatuses\Pages;

use App\Filament\Resources\ContactStatuses\ContactStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactStatus extends EditRecord
{
    protected static string $resource = ContactStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
