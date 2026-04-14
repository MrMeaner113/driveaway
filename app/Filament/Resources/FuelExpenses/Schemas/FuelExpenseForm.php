<?php

namespace App\Filament\Resources\FuelExpenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FuelExpenseForm
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
                        Select::make('fuel_vendor_id')
                            ->relationship('fuelVendor', 'name')
                            ->label('Fuel Vendor')
                            ->required()
                            ->searchable(),
                        Select::make('fuel_type_id')
                            ->relationship('fuelType', 'name')
                            ->label('Fuel Type')
                            ->required()
                            ->preload(),
                        Select::make('fuel_unit_id')
                            ->relationship('fuelUnit', 'name')
                            ->label('Unit')
                            ->required()
                            ->preload(),
                        TextInput::make('quantity')->numeric()->required(),
                        TextInput::make('amount')->numeric()->required()->suffix('¢'),
                        DatePicker::make('receipt_date')->required(),
                        Select::make('receipt_type_id')
                            ->relationship('receiptType', 'name')
                            ->required()
                            ->preload(),
                        Select::make('payment_method_id')
                            ->relationship('paymentMethod', 'name')
                            ->required()
                            ->preload(),
                        Toggle::make('is_reimbursable')->default(true),
                        Textarea::make('notes')->columnSpanFull(),
                        // cra_t2125_id defaults to 18 — hidden from driver-facing forms, visible here for office staff
                        Select::make('cra_t2125_id')
                            ->relationship('craLine', 'name')
                            ->label('CRA T2125 Line')
                            ->required()
                            ->default(18)
                            ->preload(),
                    ]),
            ]);
    }
}
