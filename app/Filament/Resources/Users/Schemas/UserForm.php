<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation) => $operation === 'create')
                    ->label(fn (string $operation) => $operation === 'create' ? 'Password' : 'New Password (leave blank to keep current)')
                    ->same('password_confirmation'),
                TextInput::make('password_confirmation')
                    ->password()
                    ->dehydrated(false)
                    ->required(fn (string $operation) => $operation === 'create')
                    ->label('Confirm Password'),
                Select::make('preferred_contact_method_id')
                    ->relationship('preferredContactMethod', 'name'),
                TextInput::make('timezone')
                    ->required()
                    ->default('America/Toronto'),
                Toggle::make('is_active')
                    ->required(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
            ]);
    }
}
