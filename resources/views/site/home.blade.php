@extends('layouts.app') @section('content')
<section class="grid md:grid-cols-2 gap-10 items-center">
<div><p class="text-amber-400 text-sm tracking-widest mb-2">YOUR IDEA. YOUR STORY. YOUR TATTOO.</p><h1 class="text-4xl md:text-5xl font-bold text-white leading-tight">Your skin deserves more than ordinary ink.</h1>
<p class="mt-4 text-neutral-400">Custom artistry. Private sessions. Exceptional detail, by experienced artists.

</p>
<div class="mt-6 flex flex-wrap gap-3"><a class="px-5 py-3 bg-amber-500 text-black font-semibold rounded" href="{{ route('quote.create') }}">Get a Quote</a>
<a class="px-5 py-3 border border-neutral-600 rounded" href="{{ route('artists') }}">Choose an Artist</a>
<a class="px-5 py-3 border border-neutral-600 rounded" href="{{ route('quote.create',['consult'=>1]) }}">Book a Consultation</a></div></div>
<img src="/img/hero.png" alt="Custom tattoo flash artwork" class="rounded-lg w-full"></section>

<section class="mt-16"><h2 class="text-2xl font-bold text-white mb-4">Styles we work in</h2>
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">@foreach(['realism','fineline','blackwork','japanese','traditional','lettering'] as $s)<img src="/img/style-{{ $s }}.png" alt="{{ ucfirst($s) }} style sample" class="rounded-lg w-full">@endforeach</div>
<p class="mt-3 text-sm text-neutral-500">Also: portraits, black & grey, minimalist, neo traditional, ornamental, color, sleeves, large scale projects and cover ups.</p></section>

<section class="mt-16"><h2 class="text-2xl font-bold text-white mb-4">How it works</h2><ol class="grid md:grid-cols-3 gap-4 text-sm">
@foreach(['Tell us your design idea, size, placement and any reference picture.','Every appointment begins with a consultation, so we understand your vision.','We match you with the right artist for your style.','Receive your quote, no payment until you approve it.','Pay a 50% deposit in crypto to secure your appointment.','Get tattooed. Large projects may span several sessions.'] as $i=>$t)
<li class="p-4 rounded bg-neutral-900 border border-neutral-800"><b class="text-amber-400">{{ $i+1 }}.</b> {{ $t }}</li>@endforeach</ol></section>

<section class="mt-16 p-6 rounded-lg bg-neutral-900 border border-neutral-800"><h2 class="text-2xl font-bold text-white mb-2">Welcome, new clients</h2>
<p class="text-neutral-400">Thank you for choosing {{ config('studio.name') }} for your next piece of art. Whether it's your first tattoo or you're adding to your collection, we're here to make your experience comfortable, creative and memorable.</p>
<p class="text-neutral-400 mt-2">To get started we just need to know the design you have in mind, the size, where you want it placed, and whether you already have a reference picture.</p></section>
@if($gallery->isNotEmpty())<section class="mt-16"><h2 class="text-2xl font-bold text-white mb-4">Our work</h2><div class="grid grid-cols-2 md:grid-cols-3 gap-4">@foreach($gallery as $g)<img src="{{ $g }}" alt="Tattoo by {{ config('studio.name') }}" loading="lazy" class="rounded-lg w-full aspect-square object-cover">@endforeach</div></section>@endif
<section class="mt-16"><h2 class="text-2xl font-bold text-white mb-4">Featured artists</h2>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">@foreach($artists as $a)<x-artist-card :artist="$a" />@endforeach</div></section>

<section class="mt-16 grid md:grid-cols-3 gap-4 text-sm">
<div class="p-5 rounded bg-neutral-900 border border-neutral-800"><h3 class="font-semibold text-white mb-1">International clients</h3>Traveling for your tattoo? Tell us your dates, remote consultations are available.</div>
<div class="p-5 rounded bg-neutral-900 border border-neutral-800"><h3 class="font-semibold text-white mb-1">Cover-ups & rework</h3>Attach a clear photo of your existing tattoo and the artist will assess it individually.</div>
<div class="p-5 rounded bg-neutral-900 border border-neutral-800"><h3 class="font-semibold text-white mb-1">Safety first</h3>Single use sterile needles, disposable barriers and professional aftercare guidance.</div></section>
@endsection
