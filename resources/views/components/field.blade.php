@props(['name', 'label', 'type' => 'text', 'value' => null])
<label class="block text-sm"><span class="text-neutral-400">{{ $label }}</span>
<input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" {{ $attributes->merge(['class' => 'mt-1 w-full bg-neutral-900 border border-neutral-700 rounded p-2 focus:border-amber-500 outline-none']) }}>
@error($name)<span class="text-red-400 text-xs">{{ $message }}</span>@enderror</label>
