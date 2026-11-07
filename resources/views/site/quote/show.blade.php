@extends('layouts.app') 
@section('title','Your quote') 
@section('content')
<div class="flex items-center gap-3 mb-6">
    <h1 class="text-3xl font-bold text-white">Your {{ $quote->consultation ? 'consultation request' : 'quote' }}</h1>
    <x-badge :status="$quote->status" />
</div>
<div class="grid md:grid-cols-2 gap-6">
<div class="p-5 rounded-lg bg-neutral-900 border border-neutral-800 text-sm space-y-1.5">
<div>
    <b>Idea:</b> {{ $quote->idea }}
</div>
<div>
    <b>Style:</b> {{ $quote->style }} · {{ $quote->color }}
</div>
<div>
    <b>Placement / size:</b> {{ $quote->placement }} · {{ $quote->size }}
</div>
<div>
    <b>Location:</b> {{ $quote->city }}, {{ $quote->country }}
</div>
<div>
    <b>Artist:</b> {{ $quote->artist?->name ?? 'To be matched' }}
</div>
@if($quote->price)
<div class="pt-2 text-base">
    <b>Estimated price:</b> {{ money($quote->price) }} · <b>Deposit:</b> {{ money($quote->deposit) }}
</div>
@endif
</div>

<div class="p-5 rounded-lg bg-neutral-900 border border-neutral-800 text-sm">
@if($quote->isPayable())
<h2 class="font-semibold text-white mb-2">Pay your deposit with crypto</h2>
<p class="text-neutral-400 mb-3">Send the USD value of your deposit (${{ number_format($quote->deposit,2) }}) in your chosen coin to the matching address, on the listed network only. Then submit the transaction ID.</p>
@foreach($coins as $coin)
<div class="mb-2">
    <b>{{ $coin->value }}</b> 
    <span class="text-neutral-500">({{ $coin->network() }})</span>
    <code class="block break-all bg-black p-2 rounded select-all">{{ $coin->address() }}

    </code>
</div>
@endforeach
<form method="POST" action="{{ route('quote.pay',$quote->token) }}" class="mt-4 space-y-3">
    @csrf
<x-choice name="coin" label="Coin used" :options="collect($coins)->mapWithKeys(fn($c)=>[$c->value=>$c->value])" />
<x-field name="txid" label="Transaction ID / hash" required />
<button class="px-4 py-2 bg-amber-500 text-black font-semibold rounded">Submit payment</button>
</form>
@elseif($quote->status === \App\Enums\QuoteStatus::PaymentSubmitted)
<p class="text-amber-300">Payment submitted, awaiting on chain verification. You'll receive an email once confirmed.</p>
@elseif($quote->status === \App\Enums\QuoteStatus::Confirmed)
<p class="text-emerald-400">Booking confirmed. Your artist will contact you with session details.</p>
@elseif($quote->status === \App\Enums\QuoteStatus::Cancelled)
<p>This request was cancelled. Contact us if this is a mistake.</p>

@else
<p>We're reviewing your project and will email <b>{{ $quote->email }}</b> with your quote. Bookmark this page to follow progress.</p>
@endif
@if($quote->payments->isNotEmpty())
<h3 class="mt-5 font-semibold text-white">Payments</h3>
@foreach($quote->payments as $p)
<div class="flex justify-between border-t border-neutral-800 py-1">
    <span>{{ $p->coin->value }} · <code>{{ \Illuminate\Support\Str::limit($p->txid,14) }}</code>
</span>
<span class="px-2 rounded text-xs {{ $p->status->color() }}">{{ $p->status->label() }}</span>
</div>
@endforeach
 @endif
</div>
</div>
@endsection
