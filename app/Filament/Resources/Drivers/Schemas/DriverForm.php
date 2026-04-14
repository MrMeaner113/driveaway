<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Account')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('User')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                Section::make('Licence')
                    ->columns(2)
                    ->schema([
                        TextInput::make('license_number')->label('Licence Number')->required(),
                        TextInput::make('license_class')->label('Licence Class')->required(),
                        Select::make('issuing_jurisdiction_id')
                            ->relationship('issuingJurisdiction', 'name')
                            ->label('Issuing Province/State')
                            ->required()
                            ->searchable()
                            ->preload(),
                        DatePicker::make('license_expiry')->label('Licence Expiry')->required(),
                    ]),

                Section::make('Endorsements & Medical')
                    ->columns(3)
                    ->schema([
                        Toggle::make('has_air_brakes')->label('Air Brakes'),
                        Toggle::make('has_passenger')->label('Passenger'),
                        Toggle::make('manual_shift')->label('Manual Shift'),
                        DatePicker::make('medical_cert_expiry')->label('Medical Cert Expiry'),
                        DatePicker::make('abstract_date')->label('Abstract Date'),
                        Textarea::make('restrictions')->columnSpanFull(),
                    ]),
            ]);
    }
}
