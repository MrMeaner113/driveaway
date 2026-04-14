<?php

namespace App\Filament\Resources\Drivers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class DriversTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Name')->sortable()->searchable(),
                TextColumn::make('license_number')->label('Licence #')->searchable(),
                TextColumn::make('license_class')->label('Class'),
                TextColumn::make('issuingJurisdiction.name')->label('Jurisdiction')->toggleable(),
                TextColumn::make('license_expiry')->label('Licence Expiry')->date()->sortable(),
                IconColumn::make('has_air_brakes')->label('Air')->boolean(),
                IconColumn::make('has_passenger')->label('Pass.')->boolean(),
                IconColumn::make('manual_shift')->label('Manual')->boolean(),
                TextColumn::make('medical_cert_expiry')->label('Medical Expiry')->date()->sortable()->toggleable(),
            ])
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
