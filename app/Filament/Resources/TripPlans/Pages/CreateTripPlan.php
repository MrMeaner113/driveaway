<?php

namespace App\Filament\Resources\TripPlans\Pages;

use App\Filament\Resources\TripPlans\TripPlanResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreateTripPlan extends CreateRecord
{
    protected static string $resource = TripPlanResource::class;

    public function form(Schema $schema): Schema
    {
        return parent::form($schema)
            ->extraAttributes([
                'x-on:keydown.enter' => "event.target.tagName !== 'TEXTAREA' "
                    . "&& event.target.type !== 'submit' "
                    . "&& event.preventDefault()",
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        // After HasMany repeaters are saved, recalculate to include add-on and extra travel totals
        $this->record->recalculate();
    }
}
