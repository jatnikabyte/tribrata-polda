<?php

use App\Models\Tabloid;
use Livewire\Component;
use App\Livewire\Forms\TabloidForm;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

new #[Title('Formulir Tabloid')] class extends Component {
    use WithFileUploads;

    public ?Tabloid $tabloid = null;
    public TabloidForm $form;

    public string $entityName = 'Tabloid';

    public function mount($tabloid = null): void
    {
        if ($tabloid) {
            $this->form->tabloid = $tabloid;
            $this->form->title = $this->tabloid->title;
            $this->form->file_pdf = $this->tabloid->file_pdf;
            $this->form->description = $this->tabloid->description ?? '';
            $this->form->is_active = $this->tabloid->is_active;
        }
    }

    public function save(): void
    {
        $validated = $this->form->save();
        if ($this->tabloid) {
            $this->tabloid->update($validated);
            session()->flash('success', "{$this->entityName} berhasil diperbarui.");
        } else {
            Tabloid::create($validated);
            session()->flash('success', "{$this->entityName} berhasil dibuat.");
        }

        $this->redirectRoute('tabloids', navigate: true);
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('tabloids')], ['label' => $tabloid ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah tabloid baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save">
        <x-card :title="$tabloid ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah tabloid baru'">
            {{-- Title --}}
            <x-form.input name="form.title" wire:model="form.title" :required="true" label="Judul" placeholder="Judul Tabloid" />

            {{-- Edition of --}}
            <x-form.input type="number" name="form.edition_of" wire:model="form.edition_of" :required="true" label="Edisi ke-" placeholder="Isi dengan angka" />

            {{-- Cover --}}
            <x-form.image name="form.cover" wire:model="form.cover" :required="!$tabloid" label="Sampul" hint="Upload gambar sampul tabloid (maks. 2MB)" :currentImage="$tabloid?->cover ? asset('storage/' . $tabloid->cover) : null" />

            {{-- File --}}
            <x-form.filemanager-picker name="form.file_pdf" wire:model="form.file_pdf" label="File Tabloid (PDF)" :currentImage="$tabloid?->file_pdf ? url($tabloid->file_pdf) : null" />

            {{-- Divider --}}
            <div class="border-t border-border"></div>

            {{-- Active Toggle --}}
            <x-form.toggle-card :on="$form->is_active" label="Status Aktif" description="Aktifkan atau nonaktifkan tabloid ini" color="success" wireAction="$toggle('form.is_active')" />

            @slot('footer')
                <x-button.form-cancel route="tabloids" />
                <x-button.save :entityName="$entityName" :isEdit="$tabloid !== null" />
            @endslot
        </x-card>
    </form>
</div>
