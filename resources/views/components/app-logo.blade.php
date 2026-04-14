@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand {{ $attributes }}>
        <x-slot name="logo">
            <img src="/images/logo.png" alt="Drive-Away.ca" style="height: 32px; width: auto;">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand {{ $attributes }}>
        <x-slot name="logo">
            <img src="/images/logo.png" alt="Drive-Away.ca" style="height: 32px; width: auto;">
        </x-slot>
    </flux:brand>
@endif
