<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.guest')] #[Title('Login')] class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return $this->redirectIntended(default: route('dashboard'), navigate: true);
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
}; ?>

<div class="min-h-screen flex">
    {{-- Left Side - Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary/90 to-primary/95 relative overflow-hidden">
        {{-- Decorative Background --}}
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/5 rounded-full blur-3xl"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
            {{-- Logo --}}
            <div class="mb-8">
                @php
                    $logo = getSetting('app_logo');
                    $title = getSetting('app_title') ?? config('app.name');
                    $tagline = getSetting('app_tagline') ?? 'Professional Admin Panel';
                @endphp
                @if ($logo && file_exists(public_path('storage/settings/' . $logo)))
                    <img src="{{ asset('storage/settings/' . $logo) }}" alt="{{ $title }}" class="h-24 w-auto object-contain">
                @else
                    <div class="h-24 w-24 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="iconify lucide--layout-dashboard text-5xl"></i>
                    </div>
                @endif
            </div>

            <h1 class="text-4xl font-bold text-center mb-3">{{ $title }}</h1>
            <p class="text-white/80 text-center text-lg max-w-md mb-12">{{ $tagline }}</p>

            {{-- Features --}}
            <div class="space-y-4 w-full max-w-sm">
                <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <i class="iconify lucide--shield-check text-xl"></i>
                    </div>
                    <span class="text-white/90">Aman dan Terlindungi</span>
                </div>
                <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <i class="iconify lucide--zap text-xl"></i>
                    </div>
                    <span class="text-white/90">Cepat & Efisien</span>
                </div>
                <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <i class="iconify lucide--settings text-xl"></i>
                    </div>
                    <span class="text-white/90">Pengelolaan Mudah</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side - Login Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-default-50">
        <div class="w-full max-w-md">
            {{-- Mobile Logo --}}
            <div class="lg:hidden mb-8 text-center">
                @php
                    $logo = getSetting('app_logo');
                    $title = getSetting('app_title') ?? config('app.name');
                @endphp
                @if ($logo && file_exists(public_path('storage/settings/' . $logo)))
                    <img src="{{ asset('storage/settings/' . $logo) }}" alt="{{ $title }}" class="h-16 w-auto object-contain mx-auto">
                @else
                    <div class="h-16 w-16 bg-primary/10 rounded-xl flex items-center justify-center mx-auto">
                        <i class="iconify lucide--layout-dashboard text-3xl text-primary"></i>
                    </div>
                @endif
            </div>

            {{-- Header --}}
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-default-800 mb-2">Selamat Datang kembali</h2>
                <p class="text-default-500">Masuk ke akun admin Anda</p>
            </div>

            <form wire:submit="login" class="space-y-6">
                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-default-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="iconify lucide--mail text-default-400 text-lg"></i>
                        </div>
                        <input type="email" wire:model="email" placeholder="name@company.com" class="kt-input w-full pl-10 @error('email') kt-input-error @enderror" required autofocus>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <label class="block text-sm font-medium text-default-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="iconify lucide--lock text-default-400 text-lg"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="********" class="kt-input w-full pl-10 pr-10 @error('password') kt-input-error @enderror" required>
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600">
                            <i class="iconify text-lg" :class="show ? 'lucide--eye-off' : 'lucide--eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-between mt-3" x-data="{ remember: @entangle('remember') }">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" x-model="remember" class="w-4 h-4 text-primary border-border rounded focus:ring-primary">
                            <span class="text-sm text-default-600">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-primary/80">Lupa password?</a>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="kt-btn kt-btn-primary w-full h-12 text-base" wire:loading.attr="disabled">
                    <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                        <i class="iconify lucide--loader-2 text-lg animate-spin"></i>
                        Signing in...
                    </span>
                    <span wire:loading.remove wire:target="login" class="inline-flex items-center gap-2">
                        <i class="iconify lucide--log-in text-lg"></i>
                        Sign In
                    </span>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-8 text-center">
                <p class="text-sm text-default-400">
                    &copy; {{ date('Y') }} {{ getSetting('app_title') ?? config('app.name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>
