<?php

namespace App\Filament\Resources\ContactStatuses;

use App\Filament\Resources\ContactStatuses\Pages\CreateContactStatus;
use App\Filament\Resources\ContactStatuses\Pages\EditContactStatus;
use App\Filament\Resources\ContactStatuses\Pages\ListContactStatuses;
use App\Filament\Resources\ContactStatuses\Schemas\ContactStatusForm;
use App\Filament\Resources\ContactStatuses\Tables\ContactStatusesTable;
use App\Models\ContactStatus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ContactStatusResource extends Resource
{
    protected static ?string $model = ContactStatus::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-check-circle';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Reference Data'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ContactStatusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactStatusesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListContactStatuses::route('/'),
            'create' => CreateContactStatus::route('/create'),
            'edit'   => EditContactStatus::route('/{record}/edit'),
        ];
    }
}
