@props(['artist'])

@php
    $initials = collect(explode(' ', $artist['name']))
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<div class="p-5 rounded-lg bg-neutral-900 border border-neutral-800">
    <div class="w-16 h-16 rounded-full bg-amber-500 text-black text-2xl font-bold flex items-center justify-center">
        {{ $initials }}
    </div>

    <h3 class="mt-3 font-semibold text-white">{{ $artist['name'] }}</h3>

    <p class="text-amber-400 text-sm">{{ $artist['specialty'] }}</p>

    <p class="text-xs text-neutral-500">{{ $artist['city'] }}</p>

    <p class="mt-2 text-sm text-neutral-400">{{ $artist['bio'] }}</p>

    <a
        class="inline-block mt-3 text-sm underline"
        href="{{ route('quote.create', ['artist' => $artist['slug']]) }}"
    >
        Request this artist
    </a>
</div>