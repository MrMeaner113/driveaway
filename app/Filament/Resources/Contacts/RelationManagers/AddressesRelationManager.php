<?php

namespace App\Filament\Resources\Contacts\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
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

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('address_type_id')
                ->relationship('addressType', 'name')
                ->label('Address Type')
                ->required(),
            TextInput::make('line1')
                ->label('Street Address')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            TextInput::make('line2')
                ->label('Suite / Unit')
                ->maxLength(255)
                ->columnSpanFull(),
            Select::make('city_id')
                ->relationship('city', 'name')
                ->label('City')
                ->required()
                ->searchable(),
            Select::make('province_id')
                ->relationship('province', 'name')
                ->label('Province / State')
                ->required()
                ->searchable(),
            Select::make('country_id')
                ->relationship('country', 'name')
                ->label('Country')
                ->required()
                ->searchable(),
            TextInput::make('postal_code')
                ->maxLength(20),
            Toggle::make('is_primary')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('line1')
            ->columns([
                TextColumn::make('line1')
                    ->label('Address')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('City'),
                TextColumn::make('province.code')
                    ->label('Prov.'),
                TextColumn::make('postal_code'),
                IconColumn::make('is_primary')
                    ->boolean()
                    ->label('Primary'),
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
