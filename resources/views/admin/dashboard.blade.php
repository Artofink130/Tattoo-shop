@extends('layouts.admin') 
@section('title','Dashboard') 
@section('content')
<h1 class="text-2xl font-bold text-white mb-6">Dashboard</h1>
@if($undelivered->isNotEmpty())
<div class="mb-6 p-4 rounded border border-red-700 bg-red-900/40 text-sm">
    <b>Studio email was not delivered for {{ $undelivered->count() }} recent request(s).</b> Run 
    <code>php artisan studio:test-mail</code> to find the cause, then use “Resend email” on each request.
@foreach($undelivered as $u)
<div class="mt-1">
    <a class="underline" href="{{ route('admin.quotes.show',$u) }}">{{ $u->name }}</a> — 
    <span class="text-red-300">
        {{ \Illuminate\Support\Str::limit($u->mail_error,140) }}
    </span>
</div>
@endforeach
</div>
@endif
@if($mailWarning)
<div class="mb-6 p-3 rounded bg-amber-900/50 border border-amber-700 text-sm"><b>Request emails are not reaching the studio:</b> {{ $mailWarning }} Run <code>php artisan mail:test</code> on the server to diagnose.</div>
@endif
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
@foreach(\App\Enums\QuoteStatus::cases() as $s)@continue($s === \App\Enums\QuoteStatus::Cancelled)
<a href="{{ route('admin.quotes.index',['status'=>$s->value]) }}" class="p-4 rounded bg-neutral-900 border border-neutral-800">
    <div class="text-3xl font-bold text-white">
        {{ $counts[$s->value] ?? 0 }}
    </div>
    <div class="text-xs text-neutral-500">
        {{ $s->label() }}
    </div>
</a>
@endforeach
<div class="p-4 rounded bg-neutral-900 border border-neutral-800">
    <div class="text-3xl font-bold text-emerald-400">
        ${{ number_format($revenue,0) }}
    </div>
    <div class="text-xs text-neutral-500">
        Verified deposits (USD)
    </div>
</div>
</div>
<h2 class="font-semibold text-white mb-2">Payments awaiting verification</h2>
@forelse($pending as $p)
<div class="flex flex-wrap items-center gap-3 border-t border-neutral-800 py-2 text-sm">
    <a class="underline" href="{{ route('admin.quotes.show',$p->quote) }}">
        {{ $p->quote->name }}
    </a>
<span>
    {{ $p->coin->value }} · ${{ number_format($p->amount_usd,2) }}
</span>
<code class="break-all text-neutral-400">
    {{ $p->txid }}
</code>
</div>
@empty
<p class="text-sm text-neutral-500 mb-4">Nothing pending.</p>
@endforelse
<h2 class="font-semibold text-white mt-8 mb-2">Recent requests</h2>
@foreach($recent as $q)
<div class="flex items-center gap-3 border-t border-neutral-800 py-2 text-sm">
    <a class="underline" href="{{ route('admin.quotes.show',$q) }}">
        {{ $q->name }}
    </a>
    <span class="text-neutral-500">{{ $q->style }} · {{ $q->created_at->diffForHumans() }}</span>
    <span class="ml-auto"><x-badge :status="$q->status" /></span>
</div>
@endforeach
@endsection
