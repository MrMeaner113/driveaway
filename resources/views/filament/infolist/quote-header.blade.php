<div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200">
    <div>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Quote Request</p>
        <p class="text-2xl font-bold text-gray-900">{{ $record->quote_number ?? '—' }}</p>
    </div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
        {{ ucfirst($record->status) }}
    </span>
</div>
