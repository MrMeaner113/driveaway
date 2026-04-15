<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use App\Models\QuoteRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NewQuoteRequestsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $newCount    = QuoteRequest::where('status', 'new')->count();
        $pendingCount = QuoteRequest::whereIn('status', ['new', 'reviewed', 'quoted'])->count();

        return [
            Stat::make('New Quote Requests', $newCount)
                ->description('Awaiting review')
                ->color('warning')
                ->icon('heroicon-o-inbox')
                ->url(QuoteRequestResource::getUrl('index')),
            Stat::make('Open Requests', $pendingCount)
                ->description('New + reviewed + quoted')
                ->color('info')
                ->icon('heroicon-o-clock')
                ->url(QuoteRequestResource::getUrl('index')),
        ];
    }
}
