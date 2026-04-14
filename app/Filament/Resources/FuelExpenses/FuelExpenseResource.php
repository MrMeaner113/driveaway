<?php

namespace App\Filament\Resources\FuelExpenses;

use App\Filament\Resources\FuelExpenses\Pages\CreateFuelExpense;
use App\Filament\Resources\FuelExpenses\Pages\EditFuelExpense;
use App\Filament\Resources\FuelExpenses\Pages\ListFuelExpenses;
use App\Filament\Resources\FuelExpenses\Schemas\FuelExpenseForm;
use App\Filament\Resources\FuelExpenses\Tables\FuelExpensesTable;
use App\Models\FuelExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FuelExpenseResource extends Resource
{
    protected static ?string $model = FuelExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFire;

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Finance'; }

    public static function getNavigationSort(): ?int { return 4; }

    public static function getNavigationLabel(): string { return 'Fuel Expenses'; }

    public static function form(Schema $schema): Schema
    {
        return FuelExpenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FuelExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFuelExpenses::route('/'),
            'create' => CreateFuelExpense::route('/create'),
            'edit'   => EditFuelExpense::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
