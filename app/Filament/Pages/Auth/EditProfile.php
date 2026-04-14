<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Hash;

class EditProfile extends BaseEditProfile
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Dashboard')
                ->url(route('filament.admin.pages.dashboard'))
                ->color('gray')
                ->button(),
        ];
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('New Password (leave blank to keep current)')
            ->password()
            ->dehydrated(fn ($state) => filled($state))
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('password_confirmation')
            ->autocomplete('new-password')
            ->live(onBlur: true);
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('password_confirmation')
            ->label('Confirm Password')
            ->password()
            ->dehydrated(false)
            ->required(fn (Get $get) => filled($get('password')))
            ->visible(fn (Get $get) => filled($get('password')))
            ->autocomplete('new-password');
    }
}
