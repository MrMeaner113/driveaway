<?php

namespace App\Filament\Resources\QuoteRequests\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuoteRequestInfolist
{
    /** Colour map shared with the Change Status action group. */
    public static function statusColor(string $status): string
    {
        return match ($status) {
            'new'         => 'warning',
            'in_progress' => 'info',
            'on_hold'     => 'gray',
            'sent'        => 'primary',
            'accepted'    => 'success',
            'rejected'    => 'danger',
            'cancelled'   => 'danger',
            'expired'     => 'gray',
            'converted'   => 'success',
            default       => 'gray',
        };
    }

    /** Human-readable label for a stored status slug. */
    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'new'         => 'New',
            'in_progress' => 'In Progress',
            'on_hold'     => 'On Hold',
            'sent'        => 'Sent',
            'accepted'    => 'Accepted',
            'rejected'    => 'Rejected',
            'cancelled'   => 'Cancelled',
            'expired'     => 'Expired',
            'converted'   => 'Converted',
            default       => ucfirst(str_replace('_', ' ', $status)),
        };
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ── Status badge — pinned at the top so it's always visible ──────
                Section::make()
                    ->schema([
                        TextEntry::make('status')
                            ->label('Current Status')
                            ->badge()
                            ->size('lg')
                            ->color(fn(string $state): string => static::statusColor($state))
                            ->formatStateUsing(fn(string $state): string => static::statusLabel($state)),
                    ]),

                // ── Contact Information ──────────────────────────────────────────
                Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->placeholder('—'),
                        TextEntry::make('phone')
                            ->placeholder('—'),
                        TextEntry::make('preferred_date')
                            ->label('Preferred Pickup Date')
                            ->date()
                            ->placeholder('—'),
                    ]),

                // ── Origin ───────────────────────────────────────────────────────
                Section::make('Origin')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('originCountry.name')
                            ->label('Country'),
                        // _display accessor: FK label if resolved, else free-text custom value
                        TextEntry::make('origin_province_display')
                            ->label('Province / State'),
                        TextEntry::make('origin_city_display')
                            ->label('City'),
                    ]),

                // ── Destination ──────────────────────────────────────────────────
                Section::make('Destination')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('destinationCountry.name')
                            ->label('Country'),
                        TextEntry::make('destination_province_display')
                            ->label('Province / State'),
                        TextEntry::make('destination_city_display')
                            ->label('City'),
                    ]),

                // ── Vehicles ─────────────────────────────────────────────────────
                Section::make('Vehicles')
                    ->schema([
                        RepeatableEntry::make('vehicles')
                            ->schema([
                                TextEntry::make('vehicle_year')
                                    ->label('Year'),
                                // _display accessor: FK label if resolved, else free-text custom value
                                TextEntry::make('vehicle_make_display')
                                    ->label('Make'),
                                TextEntry::make('vehicle_model_display')
                                    ->label('Model'),
                            ])
                            ->columns(3),
                    ]),

                // ── Add-on Services ──────────────────────────────────────────────
                Section::make('Add-on Services')
                    ->schema([
                        TextEntry::make('addOnServices')
                            ->label('Services')
                            ->getStateUsing(
                                fn($record) => $record->addOnServices->pluck('name')->join(', ') ?: '—'
                            )
                            ->columnSpanFull(),
                    ]),

                // ── Notes ────────────────────────────────────────────────────────
                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')
                            ->placeholder('—')
                            ->columnSpanFull(),
                        TextEntry::make('rejected_reason')
                            ->label('Rejection / Cancellation Reason')
                            ->placeholder('—')
                            ->columnSpanFull()
                            ->visible(fn($record) => filled($record->rejected_reason)),
                    ]),

                // ── Workflow timestamps ───────────────────────────────────────────
                Section::make('Workflow')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('reviewedBy.name')
                            ->label('Reviewed By')
                            ->placeholder('—'),
                        TextEntry::make('reviewed_at')
                            ->label('Reviewed At')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('quotedBy.name')
                            ->label('Quoted By')
                            ->placeholder('—'),
                        TextEntry::make('quoted_at')
                            ->label('Quoted At')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('accepted_at')
                            ->label('Accepted At')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('rejected_at')
                            ->label('Rejected / Cancelled At')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('expired_at')
                            ->label('Expired At')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime(),
                    ]),
            ]);
    }
}
