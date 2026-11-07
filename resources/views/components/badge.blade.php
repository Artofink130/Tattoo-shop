@props(['status'])
<span class="px-2 py-0.5 rounded text-xs {{ $status->color() }}">{{ $status->label() }}</span>
