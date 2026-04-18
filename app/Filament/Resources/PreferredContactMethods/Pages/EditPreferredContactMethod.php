<?php

namespace App\Filament\Resources\PreferredContactMethods\Pages;

use App\Filament\Resources\PreferredContactMethods\PreferredContactMethodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPreferredContactMethod extends EditRecord
{
    protected static string $resource = PreferredContactMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
