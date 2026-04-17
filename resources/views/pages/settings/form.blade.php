<?php

use App\Models\Setting;
use Livewire\Component;
use App\Livewire\Forms\SettingForm;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

new #[Title('Formulir Pengaturan')] class extends Component {
    use WithFileUploads;

    public ?Setting $setting = null;
    public SettingForm $form;

    public string $entityName = 'Pengaturan';

    public function mount($setting = null): void
    {
        if ($setting) {
            $this->form->setting = $setting;
            $this->form->keyword = $this->setting->keyword;
            $this->form->value = $this->setting->value ?? '';
            $this->form->type = $this->setting->type ?? 'text';
            $this->form->description = $this->setting->description ?? '';
        }
    }

    public function save(): void
    {
        $validated = $this->form->save();

        if ($this->setting) {
            $this->setting->update($validated);
            session()->flash('success', "{$this->entityName} berhasil diperbarui.");
        } else {
            Setting::create($validated);
            session()->flash('success', "{$this->entityName} berhasil dibuat.");
        }

        $this->redirectRoute('settings', navigate: true);
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('settings')], ['label' => $setting ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah pengaturan baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save">
        <x-card :title="$setting ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah pengaturan baru'">
            {{-- Key --}}
            <x-form.input name="form.keyword" wire:model="form.keyword" :required="true" label="Keyword" placeholder="contoh: site_name, contact_email" hint="Identifier unik untuk pengaturan ini" />

            {{-- Type --}}
            <x-form.select name="form.type" wire:model.live="form.type" label="Tipe" :required="true">
                <option value="text" @selected(($form->type ?? 'text') === 'text')>Text</option>
                <option value="textarea" @selected(($form->type ?? '') === 'textarea')>Textarea</option>
                <option value="texteditor" @selected(($form->type ?? '') === 'texteditor')>Rich Text Editor</option>
                <option value="img" @selected(($form->type ?? '') === 'img')>Image</option>
            </x-form.select>

            {{-- Dynamic Value Field based on Type --}}
            @if ($form->type === 'textarea')
                <x-form.textarea name="form.value" wire:model="form.value" label="Value" placeholder="Masukkan value" rows="4" />
            @elseif ($form->type === 'texteditor')
                <x-form.richtext name="form.value" wire:model="form.value" label="Value" placeholder="Masukkan konten" />
            @elseif ($form->type === 'img')
                <x-form.image name="form.imageUpload" wire:model="form.imageUpload" label="Value (Gambar)" hint="Upload gambar (maks. 2MB)" :currentImage="$setting?->value ? asset('storage/settings/' . $setting->value) : null" />
            @else
                <x-form.input name="form.value" wire:model="form.value" label="Value" placeholder="Masukkan value" />
            @endif

            {{-- Description --}}
            <x-form.textarea name="form.description" wire:model="form.description" label="Deskripsi" placeholder="Deskripsi pengaturan ini" rows="3" />

            @slot('footer')
                <x-button.form-cancel route="settings" />
                <x-button.save :entityName="$entityName" :isEdit="$setting !== null" />
            @endslot
        </x-card>
    </form>
</div>
