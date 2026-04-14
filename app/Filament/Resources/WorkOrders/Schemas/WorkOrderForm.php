<?php

namespace App\Filament\Resources\WorkOrders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Work Order Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('work_order_number')->required(),
                        Select::make('work_order_status_id')
                            ->relationship('status', 'name')
                            ->required()
                            ->preload(),
                        Select::make('quote_id')
                            ->relationship('quote', 'quote_number')
                            ->searchable()
                            ->nullable(),
                        Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->label('Created By')
                            ->required(),
                    ]),

                Section::make('Route')
                    ->columns(2)
                    ->schema([
                        Select::make('origin_city_id')
                            ->relationship('originCity', 'name')
                            ->label('Origin City')
                            ->required()
                            ->searchable(),
                        Select::make('origin_province_id')
                            ->relationship('originProvince', 'name')
                            ->label('Origin Province')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('destination_city_id')
                            ->relationship('destinationCity', 'name')
                            ->label('Destination City')
                            ->required()
                            ->searchable(),
                        Select::make('destination_province_id')
                            ->relationship('destinationProvince', 'name')
                            ->label('Destination Province')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                Section::make('Schedule')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('scheduled_pickup')->required(),
                        DatePicker::make('scheduled_delivery'),
                        DatePicker::make('actual_pickup'),
                        DatePicker::make('actual_delivery'),
                    ]),

                Section::make('Pricing (amounts in cents)')
                    ->columns(2)
                    ->schema([
                        Select::make('rate_type_id')
                            ->relationship('rateType', 'name')
                            ->required()
                            ->preload(),
                        Select::make('distance_unit_id')
                            ->relationship('distanceUnit', 'name')
                            ->required()
                            ->preload(),
                        TextInput::make('distance')->numeric()->default(0),
                        TextInput::make('rate_per_unit')->numeric()->default(0)->suffix('¢'),
                    ]),

                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')->columnSpanFull(),
                    ]),
            ]);
    }
}
