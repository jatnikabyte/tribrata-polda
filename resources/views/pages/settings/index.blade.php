<?php

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Pengaturan')] class extends Component {
    public string $entityName = 'Pengaturan';

    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'keyword';

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

    public function confirmDelete($id): void
    {
        $this->deleteId = decryptID($id);
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            Setting::destroy($this->deleteId);
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
        $settings = Setting::query()->when($this->search, fn($q) => $q->where('keyword', 'like', "%{$this->search}%")->orWhere('value', 'like', "%{$this->search}%"))->orderBy($this->sortBy, $this->sortDirection)->paginate(10);

        return $this->view(data: compact('settings'))->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('settings')], ['label' => 'Daftar ' . $this->entityName, 'is_last' => true]]">
        <x-slot:actions>
            <x-button.create route="settings.create" :entityName="$this->entityName" />
        </x-slot:actions>
    </x-page.header>
    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Table Card --}}
    <x-card>
        @slot('header')
            <h4 class="kt-card-title text-lg font-semibold text-default-800">Daftar {{ $this->entityName }}</h4>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pengaturan..." class="kt-input w-full sm:w-64">
            </div>
        @endslot

        {{-- Table --}}
        <x-table colspan="6" entityName="{{ $this->entityName }}">
            <x-slot:header>
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500 w-12">#</th>
                    <x-table.sort-button column="keyword" label="Keyword" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-start text-sm font-medium text-default-500">Value</th>
                    <x-table.sort-button column="type" label="Tipe" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Aksi</th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($settings as $setting)
                    <tr wire:key="setting-{{ encryptID($setting->id) }}" class="hover:bg-default-50 transition-colors odd:bg-white even:bg-default-100">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-500">{{ ($settings->currentPage() - 1) * $settings->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-default-800">{{ $setting->keyword }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($setting->type === 'image')
                                <img src="{{ asset('storage/' . $setting->value) }}" alt="Gambar" class="w-12 h-12 rounded-lg object-cover">
                            @elseif ($setting->type === 'color')
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full border border-border" style="background-color: {{ $setting->value }}"></div>
                                    <span class="text-sm font-mono text-default-600">{{ $setting->value }}</span>
                                </div>
                            @else
                                <span class="text-sm text-default-600 line-clamp-2">{{ Str::limit($setting->value, 80) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-default-100 text-default-700">
                                {{ $setting->type ?? 'text' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-default-600 line-clamp-2">{{ $setting->description ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                @if ($setting->is_dev != 1)
                                    <x-table.edit-button route="settings.edit" :params="['setting' => encryptID($setting->id)]" />
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        @slot('footer')
            {{-- Pagination --}}
            @if ($settings->hasPages())
                {{ $settings->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
            @endif
        @endslot
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <x-delete-modal :show="$deleteId" title="Hapus {{ $this->entityName }}" message="Apakah Anda yakin ingin menghapus {{ $this->entityName }} ini? Tindakan ini tidak dapat dibatalkan." />
</div>
