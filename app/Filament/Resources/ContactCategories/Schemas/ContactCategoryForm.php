<?php

namespace App\Filament\Resources\ContactCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(100),
            TextInput::make('slug')->maxLength(100)->nullable(),
            Toggle::make('is_active')->default(true),
            TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }
}
