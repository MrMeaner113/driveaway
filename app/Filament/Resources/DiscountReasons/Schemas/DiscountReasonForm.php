<?php

namespace App\Filament\Resources\DiscountReasons\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DiscountReasonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(100),
        ]);
    }
}
