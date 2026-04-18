<?php

namespace App\Filament\Resources\ContactTypes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContactTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('contact_category_id')
                ->relationship('category', 'name')
                ->label('Category')
                ->required()
                ->preload(),
            TextInput::make('name')->required()->maxLength(100),
            TextInput::make('slug')->maxLength(100)->nullable(),
            Textarea::make('description')->nullable()->columnSpanFull(),
            Toggle::make('is_active')->default(true),
            TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }
}
