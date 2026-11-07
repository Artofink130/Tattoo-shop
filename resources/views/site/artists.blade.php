@extends('layouts.app')

@section('title', 'Artists')

@section('content')
    <h1 class="text-3xl font-bold text-white mb-2">Choose an Artist</h1>
    <p class="text-neutral-400 mb-6">Pick a specialist, or send your idea and we'll match you.</p>

    @php
        $artists = [
            [
                'slug' => 'marina-costa',
                'name' => 'Marina Costa',
                'specialty' => 'Realism & Portraits',
                'city' => 'São Paulo, BR',
                'bio' => 'Photoreal black & grey portraits and large realism pieces.',
            ],
            [
                'slug' => 'joaquin-ferrer',
                'name' => 'Joaquín Ferrer',
                'specialty' => 'Fine-Line & Ornamental',
                'city' => 'Buenos Aires, AR',
                'bio' => 'Delicate linework, mandalas and ornamental compositions.',
            ],
            [
                'slug' => 'kenji-ward',
                'name' => 'Kenji Ward',
                'specialty' => 'Japanese & Large-Scale',
                'city' => 'Los Angeles, US',
                'bio' => 'Sleeves, back pieces and Japanese-inspired storytelling.',
            ],
            [
                'slug' => 'lia-santos',
                'name' => 'Lia Santos',
                'specialty' => 'Traditional & Lettering',
                'city' => 'Rio de Janeiro, BR',
                'bio' => 'Bold traditional, neo-traditional and custom lettering.',
            ],
        ];
    @endphp

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($artists as $artist)
            <x-artist-card :artist="$artist" />
        @endforeach
    </div>
@endsection