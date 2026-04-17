<?php

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Pengguna')] class extends Component {
    public string $entityName = 'Pengguna';

    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'name';

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
            User::destroy($this->deleteId);
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
        $users = User::query()->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%"))->orderBy($this->sortBy, $this->sortDirection)->paginate(10);

        return $this->view(data: compact('users'))->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('users')], ['label' => 'Daftar ' . $this->entityName, 'is_last' => true]]">
        <x-slot:actions>
            <x-button.create route="users.create" :entityName="$this->entityName" />
        </x-slot:actions>
    </x-page.header>
    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    {{-- Table Card --}}
    <x-card>
        @slot('header')
            <h4 class="kt-card-title text-lg font-semibold text-default-800">Daftar {{ $this->entityName }}</h4>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pengguna..." class="kt-input w-full sm:w-64">
            </div>
        @endslot

        {{-- Table --}}
        <x-table colspan="6" entityName="{{ $this->entityName }}">
            <x-slot:header>
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500 w-12">#</th>
                    <x-table.sort-button column="name" label="Nama" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <x-table.sort-button column="email" label="Email" :sortBy="$sortBy" :sortDirection="$sortDirection" />
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Telepon</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Role</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-default-500">Aksi</th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($users as $user)
                    <tr wire:key="user-{{ encryptID($user->id) }}" class="hover:bg-default-50 transition-colors odd:bg-white even:bg-default-100">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-medium text-default-500">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center">
                                    <span class="text-sm font-medium text-primary">{{ Str::substr($user->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium text-default-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-default-600">{{ $user->email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm text-default-600">{{ $user->phone ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                {{ $user->roleName ?? 'User' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <x-table.edit-button route="users.edit" :params="['user' => encryptID($user->id)]" />
                                <x-table.delete-button id="{{ encryptID($user->id) }}" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        @slot('footer')
            {{-- Pagination --}}
            @if ($users->hasPages())
                {{ $users->links(data: ['scrollTo' => false], view: 'pagination::tailwind') }}
            @endif
        @endslot
    </x-card>

    {{-- Delete Confirmation Modal --}}
    <x-delete-modal :show="$deleteId" title="Hapus {{ $this->entityName }}" message="Apakah Anda yakin ingin menghapus {{ $this->entityName }} ini? Tindakan ini tidak dapat dibatalkan." />
</div>
