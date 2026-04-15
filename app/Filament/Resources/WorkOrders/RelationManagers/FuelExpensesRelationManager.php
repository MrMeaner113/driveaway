<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use App\Models\Vehicle;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuelExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'fuelExpenses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
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
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('station_name')
            ->columns([
                TextColumn::make('fuel_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('vehicle.id')
                    ->label('Vehicle')
                    ->formatStateUsing(fn ($record) => trim("{$record->vehicle?->year} {$record->vehicle?->make?->name} {$record->vehicle?->model?->name}")),

                TextColumn::make('driver.user.name')
                    ->label('Driver')
                    ->toggleable(),

                TextColumn::make('litres')
                    ->numeric(2)
                    ->suffix(' L'),

                TextColumn::make('cost_per_litre')
                    ->label('Cost/L')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 4)),

                TextColumn::make('total_cost')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2))
                    ->sortable()
                    ->summarize(
                        Sum::make()
                            ->label('Subtotal')
                            ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2))
                    ),

                TextColumn::make('odometer_reading')
                    ->label('Odometer')
                    ->suffix(' km')
                    ->toggleable(),
            ])
            ->defaultSort('fuel_date', 'desc')
            ->filters([
                SelectFilter::make('vehicle_id')
                    ->label('Vehicle')
                    ->options(
                        Vehicle::orderBy('id')
                            ->get()
                            ->mapWithKeys(fn ($v) => [$v->id => trim("{$v->year} {$v->make?->name} {$v->model?->name}")])
                    ),
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([SoftDeletingScope::class]));
    }
}
