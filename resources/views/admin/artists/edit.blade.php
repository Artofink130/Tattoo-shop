@extends('layouts.admin') 
@section('title','Edit artist') 
@section('content')
<a class="text-sm underline" href="{{ route('admin.artists.index') }}">
    ← Artists
</a>
<h1 class="text-2xl font-bold text-white my-3">
    Edit {{ $artist->name }}
</h1>
<form method="POST" action="{{ route('admin.artists.update',$artist) }}" class="grid md:grid-cols-2 gap-3 max-w-3xl">
    @csrf 
    @method('PUT')
<x-field name="name" label="Name" :value="$artist->name" required />
<x-field name="specialty" label="Specialty" :value="$artist->specialty" required />
<x-field name="city" label="City, country" :value="$artist->city" required />
<x-field name="bio" label="Short bio" :value="$artist->bio" required />
<button class="px-4 py-2 bg-amber-500 text-black font-semibold rounded md:col-span-2">
    Save
</button>
</form>
@endsection
