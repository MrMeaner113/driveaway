<?php

namespace App\Filament\Resources\ContactCategories;

use App\Filament\Resources\ContactCategories\Pages\CreateContactCategory;
use App\Filament\Resources\ContactCategories\Pages\EditContactCategory;
use App\Filament\Resources\ContactCategories\Pages\ListContactCategories;
use App\Filament\Resources\ContactCategories\Schemas\ContactCategoryForm;
use App\Filament\Resources\ContactCategories\Tables\ContactCategoriesTable;
use App\Models\ContactCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ContactCategoryResource extends Resource
{
    protected static ?string $model = ContactCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Reference Data'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ContactCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListContactCategories::route('/'),
            'create' => CreateContactCategory::route('/create'),
            'edit'   => EditContactCategory::route('/{record}/edit'),
        ];
    }
}
