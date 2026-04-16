<?php

namespace App\Filament\Resources\TripPlans;

use App\Filament\Resources\TripPlans\Pages\CreateTripPlan;
use App\Filament\Resources\TripPlans\Pages\EditTripPlan;
use App\Filament\Resources\TripPlans\Pages\ListTripPlans;
use App\Filament\Resources\TripPlans\Pages\ViewTripPlan;
use App\Filament\Resources\TripPlans\Schemas\TripPlanForm;
use App\Filament\Resources\TripPlans\Tables\TripPlansTable;
use App\Models\TripPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TripPlanResource extends Resource
{
    protected static ?string $model = TripPlan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Quotes'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'office_staff']) ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasRole(['super_admin', 'office_staff']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(TripPlanForm::schema());
    }

    public static function table(Table $table): Table
    {
        return TripPlansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTripPlans::route('/'),
            'create' => CreateTripPlan::route('/create'),
            'edit'   => EditTripPlan::route('/{record}/edit'),
            'view'   => ViewTripPlan::route('/{record}'),
        ];
    }
}
