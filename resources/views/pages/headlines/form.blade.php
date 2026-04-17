<?php

use App\Models\Headline;
use Livewire\Component;
use App\Livewire\Forms\HeadlineForm;
use Livewire\Attributes\Title;

new #[Title('Formulir Headline')] class extends Component {
    public ?Headline $headline = null;
    public HeadlineForm $form;

    public string $entityName = 'Headline';

    public function mount($headline = null): void
    {
        if ($headline) {
            $this->form->headline = $headline;
            $this->form->title = $this->headline->title;
            $this->form->badge = $this->headline->badge ?? '';
            $this->form->badge_color = $this->headline->badge_color ?? '';
            $this->form->link = $this->headline->link;
            $this->form->is_active = $this->headline->is_active;
        }
    }

    public function save(): void
    {
        $validated = $this->form->validate();

        if ($this->headline) {
            $this->headline->update($validated);
            session()->flash('success', "{$this->entityName} berhasil diperbarui.");
        } else {
            Headline::create($validated);
            session()->flash('success', "{$this->entityName} berhasil dibuat.");
        }

        $this->redirectRoute('headlines', navigate: true);
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('headlines')], ['label' => $headline ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah headline baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save">
        <x-card :title="$headline ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah headline baru'">
            {{-- Title --}}
            <x-form.input name="form.title" wire:model="form.title" :required="true" label="Judul" placeholder="contoh: Headline Pengenalan" />

            {{-- Badge --}}
            <x-form.input name="form.badge" wire:model="form.badge" :required="true" label="Badge" placeholder="contoh: Baru, Unggulan" />

            {{-- Badge Color --}}
            <x-form.color-picker name="form.badge_color" wire:model="form.badge_color" :required="true" label="Warna Badge" placeholder="contoh: #3b82f6" />

            {{-- Link --}}
            <x-form.url name="form.link" wire:model="form.link" :required="true" label="Link" placeholder="contoh: https://..." />

            {{-- Divider --}}
            <div class="border-t border-border"></div>

            {{-- Active Toggle --}}
            <x-form.toggle-card :on="$form->is_active" label="Status Aktif" description="Aktifkan atau nonaktifkan headline ini" color="success" wireAction="$toggle('form.is_active')" />

            @slot('footer')
                <x-button.form-cancel route="headlines" />
                <x-button.save :entityName="$entityName" :isEdit="$headline !== null" />
            @endslot
        </x-card>
    </form>
</div>
