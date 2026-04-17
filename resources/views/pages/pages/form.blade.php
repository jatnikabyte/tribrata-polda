<?php

use App\Models\Page;
use Livewire\Component;
use App\Livewire\Forms\PageForm;
use Livewire\Attributes\Title;

new #[Title('Formulir Halaman')] class extends Component {
    public ?Page $page = null;
    public PageForm $form;

    public string $entityName = 'Halaman';

    public function mount($page = null): void
    {
        if ($page) {
            $this->form->page = $page;
            $this->form->title = $this->page->title;
            $this->form->slug = $this->page->slug;
            $this->form->content = $this->page->content ?? '';
            $this->form->is_active = $this->page->is_active;
        }
    }

    public function save(): void
    {
        try {
            $validated = $this->form->save();

            if ($this->page) {
                $this->page->update($validated);
                session()->flash('success', "{$this->entityName} berhasil diperbarui.");
            } else {
                Page::create($validated);
                session()->flash('success', "{$this->entityName} berhasil dibuat.");
            }
            $this->redirectRoute('pages', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('pages')], ['label' => $page ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah halaman web baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save" x-data="{ generateSlug: window.generateSlug }">
        <x-card :title="$page ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah halaman web baru'">
            {{-- Title --}}
            <x-form.input name="form.title" wire:model="form.title" :required="true" label="Judul" placeholder="contoh: Tentang Kami, Kontak" x-on:input="$el.value && $dispatch('slug-update', generateSlug($el.value))" />

            {{-- Slug --}}
            <x-form.input name="form.slug" wire:model="form.slug" :required="true" label="Slug" placeholder="contoh: tentang-kami, kontak" hint="Digunakan untuk URL: /pages/{slug}" x-on:slug-update.window="$wire.set('form.slug', $event.detail)" />

            {{-- Content --}}
            <x-form.richtext name="form.content" wire:model="form.content" :required="true" label="Konten" placeholder="Masukkan konten HTML" rows="10" />

            {{-- Divider --}}
            <div class="border-t border-border"></div>

            {{-- Active Toggle --}}
            <x-form.toggle-card :on="$form->is_active" label="Status Aktif" description="Aktifkan atau nonaktifkan halaman ini" color="success" wireAction="$toggle('form.is_active')" />

            @slot('footer')
                <x-button.form-cancel route="pages" />
                <x-button.save :entityName="$entityName" :isEdit="$page !== null" />
            @endslot
        </x-card>
    </form>
</div>
