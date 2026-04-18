<?php

namespace App\Filament\Resources\ContactTypes\Pages;

use App\Filament\Resources\ContactTypes\ContactTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactType extends EditRecord
{
    protected static string $resource = ContactTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
