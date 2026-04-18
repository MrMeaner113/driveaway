<?php

namespace App\Filament\Resources\ContactTypes\Pages;

use App\Filament\Resources\ContactTypes\ContactTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactType extends CreateRecord
{
    protected static string $resource = ContactTypeResource::class;
}
