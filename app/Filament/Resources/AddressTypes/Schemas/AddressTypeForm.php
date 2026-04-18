<?php

namespace App\Filament\Resources\AddressTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AddressTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(100),
            TextInput::make('slug')->maxLength(100)->nullable(),
            Textarea::make('description')->nullable()->columnSpanFull(),
            Toggle::make('is_active')->default(true),
            TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }
}
