<?php

namespace App\Filament\Resources\QuoteRequests\Pages;

use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use App\Filament\Resources\QuoteRequests\Schemas\QuoteRequestInfolist;
use App\Models\City;
use App\Models\Province;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Services\QuotePromotionService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewQuoteRequest extends ViewRecord
{
    protected static string $resource = QuoteRequestResource::class;

    // ── Status helpers ───────────────────────────────────────────────────────

    private static function statusColor(string $status): string
    {
        return QuoteRequestInfolist::statusColor($status);
    }

    private static function statusLabel(string $status): string
    {
        return QuoteRequestInfolist::statusLabel($status);
    }

    // ── Header actions ───────────────────────────────────────────────────────

    protected function getHeaderActions(): array
    {
        return [
            // ── Change Status dropdown ────────────────────────────────────

            ActionGroup::make([
                $this->changeStatusAction('new'),
                $this->changeStatusAction('in_progress'),
                $this->changeStatusAction('on_hold'),
                $this->changeStatusAction('sent'),
                $this->acceptedStatusAction(),
                $this->reasonStatusAction('rejected'),
                $this->reasonStatusAction('cancelled'),
                $this->changeStatusAction('expired'),
                $this->changeStatusAction('converted'),
            ])
                ->label('Change Status')
                ->icon('heroicon-o-arrow-path')
                ->color(fn (): string => static::statusColor($this->record?->status ?? 'new'))
                ->button()
                ->visible(fn (): bool => $this->record && ! $this->record->isTerminal()),

            EditAction::make(),

            // ── Unresolved city resolution actions ────────────────────────

            Action::make('addOriginCity')
                ->label('Add Origin City to Lookup')
                ->icon('heroicon-o-map-pin')
                ->color('warning')
                ->visible(fn () => $this->record && filled($this->record->origin_city_custom) && ! $this->record->origin_city_id)
                ->modalHeading('Add Origin City to Cities Table')
                ->schema(fn () => [
                    TextInput::make('name')
                        ->label('City Name')
                        ->default($this->record->origin_city_custom)
                        ->required()
                        ->maxLength(150),
                    Select::make('province_id')
                        ->label('Province / State')
                        ->options(Province::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                        ->default($this->record->origin_province_id)
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $city = City::create([
                        'name'        => $data['name'],
                        'province_id' => $data['province_id'],
                        'is_active'   => true,
                    ]);
                    $this->record->update([
                        'origin_city_id'     => $city->id,
                        'origin_city_custom' => null,
                    ]);
                    Notification::make()->success()->title('City added and linked.')->send();
                    $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                }),

            Action::make('matchOriginCity')
                ->label('Match Origin City')
                ->icon('heroicon-o-magnifying-glass')
                ->color('warning')
                ->visible(fn () => $this->record && filled($this->record->origin_city_custom) && ! $this->record->origin_city_id)
                ->modalHeading('Match Origin City to Existing Record')
                ->modalDescription(fn () => "Custom value entered: \"{$this->record->origin_city_custom}\"")
                ->schema([
                    Select::make('city_id')
                        ->label('Select Matching City')
                        ->options(City::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'origin_city_id'     => $data['city_id'],
                        'origin_city_custom' => null,
                    ]);
                    Notification::make()->success()->title('Origin city linked.')->send();
                    $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                }),

            Action::make('addDestinationCity')
                ->label('Add Destination City to Lookup')
                ->icon('heroicon-o-map-pin')
                ->color('warning')
                ->visible(fn () => $this->record && filled($this->record->destination_city_custom) && ! $this->record->destination_city_id)
                ->modalHeading('Add Destination City to Cities Table')
                ->schema(fn () => [
                    TextInput::make('name')
                        ->label('City Name')
                        ->default($this->record->destination_city_custom)
                        ->required()
                        ->maxLength(150),
                    Select::make('province_id')
                        ->label('Province / State')
                        ->options(Province::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                        ->default($this->record->destination_province_id)
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $city = City::create([
                        'name'        => $data['name'],
                        'province_id' => $data['province_id'],
                        'is_active'   => true,
                    ]);
                    $this->record->update([
                        'destination_city_id'     => $city->id,
                        'destination_city_custom' => null,
                    ]);
                    Notification::make()->success()->title('City added and linked.')->send();
                    $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                }),

            Action::make('matchDestinationCity')
                ->label('Match Destination City')
                ->icon('heroicon-o-magnifying-glass')
                ->color('warning')
                ->visible(fn () => $this->record && filled($this->record->destination_city_custom) && ! $this->record->destination_city_id)
                ->modalHeading('Match Destination City to Existing Record')
                ->modalDescription(fn () => "Custom value entered: \"{$this->record->destination_city_custom}\"")
                ->schema([
                    Select::make('city_id')
                        ->label('Select Matching City')
                        ->options(City::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'destination_city_id'     => $data['city_id'],
                        'destination_city_custom' => null,
                    ]);
                    Notification::make()->success()->title('Destination city linked.')->send();
                    $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                }),

            // ── Unresolved vehicle make/model resolution actions ──────────

            ...$this->buildVehicleResolutionActions(),
        ];
    }

    // ── Change Status action builders ────────────────────────────────────────

    /**
     * Simple status change — just updates status + the appropriate timestamp.
     * Used for statuses that need no extra user input.
     */
    private function changeStatusAction(string $status): Action
    {
        $label = static::statusLabel($status);
        $color = static::statusColor($status);

        return Action::make("setStatus_{$status}")
            ->label($label)
            ->color($color)
            ->requiresConfirmation()
            ->modalHeading("Set status to \"{$label}\"")
            ->modalDescription(fn () => "Current status: " . static::statusLabel($this->record->status))
            ->visible(fn () => $this->record && $this->record->status !== $status)
            ->action(function () use ($status) {
                $payload = ['status' => $status];

                if (in_array($status, ['in_progress', 'on_hold'])) {
                    $payload['reviewed_at'] = $this->record->reviewed_at ?? now();
                } elseif ($status === 'sent') {
                    $payload['quoted_at'] = $this->record->quoted_at ?? now();
                } elseif ($status === 'expired') {
                    $payload['expired_at'] = $this->record->expired_at ?? now();
                }

                $this->record->update($payload);

                Notification::make()
                    ->success()
                    ->title('Status updated to ' . static::statusLabel($status) . '.')
                    ->send();

                $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
            });
    }

    /**
     * The Accepted action — delegates to QuotePromotionService which creates
     * Contact, Quote, and WorkOrder and stamps accepted_at internally.
     */
    private function acceptedStatusAction(): Action
    {
        return Action::make('setStatus_accepted')
            ->label('Accepted')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Accept Quote Request')
            ->modalDescription('This will create a Contact, Quote, and Work Order from this request. This action cannot be undone.')
            ->visible(fn () => $this->record && $this->record->status !== 'accepted')
            ->action(function () {
                try {
                    app(QuotePromotionService::class)->promote($this->record);
                } catch (\LogicException $e) {
                    Notification::make()
                        ->danger()
                        ->title('Cannot accept this request.')
                        ->body($e->getMessage())
                        ->send();
                    return;
                }

                Notification::make()
                    ->success()
                    ->title('Quote request accepted.')
                    ->body('Contact, Quote, and Work Order have been created.')
                    ->send();

                $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
            });
    }

    /**
     * Rejected / Cancelled — both show an optional reason textarea and
     * stamp rejected_at. Reason is stored in the rejected_reason column.
     */
    private function reasonStatusAction(string $status): Action
    {
        $label = static::statusLabel($status);

        return Action::make("setStatus_{$status}")
            ->label($label)
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading("Set status to \"{$label}\"")
            ->schema([
                Textarea::make('rejected_reason')
                    ->label('Reason (optional)')
                    ->maxLength(1000),
            ])
            ->visible(fn () => $this->record && $this->record->status !== $status)
            ->action(function (array $data) use ($status, $label) {
                $this->record->update([
                    'status'          => $status,
                    'rejected_at'     => $this->record->rejected_at ?? now(),
                    'rejected_reason' => $data['rejected_reason'] ?? null,
                ]);

                Notification::make()
                    ->success()
                    ->title("Status updated to {$label}.")
                    ->send();

                $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
            });
    }

    // ── Vehicle resolution actions ───────────────────────────────────────────

    /**
     * Dynamically build one pair of Add/Match actions for each vehicle
     * that has an unresolved make or model custom value.
     */
    private function buildVehicleResolutionActions(): array
    {
        $actions = [];

        foreach ($this->record->vehicles as $vehicle) {
            $vid = $vehicle->id;

            // ── Make ──────────────────────────────────────────────────────
            if (filled($vehicle->vehicle_make_custom) && ! $vehicle->vehicle_make_id) {
                $actions[] = Action::make("addMake_{$vid}")
                    ->label("Add Make: {$vehicle->vehicle_make_custom}")
                    ->icon('heroicon-o-truck')
                    ->color('warning')
                    ->modalHeading("Add \"{$vehicle->vehicle_make_custom}\" to Vehicle Makes")
                    ->schema(fn () => [
                        TextInput::make('name')
                            ->label('Make Name')
                            ->default($vehicle->vehicle_make_custom)
                            ->required()
                            ->maxLength(100),
                    ])
                    ->action(function (array $data) use ($vid) {
                        $make = VehicleMake::create(['name' => $data['name'], 'is_active' => true]);
                        \App\Models\QuoteRequestVehicle::where('id', $vid)->update([
                            'vehicle_make_id'     => $make->id,
                            'vehicle_make_custom' => null,
                        ]);
                        Notification::make()->success()->title('Make added and linked.')->send();
                        $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                    });

                $actions[] = Action::make("matchMake_{$vid}")
                    ->label("Match Make: {$vehicle->vehicle_make_custom}")
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('warning')
                    ->modalHeading("Match \"{$vehicle->vehicle_make_custom}\" to Existing Make")
                    ->schema([
                        Select::make('make_id')
                            ->label('Select Make')
                            ->options(VehicleMake::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) use ($vid) {
                        \App\Models\QuoteRequestVehicle::where('id', $vid)->update([
                            'vehicle_make_id'     => $data['make_id'],
                            'vehicle_make_custom' => null,
                        ]);
                        Notification::make()->success()->title('Vehicle make linked.')->send();
                        $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                    });
            }

            // ── Model ─────────────────────────────────────────────────────
            if (filled($vehicle->vehicle_model_custom) && ! $vehicle->vehicle_model_id) {
                $actions[] = Action::make("addModel_{$vid}")
                    ->label("Add Model: {$vehicle->vehicle_model_custom}")
                    ->icon('heroicon-o-truck')
                    ->color('warning')
                    ->modalHeading("Add \"{$vehicle->vehicle_model_custom}\" to Vehicle Models")
                    ->schema(fn () => [
                        TextInput::make('name')
                            ->label('Model Name')
                            ->default($vehicle->vehicle_model_custom)
                            ->required()
                            ->maxLength(100),
                        Select::make('vehicle_make_id')
                            ->label('Make')
                            ->options(VehicleMake::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                            ->default($vehicle->vehicle_make_id)
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) use ($vid) {
                        $model = VehicleModel::create([
                            'name'            => $data['name'],
                            'vehicle_make_id' => $data['vehicle_make_id'],
                            'is_active'       => true,
                        ]);
                        \App\Models\QuoteRequestVehicle::where('id', $vid)->update([
                            'vehicle_model_id'     => $model->id,
                            'vehicle_model_custom' => null,
                        ]);
                        Notification::make()->success()->title('Model added and linked.')->send();
                        $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                    });

                $actions[] = Action::make("matchModel_{$vid}")
                    ->label("Match Model: {$vehicle->vehicle_model_custom}")
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('warning')
                    ->modalHeading("Match \"{$vehicle->vehicle_model_custom}\" to Existing Model")
                    ->schema([
                        Select::make('model_id')
                            ->label('Select Model')
                            ->options(VehicleModel::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) use ($vid) {
                        \App\Models\QuoteRequestVehicle::where('id', $vid)->update([
                            'vehicle_model_id'     => $data['model_id'],
                            'vehicle_model_custom' => null,
                        ]);
                        Notification::make()->success()->title('Vehicle model linked.')->send();
                        $this->redirect(QuoteRequestResource::getUrl('view', ['record' => $this->record]));
                    });
            }
        }

        return $actions;
    }

    // ── Unresolved-fields helpers (used by infolist) ─────────────────────────

    public function hasUnresolvedFields(): bool
    {
        return $this->record->hasUnresolvedFields();
    }

    public function getUnresolvedSummary(): array
    {
        $items = [];

        if (filled($this->record->origin_city_custom) && ! $this->record->origin_city_id) {
            $items[] = "Origin city: \"{$this->record->origin_city_custom}\"";
        }
        if (filled($this->record->origin_province_custom) && ! $this->record->origin_province_id) {
            $items[] = "Origin province: \"{$this->record->origin_province_custom}\"";
        }
        if (filled($this->record->destination_city_custom) && ! $this->record->destination_city_id) {
            $items[] = "Destination city: \"{$this->record->destination_city_custom}\"";
        }
        if (filled($this->record->destination_province_custom) && ! $this->record->destination_province_id) {
            $items[] = "Destination province: \"{$this->record->destination_province_custom}\"";
        }

        foreach ($this->record->vehicles as $v) {
            if (filled($v->vehicle_make_custom) && ! $v->vehicle_make_id) {
                $items[] = "Vehicle make: \"{$v->vehicle_make_custom}\" ({$v->vehicle_year})";
            }
            if (filled($v->vehicle_model_custom) && ! $v->vehicle_model_id) {
                $items[] = "Vehicle model: \"{$v->vehicle_model_custom}\" ({$v->vehicle_year})";
            }
        }

        return $items;
    }
}
