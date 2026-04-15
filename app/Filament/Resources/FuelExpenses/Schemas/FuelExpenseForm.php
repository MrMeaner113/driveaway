<?php

namespace App\Filament\Resources\FuelExpenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FuelExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('work_order_id')
                            ->relationship('workOrder', 'work_order_number')
                            ->label('Work Order')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('vehicle_id')
                            ->relationship('vehicle', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => trim("{$record->year} {$record->make?->name} {$record->model?->name}"))
                            ->label('Vehicle')
                            ->required()
                            ->searchable(),

                        Select::make('driver_id')
                            ->relationship('driver', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->user?->name ?? "Driver #{$record->id}")
                            ->label('Driver')
                            ->nullable()
                            ->searchable(),

                        DatePicker::make('fuel_date')
                            ->required(),

                        TextInput::make('litres')
                            ->numeric()
                            ->required()
                            ->step(0.01)
                            ->suffix('L'),

                        TextInput::make('cost_per_litre')
                            ->label('Cost per Litre')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.0001)
                            ->required()
                            ->afterStateHydrated(fn ($component, $state) =>
                                $component->state($state !== null ? number_format($state / 100, 4, '.', '') : null)
                            )
                            ->dehydrateStateUsing(fn ($state) => $state !== null ? (int) round((float) $state * 100) : null),

                        TextInput::make('total_cost')
                            ->label('Total Cost (auto-calculated)')
                            ->prefix('$')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(fn ($component, $state) =>
                                $component->state($state !== null ? number_format($state / 100, 2, '.', '') : null)
                            ),

                        TextInput::make('odometer_reading')
                            ->label('Odometer (km)')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('station_name')
                            ->label('Station Name')
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
