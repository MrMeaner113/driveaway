<?php

namespace App\Filament\Resources\PreferredContactMethods;

use App\Filament\Resources\PreferredContactMethods\Pages\CreatePreferredContactMethod;
use App\Filament\Resources\PreferredContactMethods\Pages\EditPreferredContactMethod;
use App\Filament\Resources\PreferredContactMethods\Pages\ListPreferredContactMethods;
use App\Filament\Resources\PreferredContactMethods\Schemas\PreferredContactMethodForm;
use App\Filament\Resources\PreferredContactMethods\Tables\PreferredContactMethodsTable;
use App\Models\PreferredContactMethod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PreferredContactMethodResource extends Resource
{
    protected static ?string $model = PreferredContactMethod::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Reference Data'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return PreferredContactMethodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreferredContactMethodsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPreferredContactMethods::route('/'),
            'create' => CreatePreferredContactMethod::route('/create'),
            'edit'   => EditPreferredContactMethod::route('/{record}/edit'),
        ];
    }
}
