<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuelExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'fuelExpenses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('driver_id')
                ->relationship('driver.user', 'name')
                ->label('Driver')
                ->required(),
            Select::make('fuel_vendor_id')
                ->relationship('fuelVendor', 'name')
                ->label('Fuel Vendor')
                ->required(),
            Select::make('fuel_type_id')
                ->relationship('fuelType', 'name')
                ->label('Fuel Type')
                ->required(),
            Select::make('fuel_unit_id')
                ->relationship('fuelUnit', 'name')
                ->label('Unit')
                ->required(),
            TextInput::make('quantity')
                ->numeric()
                ->required()
                ->step(0.001),
            TextInput::make('amount')
                ->numeric()
                ->required()
                ->suffix('¢')
                ->label('Amount (cents)'),
            DatePicker::make('receipt_date')
                ->required(),
            Select::make('receipt_type_id')
                ->relationship('receiptType', 'name')
                ->label('Receipt Type')
                ->required(),
            Select::make('payment_method_id')
                ->relationship('paymentMethod', 'name')
                ->label('Payment Method')
                ->required(),
            Toggle::make('is_reimbursable')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('receipt_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('driver.user.name')
                    ->label('Driver')
                    ->searchable(),
                TextColumn::make('fuelVendor.name')
                    ->label('Vendor'),
                TextColumn::make('fuelType.name')
                    ->label('Fuel'),
                TextColumn::make('quantity')
                    ->numeric(3),
                TextColumn::make('amount')
                    ->suffix('¢')
                    ->sortable(),
                IconColumn::make('is_reimbursable')
                    ->boolean()
                    ->label('Reimb.'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([SoftDeletingScope::class]));
    }
}
