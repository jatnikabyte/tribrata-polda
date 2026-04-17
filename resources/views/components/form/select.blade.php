@props(['name', 'label' => null, 'placeholder' => 'Select an option', 'options' => [], 'hint' => null, 'icon' => null, 'required' => false])

@php
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}>
    @if ($label)
        <label class="block text-sm font-medium text-default-700 mb-1.5" for="{{ $name }}">
            {{ $label }} {!! !!$required ? '<span class="text-red-500">*</span>' : '' !!}
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <span class="text-default-400">{{ $icon }}</span>
            </div>
        @endif
        <select id="{{ $name }}" name="{{ $name }}" class="kt-select @if ($icon) ps-10 @endif @error($name) kt-select-error @enderror" {{ $attributes->except('class') }} {{ $required ? 'required' : '' }}>
            @if ($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @if (count($options) > 0)
                @foreach ($options as $value => $text)
                    <option value="{{ $value }}" @if (old($name) == $value) selected @endif>
                        {{ $text }}
                    </option>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </select>
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
