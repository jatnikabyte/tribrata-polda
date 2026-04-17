<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

new #[Layout('layouts.guest')] #[Title('Reset Password')] class extends Component {
    public string $token = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public string $status = '';

    public function mount(string $token = null): void
    {
        $this->token = request()->route('token');
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ], function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));

            auth()->login($user);
        });

        if ($status === Password::PASSWORD_RESET) {
            $this->status = 'Your password has been reset successfully!';
            
            // Redirect to dashboard after successful reset
            return $this->redirect(route('dashboard'), navigate: true);
        } else {
            $this->addError('email', __($status));
        }
    }
}; ?>

<div class="min-h-screen flex items-center justify-center p-8 bg-default-50">
    <div class="w-full max-w-md">
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                <i class="iconify lucide--key text-3xl text-primary"></i>
            </div>
            <h2 class="text-3xl font-bold text-default-800 mb-2">Reset Password</h2>
            <p class="text-default-500">Enter your new password below.</p>
        </div>

        @if ($status)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2 text-green-800">
                    <i class="iconify lucide--check-circle text-xl"></i>
                    <span>{{ $status }}</span>
                </div>
            </div>
        @endif

        <form wire:submit="resetPassword" class="space-y-6">
            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-default-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="iconify lucide--mail text-default-400 text-lg"></i>
                    </div>
                    <input type="email" wire:model="email" placeholder="name@company.com" class="kt-input w-full pl-10 @error('email') kt-input-error @enderror" required>
                </div>
                @error('email')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div x-data="{ show: false }">
                <label class="block text-sm font-medium text-default-700 mb-2">New Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="iconify lucide--lock text-default-400 text-lg"></i>
                    </div>
                    <input :type="show ? 'text' : 'password'" wire:model="password" placeholder="Enter your new password" class="kt-input w-full pl-10 pr-10 @error('password') kt-input-error @enderror" required>
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600">
                        <i class="iconify text-lg" :class="show ? 'lucide--eye-off' : 'lucide--eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div x-data="{ show: false }">
                <label class="block text-sm font-medium text-default-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="iconify lucide--lock text-default-400 text-lg"></i>
                    </div>
                    <input :type="show ? 'text' : 'password'" wire:model="password_confirmation" placeholder="Confirm your new password" class="kt-input w-full pl-10 pr-10 @error('password_confirmation') kt-input-error @enderror" required>
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600">
                        <i class="iconify text-lg" :class="show ? 'lucide--eye-off' : 'lucide--eye'"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="kt-btn kt-btn-primary w-full h-12 text-base" wire:loading.attr="disabled">
                <span wire:loading wire:target="resetPassword" class="inline-flex items-center- gap-2">
                    <i class="iconify lucide--loader-2 text-lg animate-spin"></i>
                    Resetting...
                </span>
                <span wire:loading.remove wire:target="resetPassword" class="inline-flex items-center gap-2">
                    <i class="iconify lucide--check text-lg"></i>
                    Reset Password
                </span>
            </button>
        </form>

        {{-- Back to Login --}}
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center text-primary hover:text-primary/80 font-medium">
                <i class="iconify lucide--arrow-left mr-2"></i>
                Back to Login
            </a>
        </div>
    </div>
</div>
