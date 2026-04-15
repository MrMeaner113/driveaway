<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
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
                            ->label('Work Order')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('expense_category_id')
                            ->relationship('category', 'name')
                            ->label('Category')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('driver_id')
                            ->relationship('driver', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->user?->name ?? "Driver #{$record->id}")
                            ->label('Driver')
                            ->nullable()
                            ->searchable(),

                        Select::make('vehicle_id')
                            ->relationship('vehicle', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => trim("{$record->year} {$record->make?->name} {$record->model?->name}"))
                            ->label('Vehicle')
                            ->nullable()
                            ->searchable(),

                        TextInput::make('description')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->required()
                            ->afterStateHydrated(fn ($component, $state) =>
                                $component->state($state !== null ? number_format($state / 100, 2, '.', '') : null)
                            )
                            ->dehydrateStateUsing(fn ($state) => $state !== null ? (int) round((float) $state * 100) : null),

                        DatePicker::make('expense_date')
                            ->required(),

                        FileUpload::make('receipt_path')
                            ->label('Receipt')
                            ->directory('receipts/expenses')
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
