<?php

namespace App\Filament\Resources\TravelModes;

use App\Filament\Resources\TravelModes\Pages\CreateTravelMode;
use App\Filament\Resources\TravelModes\Pages\EditTravelMode;
use App\Filament\Resources\TravelModes\Pages\ListTravelModes;
use App\Filament\Resources\TravelModes\Schemas\TravelModeForm;
use App\Filament\Resources\TravelModes\Tables\TravelModesTable;
use App\Models\TravelMode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TravelModeResource extends Resource
{
    protected static ?string $model = TravelMode::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Settings'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return TravelModeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TravelModesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTravelModes::route('/'),
            'create' => CreateTravelMode::route('/create'),
            'edit'   => EditTravelMode::route('/{record}/edit'),
        ];
    }
}
