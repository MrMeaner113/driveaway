<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Models\City;
use App\Models\ContactCategory;
use App\Models\ContactStatus;
use App\Models\ContactType;
use App\Models\DriverStatus;
use App\Models\Province;
use App\Models\StaffPosition;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(2)->components(self::sections());
    }

    public static function sections(): array
    {
        return [
            // ── 1. Classification — full width ───────────────────────────────
            Section::make('Classification')
                ->columnSpanFull()
                ->columns(3)
                ->schema([
                    Select::make('contact_category_id')
                        ->label('Category')
                        ->options(fn () => ContactCategory::orderBy('sort_order')->pluck('name', 'id'))
                        ->required()
                        ->dehydrated(false)
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
                            $set('contact_type_id', null);
                            if (! $state) { $set('_category_slug', null); return; }
                            $set('_category_slug', ContactCategory::find($state)?->slug);
                        }),
                    Select::make('contact_type_id')
                        ->label('Type')
                        ->options(fn (Get $get) => ContactType::when(
                                $get('contact_category_id'),
                                fn ($q, $catId) => $q->where('contact_category_id', $catId)
                            )
                            ->orderBy('sort_order')
                            ->pluck('name', 'id')
                        )
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateHydrated(function ($state, Set $set) {
                            if (! $state) return;
                            $type = ContactType::with('category')->find($state);
                            if (! $type) return;
                            $set('contact_category_id', $type->contact_category_id);
                            $set('_category_slug', $type->category?->slug);
                        }),
                    Select::make('staff_position_id')
                        ->label('Staff Position')
                        ->options(fn () => StaffPosition::orderBy('name')->pluck('name', 'id'))
                        ->nullable()
                        ->live()
                        ->hidden(fn (Get $get) => ContactType::find($get('contact_type_id'))?->slug !== 'team-member'),
                    Select::make('contact_status_id')
                        ->relationship('contactStatus', 'name')
                        ->default(fn () => ContactStatus::where('slug', 'active')->value('id'))
                        ->required()
                        ->preload()
                        ->hiddenOn('create'),
                    Toggle::make('is_active')
                        ->default(true)
                        ->inline(false),
                    Hidden::make('_category_slug')
                        ->dehydrated(false),
                ]),

            // ── 2. Personal Information — left ───────────────────────────────
            Section::make('Personal Information')
                ->columns(2)
                ->schema([
                    TextInput::make('first_name')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('last_name')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('nickname')
                        ->nullable()
                        ->maxLength(100)
                        ->helperText('Preferred name or alias'),
                    TextInput::make('email')
                        ->email()
                        ->nullable()
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->tel()
                        ->prefix('+1')
                        ->mask('999-999-9999')
                        ->placeholder('123-456-7890')
                        ->nullable()
                        ->maxLength(15),
                    TextInput::make('mobile')
                        ->tel()
                        ->prefix('+1')
                        ->mask('999-999-9999')
                        ->placeholder('123-456-7890')
                        ->nullable()
                        ->maxLength(15),
                    Select::make('preferred_contact_method_id')
                        ->relationship('preferredContactMethod', 'name')
                        ->nullable()
                        ->preload(),
                ]),

            // ── 3. Addresses — right ─────────────────────────────────────────
            Section::make('Addresses')
                ->schema([
                    Repeater::make('addresses')
                        ->relationship('addresses')
                        ->label('')
                        ->addActionLabel('Add address')
                        ->columns(2)
                        ->schema([
                            Select::make('address_type_id')
                                ->relationship('addressType', 'name')
                                ->label('Address Type')
                                ->required()
                                ->preload(),
                            Toggle::make('is_primary')
                                ->label('Primary Address')
                                ->default(false)
                                ->inline(false),
                            TextInput::make('line1')
                                ->label('Street Address')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            TextInput::make('line2')
                                ->label('Suite / Unit')
                                ->nullable()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Select::make('country_id')
                                ->relationship('country', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('province_id', null);
                                    $set('city_id', null);
                                }),
                            Select::make('province_id')
                                ->label('Province / State')
                                ->options(fn (Get $get) => Province::when(
                                    $get('country_id'),
                                    fn ($q, $cid) => $q->where('country_id', $cid)
                                )->orderBy('name')->pluck('name', 'id'))
                                ->required()
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('city_id', null)),
                            Select::make('city_id')
                                ->label('City')
                                ->options(fn (Get $get) => City::when(
                                    $get('province_id'),
                                    fn ($q, $pid) => $q->where('province_id', $pid)
                                )->orderBy('name')->pluck('name', 'id'))
                                ->required()
                                ->searchable()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('City Name')
                                        ->required(),
                                    Hidden::make('province_id'),
                                ])
                                ->createOptionAction(fn ($action, Get $get) =>
                                    $action->fillForm(['province_id' => $get('province_id')])
                                )
                                ->createOptionUsing(fn (array $data) => City::create([
                                    'name'        => $data['name'],
                                    'province_id' => $data['province_id'],
                                    'is_active'   => true,
                                ])->getKey()),
                            TextInput::make('postal_code')
                                ->nullable()
                                ->maxLength(20),
                            Toggle::make('is_active')
                                ->default(true)
                                ->inline(false),
                        ]),
                ]),

            // ── 4. Organization — full width, conditional ────────────────────
            Section::make('Organization')
                ->columnSpanFull()
                ->schema([
                    Select::make('organization_id')
                        ->relationship('organization', 'name')
                        ->nullable()
                        ->searchable()
                        ->hidden(fn (Get $get) => $get('_category_slug') !== 'corporate'),
                ])
                ->hidden(fn (Get $get) => $get('_category_slug') !== 'corporate'),

            // ── 5. Driver Details — full width, conditional ──────────────────
            Section::make('Driver Details')
                ->columnSpanFull()
                ->columns(2)
                ->schema([
                    Select::make('driver_status_id')
                        ->label('Driver Status')
                        ->options(fn () => DriverStatus::orderBy('name')->pluck('name', 'id'))
                        ->nullable(),
                    Select::make('issuing_jurisdiction_id')
                        ->label('Issuing Province / State')
                        ->options(fn () => Province::orderBy('name')->pluck('name', 'id'))
                        ->required()
                        ->searchable(),
                    TextInput::make('license_number')
                        ->required()
                        ->maxLength(50)
                        ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                        ->dehydrateStateUsing(fn ($state) => mb_strtoupper($state ?? '')),
                    TextInput::make('license_class')
                        ->required()
                        ->maxLength(20)
                        ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                        ->dehydrateStateUsing(fn ($state) => mb_strtoupper($state ?? '')),

                    // Date fields — each paired with a Not Applicable toggle
                    Group::make([
                        DatePicker::make('license_expiry')
                            ->required(fn (Get $get) => ! $get('license_expiry_na'))
                            ->disabled(fn (Get $get) => (bool) $get('license_expiry_na')),
                        Toggle::make('license_expiry_na')
                            ->label('Not Applicable')
                            ->dehydrated(false)
                            ->live()
                            ->inline(false)
                            ->afterStateUpdated(fn ($state, Set $set) => $state ? $set('license_expiry', null) : null),
                    ]),
                    Group::make([
                        DatePicker::make('medical_cert_expiry')
                            ->nullable()
                            ->disabled(fn (Get $get) => (bool) $get('medical_cert_expiry_na')),
                        Toggle::make('medical_cert_expiry_na')
                            ->label('Not Applicable')
                            ->dehydrated(false)
                            ->live()
                            ->inline(false)
                            ->afterStateUpdated(fn ($state, Set $set) => $state ? $set('medical_cert_expiry', null) : null),
                    ]),
                    Group::make([
                        DatePicker::make('abstract_date')
                            ->label('Abstract Date')
                            ->nullable()
                            ->disabled(fn (Get $get) => (bool) $get('abstract_date_na')),
                        Toggle::make('abstract_date_na')
                            ->label('Not Applicable')
                            ->dehydrated(false)
                            ->live()
                            ->inline(false)
                            ->afterStateUpdated(fn ($state, Set $set) => $state ? $set('abstract_date', null) : null),
                    ]),
                    TextInput::make('default_rate_per_km')
                        ->label('Default Rate ($/km)')
                        ->numeric()
                        ->nullable()
                        ->step(0.0001)
                        ->prefix('$'),

                    Toggle::make('has_air_brakes')
                        ->label('Air Brakes')
                        ->default(false)
                        ->inline(false),
                    Toggle::make('has_passenger')
                        ->label('Passenger Endorsement')
                        ->default(false)
                        ->inline(false),
                    Toggle::make('manual_shift')
                        ->label('Manual Shift')
                        ->default(false)
                        ->inline(false),
                    Textarea::make('restrictions')
                        ->nullable()
                        ->columnSpanFull(),
                ])
                ->hidden(fn (Get $get) => StaffPosition::find($get('staff_position_id'))?->name !== 'Driver'),

            // ── 6. Notes — full width ────────────────────────────────────────
            Section::make('Notes')
                ->columnSpanFull()
                ->schema([
                    Textarea::make('notes')
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ];
    }

    public static function driverFields(): array
    {
        return [
            'driver_status_id',
            'issuing_jurisdiction_id',
            'license_number',
            'license_class',
            'license_expiry',
            'medical_cert_expiry',
            'abstract_date',
            'default_rate_per_km',
            'has_air_brakes',
            'has_passenger',
            'manual_shift',
            'restrictions',
        ];
    }
}
