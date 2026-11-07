@if(session('ok'))<div class="mb-6 p-3 rounded bg-emerald-900/50 border border-emerald-700 text-sm">{{ session('ok') }}</div>@endif
@if($errors->any())<div class="mb-6 p-3 rounded bg-red-900/50 border border-red-700 text-sm">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
