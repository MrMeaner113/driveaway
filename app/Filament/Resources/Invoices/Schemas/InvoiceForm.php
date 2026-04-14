<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Contact;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('invoice_number')->required(),
                        Select::make('work_order_id')
                            ->relationship('workOrder', 'work_order_number')
                            ->required()
                            ->searchable(),
                        Select::make('contact_id')
                            ->relationship('contact', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn (Contact $record) => "{$record->first_name} {$record->last_name}")
                            ->required()
                            ->searchable(),
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->nullable(),
                        DatePicker::make('invoice_date')->required(),
                        DatePicker::make('due_date'),
                        DateTimePicker::make('paid_at')->nullable(),
                    ]),

                Section::make('Financials (amounts in cents)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('subtotal')->numeric()->default(0)->suffix('¢'),
                        TextInput::make('tax_rate_bps')->label('Tax Rate (basis pts)')->numeric()->default(0)->helperText('e.g. 1300 = 13.00%'),
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
