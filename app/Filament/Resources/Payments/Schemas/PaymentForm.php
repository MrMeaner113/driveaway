<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('invoice_id')
                            ->relationship('invoice', 'invoice_number')
                            ->required()
                            ->searchable(),
                        Select::make('payment_method_id')
                            ->relationship('paymentMethod', 'name')
                            ->required()
                            ->preload(),
                        TextInput::make('amount')->numeric()->required()->suffix('¢'),
                        DatePicker::make('payment_date')->required(),
                        TextInput::make('reference')->nullable(),
                        Textarea::make('notes')->columnSpanFull(),
                    ]),
            ]);
    }
}
