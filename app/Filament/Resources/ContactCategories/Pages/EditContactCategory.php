<?php

namespace App\Filament\Resources\ContactCategories\Pages;

use App\Filament\Resources\ContactCategories\ContactCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactCategory extends EditRecord
{
    protected static string $resource = ContactCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
