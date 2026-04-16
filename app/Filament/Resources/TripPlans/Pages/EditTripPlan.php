<?php

namespace App\Filament\Resources\TripPlans\Pages;

use App\Filament\Resources\TripPlans\TripPlanResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditTripPlan extends EditRecord
{
    protected static string $resource = TripPlanResource::class;

    /** Pivot rows captured before save; synced in afterSave(). */
    protected array $pendingAddOnServices = [];

    /**
     * Load pivot rows back into the repeater so add-on services appear on edit.
     * Also includes rate_type and unit_cost_cents so the read-only Placeholders
     * in the repeater are populated.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['addOnServices'] = $this->record
            ->addOnServices
            ->map(fn ($service) => [
                'add_on_service_id'     => $service->id,
                'quantity'              => $service->pivot->quantity,
                'calculated_cost_cents' => $service->pivot->calculated_cost_cents,
                'rate_type'             => $service->pivot->rate_type,
                'unit_cost_cents'       => $service->pivot->unit_cost_cents,
            ])
            ->values()
            ->toArray();

        return $data;
    }

    /**
     * Strip the repeater array so it is never passed to TripPlan::fill()/save().
     * The pivot rows are synced separately in afterSave().
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->pendingAddOnServices = $data['addOnServices'] ?? [];
        unset($data['addOnServices']);

        return $data;
    }

    protected function afterSave(): void
    {
        $syncData = [];

        foreach ($this->pendingAddOnServices as $item) {
            $serviceId = $item['add_on_service_id'] ?? null;

            if (! $serviceId) {
                continue;
            }

            $syncData[(int) $serviceId] = [
                'quantity'              => (int) ($item['quantity'] ?? 1),
                // dehydrateStateUsing already converted the display value to cents
                'calculated_cost_cents' => (int) ($item['calculated_cost_cents'] ?? 0),
            ];
        }

        try {
            $this->record->addOnServices()->sync($syncData);
        } catch (\Throwable $e) {
            Log::error('TripPlan addOnServices sync failed (edit)', [
                'trip_plan_id' => $this->record->id,
                'error'        => $e->getMessage(),
            ]);
        }
    }
}
