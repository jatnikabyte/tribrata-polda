@props([
    'id' => null,
    'title' => 'Hapus',
])

<button type="button" wire:click="confirmDelete('{{ $id }}')" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-destructive" title="{{ $title }}">
    <i class="iconify lucide--trash-2 text-lg"></i>
</button>
