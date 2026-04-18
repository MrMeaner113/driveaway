<?php

namespace App\Filament\Resources\Contacts;

use App\Filament\Resources\Contacts\Pages\CreateContact;
use App\Filament\Resources\Contacts\Pages\EditContact;
use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Filament\Resources\Contacts\Pages\ViewContact;
use App\Filament\Resources\Contacts\Schemas\ContactForm;
use App\Filament\Resources\Contacts\Tables\ContactsTable;
use App\Models\Contact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'People'; }

    public static function getNavigationSort(): ?int { return 1; }

    public static function form(Schema $schema): Schema
    {
        return ContactForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactsTable::configure($table);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Type'         => $record->contactType?->name,
            'Organization' => $record->organization?->name,
            'Email'        => $record->email,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'nickname', 'email', 'phone', 'mobile'];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'view'   => ViewContact::route('/{record}'),
            'edit'   => EditContact::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
