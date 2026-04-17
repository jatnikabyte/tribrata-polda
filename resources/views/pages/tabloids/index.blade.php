<?php

use App\Models\Tabloid;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Tabloid')] class extends Component {
    public string $entityName = 'Tabloid';

    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'title';

    #[Url]
    public string $sortDirection = 'asc';

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
        $tabloid = Tabloid::findOrFail($id);
        $tabloid->update(['is_active' => !$tabloid->is_active]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = decryptID($id);
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Tabloid::destroy($this->deleteId);
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
        $tabloids = Tabloid::query()
            ->with(['createdBy', 'updatedBy'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return $this->view(data: compact('tabloids'))->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('tabloids')], ['label' => 'Daftar ' . $this->entityName, 'is_last' => true]]">
        <x-slot:actions>
            <x-button.create route="tabloids.create" :entityName="$this->entityName" />
        </x-slot:actions>
    </x-page.header>
    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Table Card --}}
    <x-card>
        @slot('header')
            <h4 class="kt-card-title text-lg font-semibold text-default-800">Daftar {{ $this->entityName }}</h4>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari tabloid..." class="kt-input w-full sm:w-64">
            </div>
        @endslot

        {{-- Table --}}
        <x-table colspan="9" entityName="{{ $this->entityName }}">
            <x-slot:header>
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500 w-12">#</th>
                    <x-table.sort-button column="title" label="Judul" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Edisi ke</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Sampul</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">File</th>
                    <x-table.sort-button column="view_count" label="Dilihat" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Diperbarui</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Status</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Aksi</th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($tabloids as $tabloid)
                    <tr wire:key="tabloid-{{ encryptID($tabloid->id) }}" class="hover:bg-default-50 transition-colors odd:bg-white even:bg-default-100">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-500">{{ ($tabloids->currentPage() - 1) * $tabloids->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-default-800">{{ $tabloid->title }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-800">{{ $tabloid->edition_of }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($tabloid->cover)
                                <img src="{{ asset('storage/' . $tabloid->cover) }}" alt="Sampul" class="w-12 h-12 rounded-lg object-cover mx-auto">
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($tabloid->file_pdf)
                                <a href="{{ url($tabloid->file_pdf) }}" target="_blank" class="text-primary hover:text-primary/80">
                                    <i class="iconify lucide--file-text text-lg"></i>
                                </a>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-1 text-sm text-default-600">
                                <i class="iconify lucide--eye text-base"></i>
                                <span>{{ number_format($tabloid->view_count) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($tabloid->createdBy)
                                <span class="text-sm text-default-600">{{ $tabloid->createdBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($tabloid->updatedBy)
                                <span class="text-sm text-default-600">{{ $tabloid->updatedBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <x-form.toggle :on="$tabloid->is_active" color="success" wire:click="toggleActive('{{ encryptID($tabloid->id) }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <x-table.edit-button route="tabloids.edit" :params="['tabloid' => encryptID($tabloid->id)]" />
                                <x-table.delete-button id="{{ encryptID($tabloid->id) }}" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        @slot('footer')
            {{-- Pagination --}}
            @if ($tabloids->hasPages())
                {{ $tabloids->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
            @endif
        @endslot
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <x-delete-modal :show="$deleteId" title="Hapus {{ $this->entityName }}" message="Apakah Anda yakin ingin menghapus {{ $this->entityName }} ini? Tindakan ini tidak dapat dibatalkan." />
</div>
