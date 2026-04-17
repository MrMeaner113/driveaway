<?php

namespace App\Filament\Resources\TripPlans\Pages;

use App\Filament\Resources\TripPlans\TripPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTripPlan extends EditRecord
{
    protected static string $resource = TripPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // After HasMany repeaters are saved, recalculate to include add-on and extra travel totals
        $this->record->recalculate();
    }
}
