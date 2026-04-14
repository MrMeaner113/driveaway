<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LineItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'lineItems';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('description')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            TextInput::make('quantity')
                ->numeric()
                ->required()
                ->step(0.01)
                ->default(1),
            TextInput::make('unit_price')
                ->numeric()
                ->required()
                ->suffix('¢')
                ->label('Unit Price (cents)'),
            TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->numeric(2),
                TextColumn::make('unit_price')
                    ->suffix('¢')
                    ->label('Unit Price'),
                TextColumn::make('amount')
                    ->suffix('¢'),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
