<?php

namespace App\Filament\Resources\TripPlans\Pages;

use App\Filament\Resources\TripPlans\TripPlanResource;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTripPlan extends ViewRecord
{
    protected static string $resource = TripPlanResource::class;

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
