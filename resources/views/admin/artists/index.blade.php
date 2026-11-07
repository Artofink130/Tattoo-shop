@extends('layouts.admin') 
@section('title','Artists') 
@section('content')
<h1 class="text-2xl font-bold text-white mb-4">
    Artists
</h1>
@foreach($artists as $a)
<div class="flex items-center gap-3 border-t border-neutral-800 py-2 text-sm">
    <span>{{ $a->name }} — {{ $a->specialty }} ({{ $a->city }}) 
        <span class="text-neutral-500">· {{ $a->quotes_count }} requests
            
        </span>
    </span>
<a class="ml-auto underline" href="{{ route('admin.artists.edit',$a) }}">
    Edit
</a>
<form method="POST" action="{{ route('admin.artists.destroy',$a) }}" onsubmit="return confirm('Remove this artist?')">
    @csrf 
    @method('DELETE')
    <button class="text-red-400">
        Remove
    </button>
</form>
</div>
@endforeach
<h2 class="font-semibold text-white mt-8 mb-2">
    Add artist
</h2>
<form method="POST" action="{{ route('admin.artists.store') }}" class="grid md:grid-cols-2 gap-3">
    @csrf
    <x-field name="name" label="Name" required />
    <x-field name="specialty" label="Specialty" required />
    <x-field name="city" label="City, country" required />
    <x-field name="bio" label="Short bio" required />
<button class="px-4 py-2 bg-amber-500 text-black font-semibold rounded md:col-span-2">
    Add artist
</button>
</form>
@endsection
