<?php

namespace App\Filament\Resources\ContactStatuses\Pages;

use App\Filament\Resources\ContactStatuses\ContactStatusResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactStatus extends CreateRecord
{
    protected static string $resource = ContactStatusResource::class;
}
