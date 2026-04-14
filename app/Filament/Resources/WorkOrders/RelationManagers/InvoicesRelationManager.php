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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('invoice_number')
                ->required()
                ->maxLength(50),
            Select::make('contact_id')
                ->relationship('contact', 'first_name')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                ->required(),
            Select::make('organization_id')
                ->relationship('organization', 'name')
                ->nullable(),
            DatePicker::make('invoice_date')
                ->required(),
            DatePicker::make('due_date')
                ->required(),
            TextInput::make('subtotal')
                ->numeric()
                ->required()
                ->suffix('¢'),
            TextInput::make('tax_amount')
                ->numeric()
                ->required()
                ->suffix('¢'),
            TextInput::make('total')
                ->numeric()
                ->required()
                ->suffix('¢'),
            TextInput::make('tax_rate_bps')
                ->label('Tax Rate (basis pts)')
                ->numeric()
                ->required()
                ->helperText('e.g. 1300 = 13.00%'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_number')
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable(),
                TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('total')
                    ->suffix('¢')
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label('Paid')
                    ->date()
                    ->placeholder('Unpaid'),
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
