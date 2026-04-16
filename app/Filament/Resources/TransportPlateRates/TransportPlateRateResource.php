<?php

namespace App\Filament\Resources\TransportPlateRates;

use App\Filament\Resources\TransportPlateRates\Pages\CreateTransportPlateRate;
use App\Filament\Resources\TransportPlateRates\Pages\EditTransportPlateRate;
use App\Filament\Resources\TransportPlateRates\Pages\ListTransportPlateRates;
use App\Filament\Resources\TransportPlateRates\Schemas\TransportPlateRateForm;
use App\Filament\Resources\TransportPlateRates\Tables\TransportPlateRatesTable;
use App\Models\TransportPlateRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TransportPlateRateResource extends Resource
{
    protected static ?string $model = TransportPlateRate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Transport Plate Rates';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Settings'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return TransportPlateRateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransportPlateRatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTransportPlateRates::route('/'),
            'create' => CreateTransportPlateRate::route('/create'),
            'edit'   => EditTransportPlateRate::route('/{record}/edit'),
        ];
    }
}
