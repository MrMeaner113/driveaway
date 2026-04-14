<?php

namespace App\Filament\Resources\Vehicles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')->sortable(),
                TextColumn::make('make.name')->label('Make')->sortable()->searchable(),
                TextColumn::make('model.name')->label('Model')->sortable()->searchable(),
                TextColumn::make('color')->searchable(),
                TextColumn::make('vin')->label('VIN')->searchable()->toggleable(),
                TextColumn::make('driveline.name')->label('Driveline')->toggleable(),
                TextColumn::make('fuelType.name')->label('Fuel')->toggleable(),
                TextColumn::make('odometer')->suffix(' km')->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([TrashedFilter::make()])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
