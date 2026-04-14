<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('first_name')->required(),
                        TextInput::make('last_name')->required(),
                        TextInput::make('email')->email()->columnSpan(2),
                        TextInput::make('phone')->tel(),
                        TextInput::make('phone_ext')->label('Ext.'),
                        TextInput::make('mobile')->tel()->columnSpan(2),
                    ]),

                Section::make('Classification')
                    ->columns(2)
                    ->schema([
                        Select::make('contact_type_id')
                            ->relationship('contactType', 'name')
                            ->required()
                            ->preload(),
                        Select::make('contact_status_id')
                            ->relationship('contactStatus', 'name')
                            ->required()
                            ->preload(),
                        Select::make('preferred_contact_method_id')
                            ->relationship('preferredContactMethod', 'name')
                            ->preload(),
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable(),
                    ]),

                Section::make('Notes & Status')
                    ->columns(2)
                    ->schema([
                        Textarea::make('notes')->columnSpan(2),
                        Toggle::make('is_active')->default(true),
                    ]),
            ]);
    }
}
