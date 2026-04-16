<?php

namespace App\Filament\Resources\InsuranceRates;

use App\Filament\Resources\InsuranceRates\Pages\CreateInsuranceRate;
use App\Filament\Resources\InsuranceRates\Pages\EditInsuranceRate;
use App\Filament\Resources\InsuranceRates\Pages\ListInsuranceRates;
use App\Filament\Resources\InsuranceRates\Schemas\InsuranceRateForm;
use App\Filament\Resources\InsuranceRates\Tables\InsuranceRatesTable;
use App\Models\InsuranceRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class InsuranceRateResource extends Resource
{
    protected static ?string $model = InsuranceRate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Insurance Rates';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Settings'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return InsuranceRateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InsuranceRatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInsuranceRates::route('/'),
            'create' => CreateInsuranceRate::route('/create'),
            'edit'   => EditInsuranceRate::route('/{record}/edit'),
        ];
    }
}
