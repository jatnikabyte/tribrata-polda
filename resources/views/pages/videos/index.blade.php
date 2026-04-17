<?php

use App\Models\Video;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Video')] class extends Component {
    public string $entityName = 'Video';

    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'id';

    #[Url]
    public string $sortDirection = 'desc';

    public $deleteId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleActive($id): void
    {
        $id = decryptID($id);
        $video = Video::findOrFail($id);
        $video->update(['is_active' => !$video->is_active]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = decryptID($id);
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Video::destroy($this->deleteId);
            $this->deleteId = null;
            session()->flash('success', "{$this->entityName} berhasil dihapus.");
        }
    }

    public function cancelDelete(): void
    {
        $this->deleteId = null;
    }

    public function render()
    {
        $videos = Video::query()
            ->with(['createdBy', 'updatedBy'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
        return $this->view(data: compact('videos'))->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('videos')], ['label' => 'Daftar ' . $this->entityName, 'is_last' => true]]">
        <x-slot:actions>
            <x-button.create route="videos.create" :entityName="$this->entityName" />
        </x-slot:actions>
    </x-page.header>
    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Table Card --}}
    <x-card>
        @slot('header')
            <h4 class="kt-card-title text-lg font-semibold text-default-800">Daftar {{ $this->entityName }}</h4>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari video..." class="kt-input w-full sm:w-64">
            </div>
        @endslot

        {{-- Table --}}
        <x-table colspan="8" entityName="{{ $this->entityName }}">
            <x-slot:header>
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500 w-12">#</th>
                    <x-table.sort-button column="title" label="Title" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <x-table.sort-button column="badge" label="Badge" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Sampul</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Tautan</th>
                    <x-table.sort-button column="view_count" label="Dilihat" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Diperbarui</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Status</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Aksi</th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($videos as $video)
                    <tr wire:key="video-{{ encryptID($video->id) }}" class="hover:bg-default-50 transition-colors odd:bg-white even:bg-default-100">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-500">{{ ($videos->currentPage() - 1) * $videos->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-default-800">{{ \Str::limit($video->title,20) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $video->badge }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($video->cover)
                                <img src="{{ asset('storage/' . $video->cover) }}" alt="Sampul" class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <span class="text-sm text-default-400">Tidak ada sampul</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ $video->video_link }}" target="_blank" class="text-primary hover:text-primary/80">
                                <i class="iconify lucide--play-circle text-lg"></i>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-1 text-sm text-default-600">
                                <i class="iconify lucide--eye text-base"></i>
                                <span>{{ number_format($video->view_count) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($video->createdBy)
                                <span class="text-sm text-default-600">{{ $video->createdBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($video->updatedBy)
                                <span class="text-sm text-default-600">{{ $video->updatedBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <x-form.toggle :on="$video->is_active" color="success" wire:click="toggleActive('{{ encryptID($video->id) }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <x-table.edit-button route="videos.edit" :params="['video' => encryptID($video->id)]" />
                                <x-table.delete-button id="{{ encryptID($video->id) }}" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        @slot('footer')
            {{-- Pagination --}}
            @if ($videos->hasPages())
                {{ $videos->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
            @endif
        @endslot
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <x-delete-modal :show="$deleteId" title="Hapus {{ $this->entityName }}" message="Apakah Anda yakin ingin menghapus {{ $this->entityName }} ini? Tindakan ini tidak dapat dibatalkan." />
</div>
