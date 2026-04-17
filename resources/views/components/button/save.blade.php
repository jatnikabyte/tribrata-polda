@props([
    'label' => 'Simpan',
    'entityName' => null,
    'isEdit' => false,
    'icon' => 'lucide--check',
])

<button type="submit" class="kt-btn kt-btn-primary">
    <i class="iconify {{ $icon }} text-lg"></i>
    {{ $isEdit ? 'Perbarui' : 'Buat' }} {{ $entityName }}
</button>
