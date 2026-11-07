<x-mail::message>
# New {{ $quote->consultation ? 'consultation' : 'quote' }} request

**{{ $quote->name }}** · {{ $quote->email }}  
{{ $quote->city }}, {{ $quote->country }}

- **Idea:** {{ \Illuminate\Support\Str::squish($quote->idea) }}
- **Style / color:** {{ $quote->style }} · {{ $quote->color }}
- **Placement:** {{ $quote->placement }}
- **Size:** {{ $quote->size }}
- **Preferred date:** {{ $quote->timeframe ?: '—' }}
- **Budget:** {{ $quote->budget ? '$'.number_format($quote->budget) : '—' }}
- **Preferred artist:** {{ $quote->artist?->name ?? 'No preference' }}

@if($quote->reference)
The reference image is attached.
@endif



</x-mail::message>
