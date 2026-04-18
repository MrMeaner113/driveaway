<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Models\ContactStatus;
use App\Models\ContactType;
use App\Models\Organization;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name', 'nickname'])
                    ->sortable(['last_name', 'first_name']),
                TextColumn::make('contactType.name')
                    ->label('Type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('contactType.category.name')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->default('—')
                    ->toggleable(),
                TextColumn::make('email')
                    ->copyable()
                    ->default('—')
                    ->toggleable(),
                TextColumn::make('phone')
                    ->default('—')
                    ->toggleable(),
                TextColumn::make('contactStatus.name')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_name')
            ->filters([
                SelectFilter::make('contact_type_id')
                    ->label('Type')
                    ->options(fn () => ContactType::orderBy('sort_order')->pluck('name', 'id')),
                SelectFilter::make('contact_status_id')
                    ->label('Status')
                    ->options(fn () => ContactStatus::orderBy('sort_order')->pluck('name', 'id')),
                SelectFilter::make('organization_id')
                    ->label('Organization')
                    ->searchable()
                    ->options(fn () => Organization::orderBy('name')->pluck('name', 'id')),
                TernaryFilter::make('is_active')
                    ->label('Active'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
