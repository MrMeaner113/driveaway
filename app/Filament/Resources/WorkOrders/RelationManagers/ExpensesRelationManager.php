<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use App\Models\ExpenseCategory;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\SelectFilter;
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
            Select::make('expense_category_id')
                ->relationship('category', 'name')
                ->label('Category')
                ->required()
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
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge(),

                TextColumn::make('description')
                    ->limit(35),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2))
                    ->sortable()
                    ->summarize(
                        Sum::make()
                            ->label('Subtotal')
                            ->formatStateUsing(fn ($state) => '$' . number_format($state / 100, 2))
                    ),

                TextColumn::make('driver.user.name')
                    ->label('Driver')
                    ->toggleable(),
            ])
            ->defaultSort('expense_date', 'desc')
            ->filters([
                SelectFilter::make('expense_category_id')
                    ->label('Category')
                    ->options(ExpenseCategory::orderBy('name')->pluck('name', 'id')),
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
