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
use Filament\Forms\Components\Textarea;
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

class ExpensesRelationManager extends RelationManager
{
    protected static string $relationship = 'expenses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('driver_id')
                ->relationship('driver.user', 'name')
                ->label('Driver')
                ->required(),
            Select::make('expense_category_id')
                ->relationship('category', 'name')
                ->label('Category')
                ->required(),
            Select::make('vendor_id')
                ->relationship('vendor', 'name')
                ->label('Vendor')
                ->nullable(),
            Select::make('receipt_type_id')
                ->relationship('receiptType', 'name')
                ->label('Receipt Type')
                ->required(),
            Select::make('payment_method_id')
                ->relationship('paymentMethod', 'name')
                ->label('Payment Method')
                ->required(),
            TextInput::make('amount')
                ->numeric()
                ->required()
                ->suffix('¢')
                ->label('Amount (cents)'),
            DatePicker::make('receipt_date')
                ->required(),
            Toggle::make('is_reimbursable')
                ->default(true),
            Textarea::make('notes')
                ->nullable()
                ->columnSpanFull(),
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
                TextColumn::make('category.name')
                    ->label('Category'),
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
