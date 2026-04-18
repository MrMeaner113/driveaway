<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\Contacts\Schemas\ContactForm;
use App\Models\ContactStatus;
use App\Models\StaffPosition;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected array $pendingDriverData = [];

    protected function handleRecordCreation(array $data): Model
    {
        // Capture driver fields before Contact::create() silently drops them
        $this->pendingDriverData = array_intersect_key(
            $data,
            array_flip(ContactForm::driverFields())
        );

        // Default status to Active when hidden on create
        $data['contact_status_id'] ??= ContactStatus::where('slug', 'active')->value('id');

        return parent::handleRecordCreation($data);
    }

    protected function afterCreate(): void
    {
        $isDriver = StaffPosition::find($this->record->staff_position_id)?->name === 'Driver';

        if ($isDriver && array_filter($this->pendingDriverData)) {
            $this->record->driverProfile()->create($this->pendingDriverData);
        }
    }
}
