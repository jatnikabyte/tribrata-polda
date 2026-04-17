<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

new #[Layout('layouts.guest')] #[Title('Forgot Password')] class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    public string $status = '';

    public function sendResetLink()
    {
        $this->validate();

        // Rate limiting
        $key = 'password-reset:' . Str::lower($this->email);
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Too many attempts. Please try again in {$seconds} seconds.");
            return;
        }

        RateLimiter::hit($key, 60); // 1 minute decay

        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = 'We have emailed your password reset link.';
            RateLimiter::clear($key);
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
                <i class="iconify lucide--lock text-3xl text-primary"></i>
            </div>
            <h2 class="text-3xl font-bold text-default-800 mb-2">Forgot Password?</h2>
            <p class="text-default-500">No worries, we'll send you reset instructions.</p>
        </div>

        @if ($status)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2 text-green-800">
                    <i class="iconify lucide--check-circle text-xl"></i>
                    <span>{{ $status }}</span>
                </div>
            </div>
        @endif

        <form wire:submit="sendResetLink" class="space-y-6">
            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-default-700 mb-2">Email Address</label>
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

            {{-- Submit --}}
            <button type="submit" class="kt-btn kt-btn-primary w-full h-12 text-base" wire:loading.attr="disabled">
                <span wire:loading wire:target="sendResetLink" class="inline-flex items-center gap-2">
                    <i class="iconify lucide--loader-2 text-lg animate-spin"></i>
                    Sending...
                </span>
                <span wire:loading.remove wire:target="sendResetLink" class="inline-flex items-center gap-2">
                    <i class="iconify lucide--send text-lg"></i>
                    Send Reset Link
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
