<?php

namespace App\Filament\Resources\CorporateDetails\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CorporateDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_name')->required()->columnSpan(2),
                        TextInput::make('legal_name'),
                        TextInput::make('hst_number'),
                        TextInput::make('website')->url()->columnSpan(2),
                    ]),

                Section::make('Primary Contact')
                    ->columns(2)
                    ->schema([
                        TextInput::make('primary_contact_title'),
                        TextInput::make('phone_extension')->tel(),
                    ]),

                Section::make('Billing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('billing_contact_name'),
                        TextInput::make('billing_email')->email(),
                        TextInput::make('accounts_payable_email')->email(),
                        Select::make('payment_terms')
                            ->options([
                                'Net 15' => 'Net 15',
                                'Net 30' => 'Net 30',
                                'COD'    => 'COD',
                            ])
                            ->default('Net 30')
                            ->required(),
                    ]),

                Section::make('Notes')
                    ->schema([
                        Textarea::make('special_instructions')->columnSpanFull(),
                    ]),
            ]);
    }
}
