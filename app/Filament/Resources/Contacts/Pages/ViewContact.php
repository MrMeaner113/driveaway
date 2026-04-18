<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\Contacts\Schemas\ContactForm;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $profile = $this->record->driverProfile;
        if ($profile) {
            foreach (ContactForm::driverFields() as $field) {
                $data[$field] = $profile->$field ?? null;
            }
        }
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
