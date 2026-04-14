<?php

namespace App\Filament\Resources\Quotes\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddOnServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'addOnServices';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('amount')
                ->numeric()
                ->required()
                ->suffix('¢')
                ->label('Amount (cents)'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Amount (¢)')
                    ->getStateUsing(fn ($record) => $record->pivot?->amount),
            ])
            ->filters([])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->suffix('¢')
                            ->label('Amount (cents)'),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
