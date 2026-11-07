@extends('layouts.admin') 
@section('title','Requests') 
@section('content')
<h1 class="text-2xl font-bold text-white mb-4">
    Requests
</h1>
<form class="flex flex-wrap gap-2 mb-4 text-sm">
    <input name="q" value="{{ request('q') }}" placeholder="Search name or email" class="bg-neutral-900 border border-neutral-700 rounded p-2">
<select name="status" class="bg-neutral-900 border border-neutral-700 rounded p-2">
    <option value="">
        All statuses

    </option>
    @foreach($statuses as $s)
    <option value="{{ $s->value }}" @selected(request('status')===$s->value)>
        {{ $s->label() }}

    </option>
    @endforeach
</select>
<button class="px-3 bg-neutral-800 rounded">
    Filter
</button>
</form>
<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="text-left text-neutral-500">
            <tr>
                <th class="py-2">Date</th>
                <th>Client</th>
                <th>Style</th>
                <th>Artist</th>
                <th>Price</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
@forelse($quotes as $q)
<tr class="border-t border-neutral-800">
    <td class="py-2">{{ $q->created_at->format('d M Y') }}</td>
    <td>{{ $q->name }}{{ $q->consultation ? ' (consult)' : '' }}
        <div class="text-xs text-neutral-500">
            {{ $q->email }}

        </div>
    </td>
<td>{{ $q->style }}</td>
<td>{{ $q->artist?->name ?? '—' }}</td>
<td>{{ $q->price ? '$'.number_format($q->price,0) : '—' }}</td>
<td>
    <x-badge :status="$q->status" />
</td>
<td>
    <a class="underline" href="{{ route('admin.quotes.show',$q) }}">
        Open
    </a>
</td>
</tr>
@empty
<tr>
    <td colspan="7" class="py-6 text-neutral-500">No requests found.</td>
</tr
>@endforelse
</tbody>
</table>
</div>
<div class="mt-4">{{ $quotes->links() }}</div>
@endsection
