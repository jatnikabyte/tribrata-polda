<?php

use App\Models\Headline;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Headline')] class extends Component {
    public string $entityName = 'Headline';

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
        $headline = Headline::findOrFail($id);
        $headline->update(['is_active' => !$headline->is_active]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = decryptID($id);
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Headline::destroy($this->deleteId);
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
        $headlines = Headline::query()
            ->with(['createdBy', 'updatedBy'])
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return $this->view(data: compact('headlines'))->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('headlines')], ['label' => 'Daftar ' . $this->entityName, 'is_last' => true]]">
        <x-slot:actions>
            <x-button.create route="headlines.create" :entityName="$this->entityName" />
        </x-slot:actions>
    </x-page.header>
    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Table Card --}}
    <x-card>
        @slot('header')
            <h4 class="kt-card-title text-lg font-semibold text-default-800">Daftar {{ $this->entityName }}</h4>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari headline..." class="kt-input w-full sm:w-64">
            </div>
        @endslot

        {{-- Table --}}
        <x-table colspan="8" entityName="{{ $this->entityName }}">
            <x-slot:header>
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500 w-12">#</th>
                    <x-table.sort-button column="title" label="Judul" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Badge</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Link</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Diperbarui</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Status</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Aksi</th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($headlines as $headline)
                    <tr wire:key="headline-{{ encryptID($headline->id) }}" class="hover:bg-default-50 transition-colors odd:bg-white even:bg-default-100">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-500">{{ ($headlines->currentPage() - 1) * $headlines->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-default-800">{{ \Str::limit($headline->title,50) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($headline->badge)
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium text-white" style="background-color: {{ $headline->badge_color }}">
                                    {{ $headline->badge }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($headline->link)
                                <a href="{{ $headline->link }}" target="_blank" class="text-primary hover:text-primary/80">
                                    <i class="iconify lucide--external-link text-lg"></i>
                                </a>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($headline->createdBy)
                                <span class="text-sm text-default-600">{{ $headline->createdBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($headline->updatedBy)
                                <span class="text-sm text-default-600">{{ $headline->updatedBy->name ?? 'Tidak diketahui' }}</span>
                            @else
                                <span class="text-sm text-default-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <x-form.toggle :on="$headline->is_active" color="success" wire:click="toggleActive('{{ encryptID($headline->id) }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <x-table.edit-button route="headlines.edit" :params="['headline' => encryptID($headline->id)]" />
                                <x-table.delete-button id="{{ encryptID($headline->id) }}" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        @slot('footer')
            {{-- Pagination --}}
            @if ($headlines->hasPages())
                {{ $headlines->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
            @endif
        @endslot
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <x-delete-modal :show="$deleteId" title="Hapus {{ $this->entityName }}" message="Apakah Anda yakin ingin menghapus {{ $this->entityName }} ini? Tindakan ini tidak dapat dibatalkan." />
</div>
