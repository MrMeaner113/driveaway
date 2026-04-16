{{-- Shared input style --}}
@php
    $inp = 'width:100%; padding:0.625rem 0.875rem; border:1px solid var(--border-light); border-radius:6px; font-size:0.9375rem; outline:none; background:#fff; transition:border-color 0.2s;';
    $sectionHead = 'font-size:1rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--brand-red); margin-bottom:1rem;';
    $label = 'display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.375rem;';
    $err = 'color:var(--brand-red); font-size:0.8125rem; margin-top:0.25rem;';
    $focusStyle = "onfocus=\"this.style.borderColor='var(--brand-red)'\" onblur=\"this.style.borderColor='var(--border-light)'\"";
@endphp

<div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SUCCESS STATE                                                   --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    @if ($submitted)
        <div style="text-align:center; padding:3rem 1rem;">
            <div style="width:64px; height:64px; background:var(--highway-green); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.25rem;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:32px; height:32px;"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h3 style="font-size:1.5rem; font-weight:700; color:var(--highway-green); margin-bottom:0.75rem;">Quote Request Received!</h3>
            <p class="text-muted" style="max-width:440px; margin:0 auto;">
                Thanks, {{ $first_name }}! We've received your request and will be in touch shortly with your quote.
            </p>
            <p style="font-size:1.125rem; font-weight:700; color:var(--text-primary); margin-top:1rem;">
                Your quote reference number: <span style="color:var(--brand-red);">{{ $quote_number }}</span>
            </p>
            <p style="font-size:0.875rem; color:var(--text-muted);">
                Please keep this number for your records.
            </p>
        </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- FORM                                                            --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    @else
        <form wire:submit="submit" novalidate>

            {{-- ── Contact Information ──────────────────────────────────── --}}
            <div style="margin-bottom:1.75rem;">
                <h3 style="{{ $sectionHead }}">Contact Information</h3>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                    {{-- First Name --}}
                    <div>
                        <label style="{{ $label }}">First Name <span style="color:var(--brand-red)">*</span></label>
                        <input wire:model="first_name" type="text" placeholder="John" style="{{ $inp }}" {!! $focusStyle !!}>
                        @error('first_name') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label style="{{ $label }}">Last Name <span style="color:var(--brand-red)">*</span></label>
                        <input wire:model="last_name" type="text" placeholder="Smith" style="{{ $inp }}" {!! $focusStyle !!}>
                        @error('last_name') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label style="{{ $label }}">Email Address</label>
                        <input wire:model="email" type="email" placeholder="john@example.com" style="{{ $inp }}" {!! $focusStyle !!}>
                        @error('email') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone — formatted 000-000-0000 via Alpine, +1 prefix --}}
                    <div>
                        <label style="{{ $label }}">Phone Number</label>
                        <div x-data style="display:flex; align-items:stretch;">
                            <span style="padding:0.625rem 0.75rem; background:var(--bg-soft); border:1px solid var(--border-light); border-right:none; border-radius:6px 0 0 6px; font-size:0.9375rem; font-weight:600; color:var(--text-muted); white-space:nowrap;">+1</span>
                            <input
                                type="tel"
                                x-bind:value="$wire.phone"
                                x-on:input="
                                    let d = $event.target.value.replace(/\D/g, '').substring(0, 10);
                                    let f = d.length > 6
                                        ? d.slice(0,3) + '-' + d.slice(3,6) + '-' + d.slice(6)
                                        : d.length > 3
                                        ? d.slice(0,3) + '-' + d.slice(3)
                                        : d;
                                    $event.target.value = f;
                                    $wire.phone = f;
                                "
                                placeholder="000-000-0000"
                                style="{{ $inp }} border-radius:0 6px 6px 0;"
                                onfocus="this.style.borderColor='var(--brand-red)'"
                                onblur="this.style.borderColor='var(--border-light)'"
                            >
                        </div>
                        @error('phone') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                </div>
                <p style="font-size:0.8125rem; color:var(--text-muted); margin-top:0.5rem;">At least one contact method (email or phone) is required.</p>
            </div>

            {{-- ── Vehicle Details ───────────────────────────────────────── --}}
            <div style="margin-bottom:1.75rem;">
                <h3 style="{{ $sectionHead }}">Vehicle Details</h3>

                <div style="display:grid; grid-template-columns:120px 1fr 1fr; gap:1rem;">

                    {{-- Year --}}
                    <div>
                        <label style="{{ $label }}">Year <span style="color:var(--brand-red)">*</span></label>
                        <input wire:model="vehicle_year" type="number" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') + 2 }}" style="{{ $inp }}" {!! $focusStyle !!}>
                        @error('vehicle_year') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                    {{-- Make — autocomplete --}}
                    <div>
                        <label style="{{ $label }}">Make <span style="color:var(--brand-red)">*</span></label>
                        <div x-data style="position:relative;">
                            <input
                                wire:model.live.debounce.300ms="vehicle_make"
                                x-on:blur="setTimeout(() => $wire.clearMakeSuggestions(), 200)"
                                type="text"
                                placeholder="e.g. Honda"
                                style="{{ $inp }}"
                                onfocus="this.style.borderColor='var(--brand-red)'"
                                onblur="this.style.borderColor='var(--border-light)'"
                                autocomplete="off"
                            >
                            @if(count($make_suggestions) > 0)
                                <ul style="position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid var(--border-light); border-radius:6px; box-shadow:0 4px 12px rgba(0,0,0,0.08); z-index:100; margin-top:3px; padding:4px 0; list-style:none; max-height:200px; overflow-y:auto;">
                                    @foreach($make_suggestions as $s)
                                        <li
                                            wire:click="selectMake({{ $s['id'] }}, '{{ addslashes($s['name']) }}')"
                                            x-on:mouseover="$el.style.background='var(--bg-soft)'"
                                            x-on:mouseout="$el.style.background=''"
                                            style="padding:0.5rem 0.875rem; cursor:pointer; font-size:0.9375rem;"
                                        >{{ $s['name'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @error('vehicle_make') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                    {{-- Model — autocomplete --}}
                    <div>
                        <label style="{{ $label }}">Model <span style="color:var(--brand-red)">*</span></label>
                        <div x-data style="position:relative;">
                            <input
                                wire:model.live.debounce.300ms="vehicle_model"
                                x-on:blur="setTimeout(() => $wire.clearModelSuggestions(), 200)"
                                type="text"
                                placeholder="e.g. Civic"
                                style="{{ $inp }}"
                                onfocus="this.style.borderColor='var(--brand-red)'"
                                onblur="this.style.borderColor='var(--border-light)'"
                                autocomplete="off"
                            >
                            @if(count($model_suggestions) > 0)
                                <ul style="position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid var(--border-light); border-radius:6px; box-shadow:0 4px 12px rgba(0,0,0,0.08); z-index:100; margin-top:3px; padding:4px 0; list-style:none; max-height:200px; overflow-y:auto;">
                                    @foreach($model_suggestions as $s)
                                        <li
                                            wire:click="selectModel({{ $s['id'] }}, '{{ addslashes($s['name']) }}')"
                                            x-on:mouseover="$el.style.background='var(--bg-soft)'"
                                            x-on:mouseout="$el.style.background=''"
                                            style="padding:0.5rem 0.875rem; cursor:pointer; font-size:0.9375rem;"
                                        >{{ $s['name'] }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @error('vehicle_model') <p style="{{ $err }}">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>

            {{-- ── Route ─────────────────────────────────────────────────── --}}
            <div style="margin-bottom:1.75rem;">
                <h3 style="{{ $sectionHead }}">Route</h3>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">

                    {{-- Origin --}}
                    <div style="border:1px solid var(--border-light); border-radius:8px; padding:1rem;">
                        <p style="font-size:0.8125rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:var(--text-muted); margin-bottom:0.75rem;">Origin (Pickup)</p>

                        {{-- Country --}}
                        <div style="margin-bottom:0.75rem;">
                            <label style="{{ $label }}">Country <span style="color:var(--brand-red)">*</span></label>
                            <select wire:model.live="origin_country_id" style="{{ $inp }}" {!! $focusStyle !!}>
                                <option value="">Select country…</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('origin_country_id') <p style="{{ $err }}">{{ $message }}</p> @enderror
                        </div>

                        {{-- Province / State --}}
                        <div style="margin-bottom:0.75rem;">
                            <label style="{{ $label }}">Province / State <span style="color:var(--brand-red)">*</span></label>
                            <select wire:model.live="origin_province_id" style="{{ $inp }}" {!! $focusStyle !!} @disabled(!$origin_country_id)>
                                <option value="">{{ $origin_country_id ? 'Select province / state…' : 'Select a country first' }}</option>
                                @foreach($originProvinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('origin_province_id') <p style="{{ $err }}">{{ $message }}</p> @enderror
                        </div>

                        {{-- City --}}
                        <div>
                            <label style="{{ $label }}">City <span style="color:var(--brand-red)">*</span></label>
                            <div x-data style="position:relative;">
                                <input
                                    wire:model.live.debounce.300ms="origin_city_input"
                                    x-on:blur="setTimeout(() => $wire.clearOriginCitySuggestions(), 200)"
                                    type="text"
                                    placeholder="{{ $origin_province_id ? 'Type to search cities…' : 'Select a province first' }}"
                                    style="{{ $inp }}"
                                    onfocus="this.style.borderColor='var(--brand-red)'"
                                    onblur="this.style.borderColor='var(--border-light)'"
                                    autocomplete="off"
                                    @disabled(!$origin_province_id)
                                >
                                @if(count($origin_city_suggestions) > 0)
                                    <ul style="position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid var(--border-light); border-radius:6px; box-shadow:0 4px 12px rgba(0,0,0,0.08); z-index:100; margin-top:3px; padding:4px 0; list-style:none; max-height:200px; overflow-y:auto;">
                                        @foreach($origin_city_suggestions as $s)
                                            <li
                                                wire:click="selectOriginCity({{ $s['id'] }}, '{{ addslashes($s['name']) }}')"
                                                x-on:mouseover="$el.style.background='var(--bg-soft)'"
                                                x-on:mouseout="$el.style.background=''"
                                                style="padding:0.5rem 0.875rem; cursor:pointer; font-size:0.9375rem;"
                                            >{{ $s['name'] }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <p style="font-size:0.8125rem; color:var(--text-muted); margin-top:0.25rem;">Can't find your city? Type it in — we'll confirm it.</p>
                            @error('origin_city_input') <p style="{{ $err }}">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Destination --}}
                    <div style="border:1px solid var(--border-light); border-radius:8px; padding:1rem;">
                        <p style="font-size:0.8125rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:var(--text-muted); margin-bottom:0.75rem;">Destination (Delivery)</p>

                        {{-- Country --}}
                        <div style="margin-bottom:0.75rem;">
                            <label style="{{ $label }}">Country <span style="color:var(--brand-red)">*</span></label>
                            <select wire:model.live="destination_country_id" style="{{ $inp }}" {!! $focusStyle !!}>
                                <option value="">Select country…</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('destination_country_id') <p style="{{ $err }}">{{ $message }}</p> @enderror
                        </div>

                        {{-- Province / State --}}
                        <div style="margin-bottom:0.75rem;">
                            <label style="{{ $label }}">Province / State <span style="color:var(--brand-red)">*</span></label>
                            <select wire:model.live="destination_province_id" style="{{ $inp }}" {!! $focusStyle !!} @disabled(!$destination_country_id)>
                                <option value="">{{ $destination_country_id ? 'Select province / state…' : 'Select a country first' }}</option>
                                @foreach($destinationProvinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('destination_province_id') <p style="{{ $err }}">{{ $message }}</p> @enderror
                        </div>

                        {{-- City --}}
                        <div>
                            <label style="{{ $label }}">City <span style="color:var(--brand-red)">*</span></label>
                            <div x-data style="position:relative;">
                                <input
                                    wire:model.live.debounce.300ms="destination_city_input"
                                    x-on:blur="setTimeout(() => $wire.clearDestinationCitySuggestions(), 200)"
                                    type="text"
                                    placeholder="{{ $destination_province_id ? 'Type to search cities…' : 'Select a province first' }}"
                                    style="{{ $inp }}"
                                    onfocus="this.style.borderColor='var(--brand-red)'"
                                    onblur="this.style.borderColor='var(--border-light)'"
                                    autocomplete="off"
                                    @disabled(!$destination_province_id)
                                >
                                @if(count($destination_city_suggestions) > 0)
                                    <ul style="position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid var(--border-light); border-radius:6px; box-shadow:0 4px 12px rgba(0,0,0,0.08); z-index:100; margin-top:3px; padding:4px 0; list-style:none; max-height:200px; overflow-y:auto;">
                                        @foreach($destination_city_suggestions as $s)
                                            <li
                                                wire:click="selectDestinationCity({{ $s['id'] }}, '{{ addslashes($s['name']) }}')"
                                                x-on:mouseover="$el.style.background='var(--bg-soft)'"
                                                x-on:mouseout="$el.style.background=''"
                                                style="padding:0.5rem 0.875rem; cursor:pointer; font-size:0.9375rem;"
                                            >{{ $s['name'] }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <p style="font-size:0.8125rem; color:var(--text-muted); margin-top:0.25rem;">Can't find your city? Type it in — we'll confirm it.</p>
                            @error('destination_city_input') <p style="{{ $err }}">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Pickup / Delivery Date ────────────────────────────────── --}}
            <div style="margin-bottom:2rem;">
                <h3 style="{{ $sectionHead }}">Pickup / Delivery Date</h3>

                <div style="display:flex; gap:1.5rem; margin-bottom:1rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.9375rem; font-weight:600;">
                        <input type="radio" wire:model.live="date_type" value="pickup"
                               style="width:18px; height:18px; accent-color:var(--brand-red); cursor:pointer;">
                        Preferred Pickup Date
                    </label>
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.9375rem; font-weight:600;">
                        <input type="radio" wire:model.live="date_type" value="delivery"
                               style="width:18px; height:18px; accent-color:var(--brand-red); cursor:pointer;">
                        Preferred Delivery Date
                    </label>
                </div>

                <div style="max-width:260px;">
                    <label style="{{ $label }}">
                        @if($date_type === 'pickup')
                            When should we pick up your vehicle?
                        @else
                            When do you need your vehicle delivered?
                        @endif
                        <span style="color:var(--brand-red)">*</span>
                    </label>
                    <input wire:model="preferred_date" type="date" min="{{ date('Y-m-d') }}" style="{{ $inp }}" {!! $focusStyle !!}>
                    @error('preferred_date') <p style="{{ $err }}">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- ── Submit ────────────────────────────────────────────────── --}}
            <div style="text-align:center;">
                <button type="submit" class="btn-brand" style="padding:0.875rem 3rem; font-size:1rem;"
                    wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-not-allowed">
                    <span wire:loading.remove>Get My Free Quote</span>
                    <span wire:loading>Submitting…</span>
                </button>
            </div>

        </form>
    @endif

</div>
