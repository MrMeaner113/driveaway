<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Get a Quote | Drive-Away.ca</title>

    <link rel="icon" type="image/svg+xml" href="/images/fav/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">

    <x-navbar />

    <div class="max-w-3xl mx-auto px-4 py-12">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Request a Quote</h1>
            <p class="mt-2 text-gray-600">Fill in the details below and we'll get back to you with a custom transport quote.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                <p class="text-sm font-semibold text-red-800 mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm text-red-700">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('quote-request.store') }}"
            x-data="quoteRequestForm(
                {{ $defaultCountry?->id ?? 'null' }},
                {{ $provinces->toJson() }},
                {{ $vehicleMakes->toJson() }}
            )"
        >
            @csrf

            {{-- ── Contact Information ────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            @class(['w-full px-3 py-2 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm', 'border-2 border-red-500' => $errors->has('first_name'), 'border border-gray-300' => !$errors->has('first_name')])
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            @class(['w-full px-3 py-2 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm', 'border-2 border-red-500' => $errors->has('last_name'), 'border border-gray-300' => !$errors->has('last_name')])
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            @class(['w-full px-3 py-2 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm', 'border-2 border-red-500' => $errors->has('email'), 'border border-gray-300' => !$errors->has('email')])>
                        <p class="mt-1 text-xs text-gray-200">At least one of email or phone required.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <div style="display:flex; align-items:stretch;">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm font-medium">+1</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                x-on:input="
                                    let d = $event.target.value.replace(/\D/g, '').substring(0, 10);
                                    let f = d.length > 6
                                        ? d.slice(0,3) + '-' + d.slice(3,6) + '-' + d.slice(6)
                                        : d.length > 3
                                        ? d.slice(0,3) + '-' + d.slice(3)
                                        : d;
                                    $event.target.value = f;
                                "
                                placeholder="000-000-0000"
                                @class(['w-full px-3 py-2 rounded-r-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm', 'border-2 border-r-2 border-red-500' => $errors->has('phone'), 'border border-l-0 border-gray-300' => !$errors->has('phone')])>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Vehicle Details ────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Vehicle Details</h2>
                <p class="text-sm text-gray-500 mb-4">Add each vehicle to be transported. Type a make or model — suggestions will appear, or enter your own.</p>

                <div x-ref="vehicleList" class="space-y-4">
                    <template x-for="(vehicle, index) in vehicles" :key="index">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 relative">
                            {{-- Year --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Year <span class="text-red-500">*</span></label>
                                <input type="number"
                                    :name="`vehicles[${index}][vehicle_year]`"
                                    x-model="vehicle.vehicle_year"
                                    min="1900" :max="{{ date('Y') + 2 }}"
                                    placeholder="{{ date('Y') }}"
                                    class="w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm border-gray-300"
                                    required>
                            </div>

                            {{-- Make combobox --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Make <span class="text-red-500">*</span></label>
                                {{-- Hidden FK id — populated by JS when an exact match is found --}}
                                <input type="hidden"
                                    :name="`vehicles[${index}][vehicle_make_id]`"
                                    :value="vehicle.vehicle_make_id ?? ''">
                                {{-- Text input — always submitted as vehicle_make_custom --}}
                                <input type="text"
                                    :name="`vehicles[${index}][vehicle_make_custom]`"
                                    x-model="vehicle.vehicle_make_text"
                                    :list="`makes-list-${index}`"
                                    @change="onMakeChange(index)"
                                    @blur="onMakeChange(index)"
                                    placeholder="e.g. Toyota"
                                    autocomplete="off"
                                    class="w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm border-gray-300"
                                    required>
                                <datalist :id="`makes-list-${index}`">
                                    <template x-for="make in vehicleMakes" :key="make.id">
                                        <option :value="make.name"></option>
                                    </template>
                                </datalist>
                            </div>

                            {{-- Model combobox --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Model <span class="text-red-500">*</span></label>
                                <input type="hidden"
                                    :name="`vehicles[${index}][vehicle_model_id]`"
                                    :value="vehicle.vehicle_model_id ?? ''">
                                <input type="text"
                                    :name="`vehicles[${index}][vehicle_model_custom]`"
                                    x-model="vehicle.vehicle_model_text"
                                    :list="`models-list-${index}`"
                                    @change="onModelChange(index)"
                                    @blur="onModelChange(index)"
                                    placeholder="e.g. Camry"
                                    autocomplete="off"
                                    class="w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm border-gray-300"
                                    required>
                                <datalist :id="`models-list-${index}`">
                                    <template x-for="model in vehicle.models" :key="model.id">
                                        <option :value="model.name"></option>
                                    </template>
                                </datalist>
                            </div>

                            <button
                                type="button"
                                x-show="vehicles.length > 1"
                                @click="removeVehicle(index)"
                                class="absolute top-2 right-2 text-gray-400 hover:text-red-600 transition-colors"
                                title="Remove vehicle">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addVehicle()"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-red-700 hover:text-red-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add another vehicle
                </button>
            </div>

            {{-- ── Route Details ──────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Route Details</h2>
                <p class="text-sm text-gray-500 mb-4">Start typing a province or city — suggestions will appear. You can also enter a custom location not in the list.</p>

                {{-- Origin --}}
                <p class="text-sm font-semibold text-gray-700 mb-3">Origin</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    {{-- Country (stays as select — always required from lookup) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                        <select name="origin_country_id" x-model="originCountryId" @change="fetchOriginProvinces()"
                            @class(['w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm', 'border-red-500' => $errors->has('origin_country_id'), 'border-gray-300' => !$errors->has('origin_country_id')])
                            required>
                            <option value="">Select country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('origin_country_id', $defaultCountry?->id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Province combobox --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Province / State <span class="text-red-500">*</span></label>
                        <input type="hidden" name="origin_province_id" :value="originProvinceId ?? ''">
                        <input type="text"
                            name="origin_province_custom"
                            x-model="originProvinceText"
                            list="origin-provinces-list"
                            @change="onOriginProvinceChange()"
                            @blur="onOriginProvinceChange()"
                            placeholder="Province or state"
                            autocomplete="off"
                            value="{{ old('origin_province_custom') }}"
                            @class(['w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm', 'border-red-500' => $errors->has('origin_province_custom'), 'border-gray-300' => !$errors->has('origin_province_custom')])
                            required>
                        <datalist id="origin-provinces-list">
                            <template x-for="p in originProvinces" :key="p.id">
                                <option :value="p.name"></option>
                            </template>
                        </datalist>
                    </div>

                    {{-- City combobox --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                        <input type="hidden" name="origin_city_id" :value="originCityId ?? ''">
                        <input type="text"
                            name="origin_city_custom"
                            x-model="originCityText"
                            list="origin-cities-list"
                            @change="onOriginCityChange()"
                            @blur="onOriginCityChange()"
                            placeholder="City"
                            autocomplete="off"
                            value="{{ old('origin_city_custom') }}"
                            @class(['w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm', 'border-red-500' => $errors->has('origin_city_custom'), 'border-gray-300' => !$errors->has('origin_city_custom')])
                            required>
                        <datalist id="origin-cities-list">
                            <template x-for="c in originCities" :key="c.id">
                                <option :value="c.name"></option>
                            </template>
                        </datalist>
                    </div>
                </div>

                {{-- Destination --}}
                <p class="text-sm font-semibold text-gray-700 mb-3">Destination</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Country --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                        <select name="destination_country_id" x-model="destCountryId" @change="fetchDestProvinces()"
                            @class(['w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm', 'border-red-500' => $errors->has('destination_country_id'), 'border-gray-300' => !$errors->has('destination_country_id')])
                            required>
                            <option value="">Select country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('destination_country_id', $defaultCountry?->id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Province combobox --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Province / State <span class="text-red-500">*</span></label>
                        <input type="hidden" name="destination_province_id" :value="destProvinceId ?? ''">
                        <input type="text"
                            name="destination_province_custom"
                            x-model="destProvinceText"
                            list="dest-provinces-list"
                            @change="onDestProvinceChange()"
                            @blur="onDestProvinceChange()"
                            placeholder="Province or state"
                            autocomplete="off"
                            value="{{ old('destination_province_custom') }}"
                            @class(['w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm', 'border-red-500' => $errors->has('destination_province_custom'), 'border-gray-300' => !$errors->has('destination_province_custom')])
                            required>
                        <datalist id="dest-provinces-list">
                            <template x-for="p in destProvinces" :key="p.id">
                                <option :value="p.name"></option>
                            </template>
                        </datalist>
                    </div>

                    {{-- City combobox --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                        <input type="hidden" name="destination_city_id" :value="destCityId ?? ''">
                        <input type="text"
                            name="destination_city_custom"
                            x-model="destCityText"
                            list="dest-cities-list"
                            @change="onDestCityChange()"
                            @blur="onDestCityChange()"
                            placeholder="City"
                            autocomplete="off"
                            value="{{ old('destination_city_custom') }}"
                            @class(['w-full rounded-lg border shadow-sm focus:border-red-500 focus:ring-red-500 text-sm', 'border-red-500' => $errors->has('destination_city_custom'), 'border-gray-300' => !$errors->has('destination_city_custom')])
                            required>
                        <datalist id="dest-cities-list">
                            <template x-for="c in destCities" :key="c.id">
                                <option :value="c.name"></option>
                            </template>
                        </datalist>
                    </div>
                </div>
            </div>
						
						{{-- ── Preferred Date ────────────────────────────────────────── --}}
						<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Preferred Date</h2>
								<div>
										<div class="flex gap-6 mb-3">
												<label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
														<input type="radio" @click="dateType = 'pickup'" :checked="dateType === 'pickup'"
																class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 cursor-pointer"
																style="accent-color: #dc2626;">
														Preferred Pickup Date
												</label>
												<label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
														<input type="radio" @click="dateType = 'delivery'" :checked="dateType === 'delivery'"
																class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 cursor-pointer"
																style="accent-color: #dc2626;">
														Preferred Delivery Date
												</label>
										</div>
										<input type="hidden" name="date_type" :value="dateType">
										<label class="block text-sm font-medium text-gray-700 mb-1">
												<span x-text="dateType === 'pickup' ? 'When should we pick up your vehicle?' : 'When do you need it delivered?'"></span>
										</label>
										<input type="date" name="preferred_date" value="{{ old('preferred_date') }}"
												min="{{ now()->addDay()->toDateString() }}"
												class="w-full sm:w-48 rounded-lg border border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
										<p class="mt-1 text-xs text-gray-500">Optional. Subject to availability.</p>
								</div>
						</div>

            {{-- ── Add-on Services ────────────────────────────────────────── --}}
            @if ($addOnServices->isNotEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Add-on Services</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($addOnServices as $service)
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox"
                                name="add_on_services[]"
                                value="{{ $service->id }}"
                                {{ in_array($service->id, old('add_on_services', [])) ? 'checked' : '' }}
                                class="mt-0.5 rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-700">
                                <span class="font-medium">{{ $service->name }}</span>
                                @if ($service->description)
                                    <span class="block text-gray-500 text-xs mt-0.5">{{ $service->description }}</span>
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Client Note ─────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Additional Details</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                        <textarea name="notes" rows="4" maxlength="2000"
                            class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"
                            placeholder="Any special instructions, conditions, or information we should know...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="/" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">← Back to home</a>
                <button type="submit"
                    class="btn-brand px-8 py-3 text-base">
                    Submit Quote Request
                </button>
            </div>
        </form>
    </div>

    @livewireScripts

    <script>
        function quoteRequestForm(defaultCountryId, initialProvinces, vehicleMakes) {
            return {
                // ── Date type ────────────────────────────────────────────────
                dateType: 'pickup',

                // ── Vehicles ─────────────────────────────────────────────────
                vehicles: [{
                    vehicle_year: '',
                    vehicle_make_text: '', vehicle_make_id: null,
                    vehicle_model_text: '', vehicle_model_id: null,
                    models: [],
                }],
                vehicleMakes: vehicleMakes || [], // [{id, name}]

                // ── Origin ───────────────────────────────────────────────────
                originCountryId: defaultCountryId ? String(defaultCountryId) : '',
                originProvinces: initialProvinces || [],
                originProvinceText: '',
                originProvinceId: null,
                originCities: [],
                originCityText: '',
                originCityId: null,

                // ── Destination ──────────────────────────────────────────────
                destCountryId: defaultCountryId ? String(defaultCountryId) : '',
                destProvinces: initialProvinces || [],
                destProvinceText: '',
                destProvinceId: null,
                destCities: [],
                destCityText: '',
                destCityId: null,

                // ── Province / city matching helpers ─────────────────────────

                /**
                 * Find a province by name (case-insensitive exact match) in a given list.
                 * Returns {id, name} or null.
                 */
                findProvince(list, text) {
                    const t = text.trim().toLowerCase();
                    return list.find(p => p.name.toLowerCase() === t) ?? null;
                },

                /** Find a city by name in a given list. */
                findCity(list, text) {
                    const t = text.trim().toLowerCase();
                    return list.find(c => c.name.toLowerCase() === t) ?? null;
                },

                /** Find a vehicle make by name in vehicleMakes. */
                findMake(text) {
                    const t = text.trim().toLowerCase();
                    return this.vehicleMakes.find(m => m.name.toLowerCase() === t) ?? null;
                },

                /** Find a model by name in a vehicle's models list. */
                findModel(vehicleIndex, text) {
                    const t = text.trim().toLowerCase();
                    return this.vehicles[vehicleIndex].models.find(m => m.name.toLowerCase() === t) ?? null;
                },

                // ── Origin province ──────────────────────────────────────────

                async onOriginProvinceChange() {
                    const match = this.findProvince(this.originProvinces, this.originProvinceText);
                    this.originProvinceId = match ? match.id : null;
                    // Reset city when province changes
                    this.originCityText = '';
                    this.originCityId   = null;
                    this.originCities   = [];
                    if (match) {
                        await this.fetchOriginCities(match.id);
                    }
                },

                async fetchOriginProvinces() {
                    this.originProvinces   = [];
                    this.originProvinceText = '';
                    this.originProvinceId  = null;
                    this.originCities      = [];
                    this.originCityText    = '';
                    this.originCityId      = null;
                    if (!this.originCountryId) return;
                    try {
                        const resp = await fetch(`/quote-request/provinces/${this.originCountryId}`);
                        this.originProvinces = await resp.json();
                    } catch (e) {}
                },

                async fetchOriginCities(provinceId) {
                    this.originCities = [];
                    if (!provinceId) return;
                    try {
                        const resp = await fetch(`/quote-request/cities/${provinceId}`);
                        this.originCities = await resp.json();
                    } catch (e) {}
                },

                onOriginCityChange() {
                    const match = this.findCity(this.originCities, this.originCityText);
                    this.originCityId = match ? match.id : null;
                },

                // ── Destination province ─────────────────────────────────────

                async onDestProvinceChange() {
                    const match = this.findProvince(this.destProvinces, this.destProvinceText);
                    this.destProvinceId  = match ? match.id : null;
                    this.destCityText    = '';
                    this.destCityId      = null;
                    this.destCities      = [];
                    if (match) {
                        await this.fetchDestCities(match.id);
                    }
                },

                async fetchDestProvinces() {
                    this.destProvinces   = [];
                    this.destProvinceText = '';
                    this.destProvinceId  = null;
                    this.destCities      = [];
                    this.destCityText    = '';
                    this.destCityId      = null;
                    if (!this.destCountryId) return;
                    try {
                        const resp = await fetch(`/quote-request/provinces/${this.destCountryId}`);
                        this.destProvinces = await resp.json();
                    } catch (e) {}
                },

                async fetchDestCities(provinceId) {
                    this.destCities = [];
                    if (!provinceId) return;
                    try {
                        const resp = await fetch(`/quote-request/cities/${provinceId}`);
                        this.destCities = await resp.json();
                    } catch (e) {}
                },

                onDestCityChange() {
                    const match = this.findCity(this.destCities, this.destCityText);
                    this.destCityId = match ? match.id : null;
                },

                // ── Vehicles ─────────────────────────────────────────────────

                addVehicle() {
                    this.vehicles.push({
                        vehicle_year: '',
                        vehicle_make_text: '', vehicle_make_id: null,
                        vehicle_model_text: '', vehicle_model_id: null,
                        models: [],
                    });
                },

                removeVehicle(index) {
                    if (this.vehicles.length > 1) {
                        this.vehicles.splice(index, 1);
                    }
                },

                async onMakeChange(index) {
                    const text  = this.vehicles[index].vehicle_make_text;
                    const match = this.findMake(text);
                    this.vehicles[index].vehicle_make_id   = match ? match.id : null;
                    // Reset model when make changes
                    this.vehicles[index].vehicle_model_text = '';
                    this.vehicles[index].vehicle_model_id   = null;
                    this.vehicles[index].models             = [];
                    if (!text) return;
                    try {
                        const params = match
                            ? `make_id=${match.id}`
                            : `make=${encodeURIComponent(text)}`;
                        const resp = await fetch(`/quote-request/vehicle-models?${params}`);
                        this.vehicles[index].models = await resp.json();
                    } catch (e) {}
                },

                onModelChange(index) {
                    const match = this.findModel(index, this.vehicles[index].vehicle_model_text);
                    this.vehicles[index].vehicle_model_id = match ? match.id : null;
                },
            }
        }
    </script>

    @fluxScripts
</body>
</html>