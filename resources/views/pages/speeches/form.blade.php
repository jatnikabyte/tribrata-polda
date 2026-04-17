<?php

use App\Models\Speech;
use Livewire\Component;
use App\Livewire\Forms\SpeechForm;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

new #[Title('Formulir Pidato')] class extends Component {
    use WithFileUploads;

    public ?Speech $speech = null;
    public SpeechForm $form;

    public string $entityName = 'Pidato';

    public function mount($speech = null): void
    {
        if ($speech) {
            $this->form->speech = $speech;
            $this->form->badge = $this->speech->badge ?? '';
            $this->form->title = $this->speech->title;
            $this->form->subtitle = $this->speech->subtitle ?? '';
            $this->form->description = $this->speech->description ?? '';
            $this->form->name = $this->speech->name ?? '';
            $this->form->jobtitle = $this->speech->jobtitle ?? '';
            $this->form->is_active = $this->speech->is_active;
        }
    }

    public function save(): void
    {
        $validated = $this->form->save();

        if ($this->speech) {
            $this->speech->update($validated);
            session()->flash('success', "{$this->entityName} berhasil diperbarui.");
        } else {
            Speech::create($validated);
            session()->flash('success', "{$this->entityName} berhasil dibuat.");
        }

        $this->redirectRoute('speeches', navigate: true);
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('speeches')], ['label' => $speech ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah pidato baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save">
        <x-card :title="$speech ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah pidato baru'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Badge --}}
                <x-form.input name="form.badge" wire:model="form.badge" label="Badge" placeholder="contoh: Sambutan" />
                
                {{-- Title --}}
                <x-form.input name="form.title" wire:model="form.title" :required="true" label="Judul" placeholder="contoh: Sambutan Kapolda" />
            </div>

            {{-- Subtitle --}}
            <x-form.input name="form.subtitle" wire:model="form.subtitle" label="Sub Judul" placeholder="Sub judul pidato" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Name --}}
                <x-form.input name="form.name" wire:model="form.name" :required="true" label="Nama Pengucap" placeholder="Nama Pejabat" />
                
                {{-- Job Title --}}
                <x-form.input name="form.jobtitle" wire:model="form.jobtitle" label="Jabatan" placeholder="contoh: Kapolda Metro Jaya" />
            </div>

            {{-- Foto --}}
            <x-form.image name="form.foto" wire:model="form.foto" label="Foto" hint="Upload foto (maks. 2MB)" :currentImage="$speech?->foto ? asset('storage/' . $speech->foto) : null" />

            {{-- Description --}}
            <x-form.textarea name="form.description" wire:model="form.description" label="Deskripsi/Isi Pidato" placeholder="Masukkan isi pidato" rows="6" />

            {{-- Divider --}}
            <div class="border-t border-border"></div>

            {{-- Active Toggle --}}
            <x-form.toggle-card :on="$form->is_active" label="Status Aktif" description="Aktifkan atau nonaktifkan pidato ini" color="success" wireAction="$toggle('form.is_active')" />

            @slot('footer')
                <x-button.form-cancel route="speeches" />
                <x-button.save :entityName="$entityName" :isEdit="$speech !== null" />
            @endslot
        </x-card>
    </form>
</div>
