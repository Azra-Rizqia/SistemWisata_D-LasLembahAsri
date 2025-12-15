@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
])

<div class="mb-3">
    <select name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'form-select']) }}>
        <option value="">-- Pilih kios --</option>

        @foreach ($options as $key => $value)
            <option value="{{ $key }}"
                {{ old($name, $selected) == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
