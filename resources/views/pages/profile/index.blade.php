<?php

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\ProfileForm;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

new #[Title('Profile')] class extends Component {
    use WithFileUploads;

    public User $user;
    public ProfileForm $form;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->form->name = $this->user->name;
        $this->form->email = $this->user->email;
        $this->form->username = $this->user->username ?? '';
        $this->form->phone = $this->user->phone ?? '';
        $this->form->password = '';
    }

    public function save(): void
    {
        $data = $this->form->save();

        // Handle avatar upload
        if ($this->form->avatar) {
            $path = $this->form->avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $this->user->update($data);
        session()->flash('success', 'Profile berhasil diperbarui.');
    }

    public function deleteAvatar(): void
    {
        if ($this->user->avatar) {
            Storage::disk('public')->delete($this->user->avatar);
            $this->user->update(['avatar' => null]);
            session()->flash('success', 'Avatar berhasil dihapus.');
        }
    }

    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
}; ?>

<div>
    {{-- Page Header --}}
    <x-page.header :breadcrumbs="[['label' => 'Profile', 'url' => route('profile')], ['label' => 'Kelola Profil', 'is_last' => true]]" />

    {{-- Flash Message --}}
    <x-feedback.flash-messages />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Avatar Section --}}
        <div class="lg:col-span-1">
            <x-card title="Foto Profil">
                <div class="flex flex-col items-center gap-4">
                    {{-- Current Avatar --}}
                    <div class="relative">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-border shadow-lg">
                        @else
                            <div class="w-32 h-32 rounded-full bg-primary/10 flex items-center justify-center border-4 border-border">
                                <span class="text-3xl font-bold text-primary">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Avatar Upload --}}
                    <div class="w-full space-y-3">
                        <x-form.image name="form.avatar" wire:model="form.avatar" accept="image/*" hint="Upload foto profil (maks. 2MB)" />

                        @if ($user->avatar)
                            <button wire:click="deleteAvatar" wire:confirm="Apakah Anda yakin ingin menghapus avatar?" class="w-full kt-btn kt-btn-danger">
                                <i class="iconify lucide--trash-2 mr-2"></i>
                                Hapus Avatar
                            </button>
                        @endif
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Profile Form --}}
        <div class="lg:col-span-2">
            <form wire:submit="save" wire:ignore>
                <x-card title="Informasi Profil">
                    {{-- Name --}}
                    <x-form.input name="form.name" wire:model="form.name" label="Nama Lengkap" placeholder="contoh: John Doe" />

                    {{-- Email --}}
                    <x-form.email name="form.email" wire:model="form.email" label="Alamat Email" placeholder="contoh: john@example.com" />

                    {{-- Username --}}
                    <x-form.input name="form.username" wire:model="form.username" label="Nama Pengguna" placeholder="contoh: johndoe" />

                    {{-- Phone --}}
                    <x-form.tel name="form.phone" wire:model="form.phone" label="Nomor Telepon" placeholder="contoh: 62812345678" />

                    {{-- Password --}}
                    <x-form.password name="form.password" wire:model="form.password" label="Password Baru" placeholder="Biarkan kosong jika tidak ingin mengubah" hint="Biarkan kosong jika tidak ingin mengubah password." />

                    @slot('footer')
                        <x-button.form-cancel route="dashboard" label="Batal" />
                        <x-button.save entityName="Profil" :isEdit="true" />
                    @endslot
                </x-card>
            </form>
        </div>
    </div>
</div>
