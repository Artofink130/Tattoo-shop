@props(['name', 'label', 'options', 'value' => null, 'blank' => null])
<label class="block text-sm">
    <span class="text-neutral-400">{{ $label }}</span>
        <select name="{{ $name }}" {{ $attributes->merge(['class' => 'mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2']) }}>
            @if($blank !== null)
               <option value="">{{ $blank }}</option>
            @endif
        @foreach($options as $k => $text)
            <option value="{{ $k }}" @selected((string) old($name, $value) === (string) $k)>{{ $text }}</option>
        @endforeach
        </select>
</label>
