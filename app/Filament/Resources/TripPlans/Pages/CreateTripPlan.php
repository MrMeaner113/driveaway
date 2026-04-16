<?php

namespace App\Filament\Resources\TripPlans\Pages;

use App\Filament\Resources\TripPlans\TripPlanResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;

class CreateTripPlan extends CreateRecord
{
    protected static string $resource = TripPlanResource::class;

    /** Pivot rows captured before model creation; synced in afterCreate(). */
    protected array $pendingAddOnServices = [];

    /**
     * Prevent Enter key from submitting the form when focus is inside a text
     * input.  The Alpine handler is placed on the Schema container so it
     * intercepts bubbling keydown events from every field in the form.
     */
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

        // Strip the repeater array so it is never passed to TripPlan::create().
        // The pivot rows are synced separately in afterCreate().
        $this->pendingAddOnServices = $data['addOnServices'] ?? [];
        unset($data['addOnServices']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (empty($this->pendingAddOnServices)) {
            return;
        }

        $syncData = [];

        foreach ($this->pendingAddOnServices as $item) {
            $serviceId = $item['add_on_service_id'] ?? null;

            if (! $serviceId) {
                continue; // skip rows where no service was selected
            }

            $syncData[(int) $serviceId] = [
                'quantity'              => (int) ($item['quantity'] ?? 1),
                // dehydrateStateUsing already converted the display value to cents
                'calculated_cost_cents' => (int) ($item['calculated_cost_cents'] ?? 0),
            ];
        }

        if ($syncData) {
            try {
                $this->record->addOnServices()->sync($syncData);
            } catch (\Throwable $e) {
                Log::error('TripPlan addOnServices sync failed (create)', [
                    'trip_plan_id' => $this->record->id,
                    'error'        => $e->getMessage(),
                ]);
            }
        }
    }
}
