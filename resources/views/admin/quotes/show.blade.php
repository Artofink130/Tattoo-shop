@extends('layouts.admin')
 @section('title',$quote->name)
  @section('content')
<a class="text-sm underline" href="{{ route('admin.quotes.index') }}">← Requests</a>
<div class="flex items-center gap-3 my-3">
    <h1 class="text-2xl font-bold text-white">{{ $quote->name }}</h1>
    <x-badge :status="$quote->status" />
</div>
<div class="grid lg:grid-cols-2 gap-6">
    <div class="p-5 rounded-lg bg-neutral-900 border border-neutral-800 text-sm space-y-1.5">
        <div>{{ $quote->email }}</div>
        <div><b>Idea:</b> {{ $quote->idea }}</div>
        <div>{{ $quote->style }} · {{ $quote->color }} · {{ $quote->placement }} · {{ $quote->size }}</div>
        <div>{{ $quote->city }}, {{ $quote->country }} · {{ $quote->timeframe ?: 'no date given' }}</div>
        @if($quote->budget)
        <div><b>Client budget:</b> ${{ number_format($quote->budget) }}</div>
        @endif
        <div class="text-neutral-500">Leave deposit empty to default to {{ config('studio.deposit_percent') }}% of the price.</div>
@if($quote->reference)
<a href="{{ asset('storage/'.$quote->reference) }}" target="_blank">
    <img class="mt-2 max-h-72 rounded" src="{{ asset('storage/'.$quote->reference) }}" alt="Reference"></a>@endif
        <div class="pt-3 border-t border-neutral-800">
@if($quote->studio_notified_at)
<span class="text-emerald-400">✓ Studio email sent {{ $quote->studio_notified_at->diffForHumans() }}</span>
@else
<span class="text-red-400">
    ✗ Studio email not delivered
</span>
@if($quote->mail_error)
<div class="text-xs text-red-300 break-words">{{ $quote->mail_error }}</div>
@endif 
@endif
<form method="POST" action="{{ route('admin.quotes.resend',$quote) }}" class="mt-2">
    @csrf
    <button class="px-3 py-1 bg-neutral-800 rounded text-xs">
        Resend email
    </button>
</form>
</div>
<div class="pt-2">
    <a class="underline" target="_blank" href="{{ route('quote.show',$quote->token) }}">
        Client's page ↗
    </a>
</div>
</div>
<form method="POST" action="{{ route('admin.quotes.update',$quote) }}" class="space-y-3">
    @csrf @method('PUT')
        <x-choice name="artist_id" label="Artist" blank="Unassigned" :value="$quote->artist_id" :options="$artists->pluck('name','id')" />
<div class="grid grid-cols-2 gap-3">
    <x-field name="price" label="Price (USD)" type="number" step="0.01" :value="$quote->price" />
    <x-field name="deposit" label="Deposit (USD)" type="number" step="0.01" :value="$quote->deposit" />
</div>
<x-choice name="status" label="Status" :value="$quote->status->value" :options="collect($statuses)->mapWithKeys(fn($s)=>[$s->value=>$s->label()])" />
<label class="block text-sm">
    <span class="text-neutral-400">Internal note</span>
    <textarea name="admin_note" rows="3" class="mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2">{{ old('admin_note',$quote->admin_note) }}

    </textarea>
</label>
<button class="px-4 py-2 bg-amber-500 text-black font-semibold rounded">Save</button>
</form>
</div>
<h2 class="font-semibold text-white mt-8 mb-2">Payments</h2>
@forelse($quote->payments as $p)
<div class="flex flex-wrap items-center gap-3 border-t border-neutral-800 py-2 text-sm">
    <span>{{ $p->coin->value }} · ${{ number_format($p->amount_usd,2) }}</span>
    <code class="break-all text-neutral-400">{{ $p->txid }}</code>
<span class="px-2 rounded text-xs {{ $p->status->color() }}">{{ $p->status->label() }}</span>
@if($p->status === \App\Enums\PaymentStatus::Pending)
<span class="ml-auto flex gap-2">
    <form method="POST" action="{{ route('admin.payments.verify',$p) }}" onsubmit="return confirm('Confirm you verified this transaction on-chain?')">
        @csrf
        <button class="px-3 py-1 bg-emerald-600 rounded">Verify</button>
    </form>
<form method="POST" action="{{ route('admin.payments.reject',$p) }}">
    @csrf
    <button class="px-3 py-1 bg-red-700 rounded">Reject</button>
</form>
</span>
@endif
</div>
@empty
<p class="text-sm text-neutral-500">No payments submitted.</p>
@endforelse
@endsection
