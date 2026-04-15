<x-filament-panels::page>

    {{-- ── Filters ── --}}
    <x-filament::section>
        <x-slot name="heading">Filters</x-slot>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">

            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    From
                </label>
                <input type="date" wire:model.live="date_from"
                       class="fi-input block w-full rounded-lg border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-950 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500 px-3 py-1.5" />
            </div>

            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Until
                </label>
                <input type="date" wire:model.live="date_until"
                       class="fi-input block w-full rounded-lg border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-950 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500 px-3 py-1.5" />
            </div>

            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Work Order
                </label>
                <select wire:model.live="work_order_id"
                        class="fi-input block w-full rounded-lg border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-950 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500 px-3 py-1.5">
                    <option value="">All</option>
                    @foreach($this->getWorkOrderOptions() as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Driver
                </label>
                <select wire:model.live="driver_id"
                        class="fi-input block w-full rounded-lg border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-950 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500 px-3 py-1.5">
                    <option value="">All</option>
                    @foreach($this->getDriverOptions() as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Vehicle
                </label>
                <select wire:model.live="vehicle_id"
                        class="fi-input block w-full rounded-lg border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-950 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500 px-3 py-1.5">
                    <option value="">All</option>
                    @foreach($this->getVehicleOptions() as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="fi-fo-field-wrp-label block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Category
                </label>
                <select wire:model.live="expense_category_id"
                        class="fi-input block w-full rounded-lg border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-sm text-gray-950 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500 px-3 py-1.5">
                    <option value="">All</option>
                    @foreach($this->getCategoryOptions() as $id => $label)
                        <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </x-filament::section>

    {{-- ── Summary Cards ── --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mt-6">

        @php
            $cards = [
                ['label' => 'Total Expenses',          'value' => $this->formatDollars($this->getTotalExpenses())],
                ['label' => 'Total Fuel Costs',        'value' => $this->formatDollars($this->getTotalFuel())],
                ['label' => 'Combined Total',          'value' => $this->formatDollars($this->getCombinedTotal())],
                ['label' => 'Jobs with Expenses',      'value' => $this->getJobsWithExpensesCount()],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-white/10 shadow-sm p-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $card['label'] }}</p>
                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $card['value'] }}</p>
            </div>
        @endforeach

    </div>

    {{-- ── By Category ── --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Breakdown by Category</x-slot>

        @php $categoryBreakdown = $this->getCategoryBreakdown(); @endphp

        @if($categoryBreakdown->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">No expense data for the selected filters.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-white/10">
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300">Category</th>
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300 text-right">Count</th>
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryBreakdown as $row)
                            <tr class="border-b border-gray-100 dark:border-white/5">
                                <td class="py-2 text-gray-900 dark:text-white">{{ $row['category'] }}</td>
                                <td class="py-2 text-right text-gray-600 dark:text-gray-400">{{ $row['count'] }}</td>
                                <td class="py-2 text-right font-medium text-gray-900 dark:text-white">{{ $this->formatDollars($row['total']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

    {{-- ── By Work Order ── --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Breakdown by Work Order</x-slot>

        @php $woBreakdown = $this->getWorkOrderBreakdown(); @endphp

        @if($woBreakdown->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">No expense data for the selected filters.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-white/10">
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300">Work Order</th>
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300 text-right">Expenses</th>
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300 text-right">Fuel</th>
                            <th class="pb-3 font-semibold text-gray-700 dark:text-gray-300 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($woBreakdown as $row)
                            <tr class="border-b border-gray-100 dark:border-white/5">
                                <td class="py-2 font-medium text-gray-900 dark:text-white">{{ $row['work_order_number'] }}</td>
                                <td class="py-2 text-right text-gray-600 dark:text-gray-400">{{ $this->formatDollars($row['expenses']) }}</td>
                                <td class="py-2 text-right text-gray-600 dark:text-gray-400">{{ $this->formatDollars($row['fuel']) }}</td>
                                <td class="py-2 text-right font-semibold text-gray-900 dark:text-white">{{ $this->formatDollars($row['total']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
