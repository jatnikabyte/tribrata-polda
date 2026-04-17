@props([
    'show' => false,
    'title' => 'Hapus Data',
    'message' => 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
    'confirmAction' => 'delete',
    'cancelAction' => 'cancelDelete',
    'confirmText' => 'Hapus',
    'cancelText' => 'Batal',
])

@if ($show)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" wire:click="{{ $cancelAction }}">
        <div class="bg-card rounded-xl shadow-xl max-w-md w-full p-6 border border-border" wire:click.stop>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <i class="iconify lucide--alert-triangle text-2xl text-red-500"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-lg text-default-800">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-default-600">{{ $message }}</p>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" wire:click="{{ $cancelAction }}" class="kt-btn">{{ $cancelText }}</button>
                <button type="button" wire:click="{{ $confirmAction }}" class="kt-btn kt-btn-danger">{{ $confirmText }}</button>
            </div>
        </div>
    </div>
@endif
