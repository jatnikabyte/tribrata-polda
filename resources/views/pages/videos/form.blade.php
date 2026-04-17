<?php

use App\Models\Video;
use Livewire\Component;
use App\Livewire\Forms\VideoForm;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

new #[Title('Formulir Video')] class extends Component {
    use WithFileUploads;

    public ?Video $video = null;
    public VideoForm $form;

    public string $entityName = 'Video';

    public function mount($video = null): void
    {
        if ($video) {
            $this->form->video = $video;
            $this->form->title = $this->video->title;
            $this->form->slug = $this->video->slug;
            $this->form->badge = $this->video->badge ?? '';
            $this->form->badge_color = $this->video->badge_color ?? '';
            $this->form->video_link = $this->video->video_link;
            $this->form->description = $this->video->description ?? '';
            $this->form->is_active = $this->video->is_active;
        }
    }

    public function save(): void
    {
        $validated = $this->form->save();
        if ($this->video) {
            $this->video->update($validated);
            session()->flash('success', "{$this->entityName} berhasil diperbarui.");
        } else {
            Video::create($validated);
            session()->flash('success', "{$this->entityName} berhasil dibuat.");
        }

        $this->redirectRoute('videos', navigate: true);
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('videos')], ['label' => $video ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah video baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save" x-data="{ generateSlug: window.generateSlug }">
        <x-card :title="$video ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah video baru'">
            {{-- Title --}}
            <x-form.input name="form.title" wire:model="form.title" :required="true" label="Judul" placeholder="contoh: Video Pengenalan" x-on:input="$el.value && $dispatch('slug-update', generateSlug($el.value))" />

            {{-- Slug --}}
            <x-form.input name="form.slug" wire:model="form.slug" :required="true" label="Slug" placeholder="contoh: video-pengenalan" hint="Digunakan untuk URL: /videos/{slug}" x-on:slug-update.window="$wire.set('form.slug', $event.detail)" />

            {{-- Badge --}}
            <x-form.input name="form.badge" wire:model="form.badge" :required="true" label="Badge" placeholder="contoh: Baru, Unggulan" />

            {{-- Badge Color --}}
            <x-form.color-picker name="form.badge_color" wire:model="form.badge_color" :required="true" label="Warna Badge" placeholder="contoh: #3b82f6" />

            {{-- Video Link --}}
            <x-form.url name="form.video_link" wire:model="form.video_link" :required="true" label="Tautan Video" placeholder="contoh: https://youtube.com/watch?v=..." />

            {{-- Cover Image --}}
            <x-form.image name="form.cover" wire:model="form.cover" :required="!$video" label="Gambar Sampul" hint="Upload gambar sampul tabloid (maks. 2MB)" :currentImage="$video && $video->cover ? asset('storage/' . $video->cover) : null" />

            {{-- Description --}}
            <x-form.richtext name="form.description" wire:model="form.description" :required="true" label="Deskripsi" placeholder="Masukkan deskripsi video..." rows="4" />

            {{-- Divider --}}
            <div class="border-t border-border"></div>

            {{-- Active Toggle --}}
            <x-form.toggle-card :on="$form->is_active" label="Status Aktif" description="Aktifkan atau nonaktifkan video ini" color="success" wireAction="$toggle('form.is_active')" />

            @slot('footer')
                <x-button.form-cancel route="videos" />
                <x-button.save :entityName="$entityName" :isEdit="$video !== null" />
            @endslot
        </x-card>
    </form>
</div>
