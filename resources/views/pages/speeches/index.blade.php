<?php

use App\Models\Speech;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Pidato')] class extends Component {
    public string $entityName = 'Pidato';

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
        $speech = Speech::findOrFail($id);
        $speech->update(['is_active' => !$speech->is_active]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = decryptID($id);
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Speech::destroy($this->deleteId);
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
        $speeches = Speech::query()
            ->with(['createdBy', 'updatedBy'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return $this->view(data: compact('speeches'))->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('speeches')], ['label' => 'Daftar ' . $this->entityName, 'is_last' => true]]">
        <x-slot:actions>
            <x-button.create route="speeches.create" :entityName="$this->entityName" />
        </x-slot:actions>
    </x-page.header>
    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Table Card --}}
    <x-card>
        @slot('header')
            <h4 class="kt-card-title text-lg font-semibold text-default-800">Daftar {{ $this->entityName }}</h4>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pidato..." class="kt-input w-full sm:w-64">
            </div>
        @endslot

        {{-- Table --}}
        <x-table colspan="10" entityName="{{ $this->entityName }}">
            <x-slot:header>
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500 w-12">#</th>
                    <x-table.sort-button column="title" label="Judul" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Nama</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Foto</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Diperbarui</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Status</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Aksi</th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($speeches as $speech)
                    <tr wire:key="speech-{{ encryptID($speech->id) }}" class="hover:bg-default-50 transition-colors odd:bg-white even:bg-default-100">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-500">{{ ($speeches->currentPage() - 1) * $speeches->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-default-800">{{ $speech->title }}</span>
                                @if ($speech->subtitle)
                                    <span class="text-xs text-default-500">{{ $speech->subtitle }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-default-800">{{ $speech->name }}</span>
                                @if ($speech->jobtitle)
                                    <span class="text-xs text-default-500">{{ $speech->jobtitle }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($speech->foto)
                                <img src="{{ asset('storage/' . $speech->foto) }}" alt="Foto" class="w-12 h-12 rounded-lg object-cover mx-auto">
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-default-600 line-clamp-2">{{ Str::limit(strip_tags($speech->description), 60) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($speech->createdBy)
                                <span class="text-sm text-default-600">{{ $speech->createdBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($speech->updatedBy)
                                <span class="text-sm text-default-600">{{ $speech->updatedBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <x-form.toggle :on="$speech->is_active" color="success" wire:click="toggleActive('{{ encryptID($speech->id) }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <x-table.edit-button route="speeches.edit" :params="['speech' => encryptID($speech->id)]" />
                                <x-table.delete-button id="{{ encryptID($speech->id) }}" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        @slot('footer')
            {{-- Pagination --}}
            @if ($speeches->hasPages())
                {{ $speeches->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
            @endif
        @endslot
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <x-delete-modal :show="$deleteId" title="Hapus {{ $this->entityName }}" message="Apakah Anda yakin ingin menghapus {{ $this->entityName }} ini? Tindakan ini tidak dapat dibatalkan." />
</div>
