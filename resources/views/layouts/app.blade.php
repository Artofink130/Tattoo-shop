<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title', config('studio.name').' — Custom Tattoos')</title>
<meta name="description" content="Custom tattoos by experienced artists in Brazil, Argentina and the US. Get a quote, choose an artist or book a consultation.">
<link rel="icon" type="image/png" href="/img/favicon.png"><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-neutral-950 text-neutral-200 min-h-screen flex flex-col antialiased">
<header class="border-b border-neutral-800 sticky top-0 bg-neutral-950/90 backdrop-blur z-10"><div class="max-w-6xl mx-auto px-4 py-4 flex flex-wrap items-center gap-4">
<a href="{{ route('home') }}" class="flex items-center gap-3 text-xl font-bold tracking-widest text-white"><img src="/img/logo.png" alt="{{ config('studio.name') }} logo" class="h-12 w-12">{{ strtoupper(config('studio.name')) }}</a>
<nav class="flex flex-wrap gap-5 text-sm ml-auto items-center">
<a href="{{ route('artists') }}">Artists</a><a href="{{ route('pricing') }}">Pricing</a>
<a class="px-3 py-1.5 bg-amber-500 text-black font-semibold rounded" href="{{ route('quote.create') }}">Get a Quote</a>
@if(auth()->user()?->is_admin)<a class="text-amber-400" href="{{ route('admin.dashboard') }}">Admin</a>@endif
<span class="text-neutral-500">@foreach(app(\App\Services\CurrencyService::class)->supported() as $c)<a class="px-1 {{ app(\App\Services\CurrencyService::class)->current()===$c?'text-white font-bold':'' }}" href="{{ route('currency',$c) }}">{{ $c }}</a>@endforeach</span>
</nav></div></header>
<main class="flex-1 max-w-6xl w-full mx-auto px-4 py-10">@include('layouts.alerts')@yield('content')</main>
<footer class="border-t border-neutral-800 text-center text-xs text-neutral-500 py-8 px-4 space-y-1">
<p>Clients are all welcomed, remote consultations available.</p>
<p>All prices are starting prices and estimates, final pricing is confirmed after project review. Deposits are generally non-refundable. Local regulations vary by location and artist.</p>
<p>Hygiene: single use sterile needles, disposable barriers, sanitized surfaces. © {{ date('Y') }} {{ config('studio.name') }}</p></footer></body></html>
