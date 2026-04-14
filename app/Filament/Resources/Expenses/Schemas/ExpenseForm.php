<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('work_order_id')
                            ->relationship('workOrder', 'work_order_number')
                            ->required()
                            ->searchable(),
                        Select::make('driver_id')
                            ->relationship('driver', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name ?? "Driver #{$record->id}")
                            ->required()
                            ->searchable(),
                        Select::make('expense_category_id')
                            ->relationship('category', 'name')
                            ->label('Category')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('vendor_id')
                            ->relationship('vendor', 'name')
                            ->searchable()
                            ->nullable(),
                        Select::make('receipt_type_id')
                            ->relationship('receiptType', 'name')
                            ->required()
                            ->preload(),
                        Select::make('payment_method_id')
                            ->relationship('paymentMethod', 'name')
                            ->required()
                            ->preload(),
                        TextInput::make('amount')->numeric()->required()->suffix('¢'),
                        DatePicker::make('receipt_date')->required(),
                        Toggle::make('is_reimbursable')->default(true),
                        Textarea::make('notes')->columnSpanFull(),
                    ]),
            ]);
    }
}
