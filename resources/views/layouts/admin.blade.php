<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex">
<title>@yield('title','Admin') · {{ config('studio.name') }}</title><link rel="icon" type="image/png" href="/img/favicon.png"><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-neutral-950 text-neutral-200 min-h-screen md:flex">
<aside class="md:w-56 md:min-h-screen bg-neutral-900 border-r border-neutral-800 p-4 flex md:block gap-4 flex-wrap text-sm">
<div class="font-bold text-white tracking-widest md:mb-6 w-full md:w-auto flex items-center gap-2"><img src="/img/logo.png" alt="" class="h-9 w-9">ADMIN</div>
@foreach([['admin.dashboard','Dashboard'],['admin.quotes.index','Requests'],['admin.artists.index','Artists']] as [$r,$l])
<a class="block md:mb-2 {{ request()->routeIs(str_replace('.index','.*',$r))?'text-amber-400':'' }}" href="{{ route($r) }}">{{ $l }}</a>@endforeach
<a class="block md:mt-6 text-neutral-500" href="{{ route('home') }}" target="_blank">View site ↗</a>
<form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="text-neutral-500 underline">Sign out</button></form></aside>
<main class="flex-1 p-6 min-w-0">@include('layouts.alerts')@yield('content')</main></body></html>
