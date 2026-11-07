@extends('layouts.app') @section('title', $consult ? 'Book a Consultation' : 'Request a Quote') 
@section('content')
<h1 class="text-3xl font-bold text-white mb-1">
    {{ $consult ? 'Book a Consultation' : 'Request a Quote' }}
</h1>
<p class="text-neutral-400 mb-6 text-sm">
    Submitting a request does not obligate you to book or pay. You'll see the price and deposit before any payment is requested.
</p>
<form method="POST" action="{{ route('quote.store') }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
    
@csrf
<input type="hidden" name="consultation" value="{{ $consult ? 1 : 0 }}">

<x-field name="name" label="Full name" required />
<x-field name="email" label="Email" type="email" required />
<x-field name="country" label="Country of appointment" required />
<x-field name="city" label="City" required />
<x-choice name="style" label="Style" :options="array_combine(config('studio.styles'), config('studio.styles'))" />
<x-choice name="color" label="Color" :options="array_combine(config('studio.colors'), config('studio.colors'))" />
<label class="block text-sm">
    <span class="text-neutral-400">
        Placement
    </span>
    <select name="placement" required class="mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2">
        <option value="">Choose a placement…</option>

        @foreach(config('studio.placements') as $group => $items)
        <optgroup label="{{ $group }}">@foreach($items as $i)
            <option @selected(old('placement') === $i)>{{ $i }}</option>
            @endforeach
        </optgroup>
        @endforeach
        <option @selected(old('placement') === 'Other / not sure')>Other / not sure</option>
    </select>
    @error('placement')
    <span class="text-red-400 text-xs">{{ $message }}</span>
    @enderror
</label>
<x-field name="size" label="Approximate size (cm or inches)" required />
<x-field name="timeframe" label="Preferred date / timeframe" />
<x-field name="budget" label="Your budget in USD (optional)" type="number" min="0" />
<x-choice name="artist_id" label="Preferred artist" blank="No preference" :value="$selected" :options="$artists->mapWithKeys(fn($a)=>[$a->id=>$a->name.' — '.$a->specialty])" />
<label class="md:col-span-2 text-sm">
    <span class="text-neutral-400">Describe your tattoo idea</span>
    <textarea name="idea" rows="5" required class="mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2">{{ old('idea') }}

    </textarea>
</label>
<label class="md:col-span-2 text-sm">
    <span class="text-neutral-400">Reference image (optional, max 5 MB  for cover ups, a clear photo of the existing tattoo)</span>
    <input class="block mt-1" type="file" name="reference" accept="image/*">
</label>
<button class="md:col-span-2 px-5 py-3 bg-amber-500 text-black font-semibold rounded">Send request</button>
</form>
<h2 class="text-xl font-bold text-white mt-12 mb-3">Tattoo placement guide</h2>
<div class="grid md:grid-cols-3 gap-4 text-sm">
    @foreach(config('studio.placements') as $group => $items)
<div class="p-4 rounded bg-neutral-900 border border-neutral-800">
    <h3 class="text-amber-400 font-semibold mb-2">{{ $group }}</h3>
    <ul class="list-disc ml-5 text-neutral-400 space-y-0.5">
        @foreach($items as $i)
        <li>{{ $i }}</li>
        @endforeach
    </ul>
</div>
@endforeach
</div>
@endsection
