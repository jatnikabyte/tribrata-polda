@props([
    'label' => 'Delete',
    'size' => 'md',
    'loading' => false,
    'loadingTarget' => null,
    'icon' => null,
    'confirm' => 'Are you sure you want to delete this item?',
])

@php
    $sizes = [
        'xs' => 'kt-btn-xs',
        'sm' => 'kt-btn-sm',
        'md' => '',
        'lg' => 'kt-btn-lg',
    ];
    $sizeClass = $sizes[$size] ?? '';
@endphp

<button type="submit" {{ $attributes->merge(['class' => "kt-btn kt-btn-danger $sizeClass"]) }} onclick="return confirm('{{ $confirm }}')">
    @if ($loadingTarget)
        <span class="kt-spinner kt-spinner-white kt-spinner-sm" wire:loading wire:target="{{ $loadingTarget }}"></span>
    @elseif ($loading)
        <span class="kt-spinner kt-spinner-white kt-spinner-sm"></span>
    @endif

    <span @if ($loadingTarget) wire:loading.remove wire:target="{{ $loadingTarget }}" @elseif ($loading) class="hidden" @endif>
        @if ($icon)
            <span class="mr-2">{{ $icon }}</span>
        @endif
        {{ $label }}
    </span>
</button>
