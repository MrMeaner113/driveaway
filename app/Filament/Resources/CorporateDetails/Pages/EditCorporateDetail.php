<?php

namespace App\Filament\Resources\CorporateDetails\Pages;

use App\Filament\Resources\CorporateDetails\CorporateDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCorporateDetail extends EditRecord
{
    protected static string $resource = CorporateDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
