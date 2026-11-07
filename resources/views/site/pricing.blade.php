@extends('layouts.app')

@section('title', 'Premium Tattoo Menu')

@section('content')
    <h1 class="text-3xl font-bold text-white mb-2">
        Premium Tattoo Menu
    </h1>

    <p class="text-neutral-400 mb-8">
        Starting prices, every tattoo is priced individually by design, size,
        placement, detail, style, artist and time. Switch currency in the header.
    </p>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach ($prices as $group => $items)
            <div class="p-5 rounded-lg bg-neutral-900 border border-neutral-800">
                <h2 class="font-semibold text-amber-400 tracking-wide uppercase text-sm mb-3">
                    {{ $group }}
                </h2>

                @foreach ($items as [$name, $from])
                    <div class="flex justify-between py-2 border-t border-neutral-800 text-sm">
                        <span>{{ $name }}</span>

                        <span class="text-white">
                            @if ($from)
                                ${{ number_format((float) $from, 2) }}
                            @else
                                Custom quote
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-3 gap-4 mt-8 text-sm text-neutral-400">
        <div class="p-4 rounded bg-neutral-900 border border-neutral-800">
            <h3 class="text-white font-semibold mb-1">
                {{ config('studio.deposit_percent') }}% deposit
            </h3>

            To secure your appointment we require a
            {{ config('studio.deposit_percent') }}% deposit based on your
            quoted price. Payment details are sent once your design, placement,
            size and appointment date are confirmed. Deposits are generally
            non-refundable, rescheduling may be allowed with sufficient notice.
        </div>

        <div class="p-4 rounded bg-neutral-900 border border-neutral-800">
            <h3 class="text-white font-semibold mb-1">
                Have a budget?
            </h3>

            Tell us in your request. Share the piece you love and your budget,
            and your artist will tell you what is achievable.
        </div>

        <div class="p-4 rounded bg-neutral-900 border border-neutral-800">
            <h3 class="text-white font-semibold mb-1">
                Changes &amp; cover-ups
            </h3>

            Larger size, extra artwork, color or added sessions may revise the
            quote. Cover ups need an individual assessment, attach a clear photo.
        </div>
    </div>

    <a
        class="inline-block mt-8 px-5 py-3 bg-amber-500 text-black font-semibold rounded"
        href="{{ route('quote.create') }}"
    >
        Start with a consultation
    </a>
@endsection