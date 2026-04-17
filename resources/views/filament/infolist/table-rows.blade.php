<div style="margin-bottom: 1.5rem;">
    @if($heading ?? null)
        <h3 style="font-size: 1.0rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">{{ $heading }}</h3>
    @endif
    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
        @foreach($rows as $i => [$label, $value])
            <tr style="background: {{ $i % 2 === 0 ? '#ffffff' : '#f9fafb' }};">
                <td style="padding: 0.5rem 0.75rem; font-weight: 600; color: #4b5563; width: 40%; border-bottom: 1px solid #f3f4f6;">{{ $label }}</td>
                <td style="padding: 0.5rem 0.75rem; color: #111827; border-bottom: 1px solid #f3f4f6;">{!! $value !!}</td>
            </tr>
        @endforeach
    </table>
</div>