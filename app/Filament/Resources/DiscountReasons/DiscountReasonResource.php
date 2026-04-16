<?php

namespace App\Filament\Resources\DiscountReasons;

use App\Filament\Resources\DiscountReasons\Pages\CreateDiscountReason;
use App\Filament\Resources\DiscountReasons\Pages\EditDiscountReason;
use App\Filament\Resources\DiscountReasons\Pages\ListDiscountReasons;
use App\Filament\Resources\DiscountReasons\Schemas\DiscountReasonForm;
use App\Filament\Resources\DiscountReasons\Tables\DiscountReasonsTable;
use App\Models\DiscountReason;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DiscountReasonResource extends Resource
{
    protected static ?string $model = DiscountReason::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Settings'; }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return DiscountReasonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiscountReasonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDiscountReasons::route('/'),
            'create' => CreateDiscountReason::route('/create'),
            'edit'   => EditDiscountReason::route('/{record}/edit'),
        ];
    }
}
