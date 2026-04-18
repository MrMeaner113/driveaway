<?php

namespace App\Filament\Resources\CorporateDetails;

use App\Filament\Resources\CorporateDetails\Pages\CreateCorporateDetail;
use App\Filament\Resources\CorporateDetails\Pages\EditCorporateDetail;
use App\Filament\Resources\CorporateDetails\Pages\ListCorporateDetails;
use App\Filament\Resources\CorporateDetails\Schemas\CorporateDetailForm;
use App\Filament\Resources\CorporateDetails\Tables\CorporateDetailsTable;
use App\Models\CorporateDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CorporateDetailResource extends Resource
{
    protected static ?string $model = CorporateDetail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Corporate'; }

    public static function getNavigationSort(): ?int { return 1; }

    public static function form(Schema $schema): Schema
    {
        return CorporateDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CorporateDetailsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCorporateDetails::route('/'),
            'create' => CreateCorporateDetail::route('/create'),
            'edit'   => EditCorporateDetail::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
