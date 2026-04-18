<?php

namespace App\Filament\Resources\ContactCategories\Pages;

use App\Filament\Resources\ContactCategories\ContactCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactCategory extends CreateRecord
{
    protected static string $resource = ContactCategoryResource::class;
}
