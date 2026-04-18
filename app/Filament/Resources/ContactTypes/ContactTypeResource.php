<?php

namespace App\Filament\Resources\ContactTypes;

use App\Filament\Resources\ContactTypes\Pages\CreateContactType;
use App\Filament\Resources\ContactTypes\Pages\EditContactType;
use App\Filament\Resources\ContactTypes\Pages\ListContactTypes;
use App\Filament\Resources\ContactTypes\Schemas\ContactTypeForm;
use App\Filament\Resources\ContactTypes\Tables\ContactTypesTable;
use App\Models\ContactType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ContactTypeResource extends Resource
{
    protected static ?string $model = ContactType::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Reference Data'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ContactTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListContactTypes::route('/'),
            'create' => CreateContactType::route('/create'),
            'edit'   => EditContactType::route('/{record}/edit'),
        ];
    }
}
