<?php

namespace App\Filament\Resources\Quotes\Schemas;

use App\Models\Contact;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Quote Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('quote_number')->required(),
                        Select::make('quote_status_id')
                            ->relationship('status', 'name')
                            ->required()
                            ->preload(),
                        Select::make('contact_id')
                            ->relationship('contact', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn (Contact $record) => "{$record->first_name} {$record->last_name}")
                            ->required()
                            ->searchable(),
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->nullable(),
                        DatePicker::make('expires_at'),
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

                Section::make('Pricing (all amounts in cents)')
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
                        TextInput::make('estimated_distance')->numeric()->default(0),
                        TextInput::make('rate_per_unit')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('estimated_fuel')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('estimated_accommodations')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('estimated_add_ons')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('subtotal')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('tax_amount')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('total')->numeric()->default(0)->suffix('¢'),
                    ]),

                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')->columnSpanFull(),
                    ]),
            ]);
    }
}
