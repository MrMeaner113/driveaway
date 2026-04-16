<?php

namespace App\Filament\Resources\DiscountReasons\Pages;

use App\Filament\Resources\DiscountReasons\DiscountReasonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDiscountReasons extends ListRecords
{
    protected static string $resource = DiscountReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
