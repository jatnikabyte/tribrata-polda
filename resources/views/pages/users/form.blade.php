<?php

use App\Models\User;
use Livewire\Component;
use App\Livewire\Forms\UserForm;
use Livewire\Attributes\Title;

new #[Title('Formulir Pengguna')] class extends Component {
    public ?User $user = null;
    public UserForm $form;

    public string $entityName = 'Pengguna';

    public function mount($user = null): void
    {
        if ($user) {
            $this->form->user = $user;
            $this->form->name = $this->user->name;
            $this->form->email = $this->user->email;
            $this->form->phone = $this->user->phone ?? '';
            $this->form->role = $user->roles->first()?->name ?? '';
        }
    }

    public function save(): void
    {
        $validated = $this->form->validate();

        if ($this->user) {
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = bcrypt($validated['password']);
            }
            $this->user->update($validated);
            $this->user->syncRoles($validated['role']);
            session()->flash('success', "{$this->entityName} berhasil diperbarui.");
        } else {
            $validated['password'] = bcrypt($validated['password']);
            $user = User::create($validated);
            $user->assignRole($validated['role']);
            session()->flash('success', "{$this->entityName} berhasil dibuat.");
        }

        $this->redirectRoute('users', navigate: true);
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => $this->entityName, 'url' => route('users')], ['label' => $user ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah pengguna baru', 'is_last' => true]]" />

    {{-- Flash Messages --}}
    <x-feedback.flash-messages />

    {{-- Form Card --}}
    <form wire:submit="save">
        <x-card :title="$user ? 'Perbarui detail ' . Str::lower($entityName) : 'Tambah pengguna baru'">
            {{-- Name --}}
            <x-form.input name="form.name" wire:model="form.name" :required="true" label="Nama" placeholder="contoh: John Doe" />

            {{-- Email --}}
            <x-form.email name="form.email" wire:model="form.email" :required="true" label="Email" placeholder="contoh: john@example.com" />

            {{-- Phone --}}
            <x-form.input name="form.phone" wire:model="form.phone" label="Telepon" placeholder="contoh: 08123456789" />

            {{-- Password --}}
            <x-form.password name="form.password" wire:model="form.password" :required="!$user" label="Password" placeholder="{{ $user ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}" />

            {{-- Role --}}
            <x-form.select name="form.role" wire:model="form.role" label="Role" :required="true">
                <option value="admin" @selected(($form->role ?? '') === 'admin')>Admin</option>
            </x-form.select>

            @slot('footer')
                <x-button.form-cancel route="users" />
                <x-button.save :entityName="$entityName" :isEdit="$user !== null" />
            @endslot
        </x-card>
    </form>
</div>
