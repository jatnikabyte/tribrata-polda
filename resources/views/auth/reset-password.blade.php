@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
@php
    $token = request()->route('token');
@endphp
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

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2 text-green-800">
                    <i class="iconify lucide--check-circle text-xl"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-default-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="iconify lucide--mail text-default-400 text-lg"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" class="kt-input w-full pl-10 @error('email') kt-input-error @enderror" required autocomplete="email">
                </div>
                @error('email')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div x-data="{ showPassword: false }">
                <label class="block text-sm font-medium text-default-700 mb-2">New Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="iconify lucide--lock text-default-400 text-lg"></i>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Enter your new password" class="kt-input w-full pl-10 pr-10 @error('password') kt-input-error @enderror" required autocomplete="new-password">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600">
                        <i class="iconify text-lg" :class="showPassword ? 'lucide--eye-off' : 'lucide--eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div x-data="{ showConfirmPassword: false }">
                <label class="block text-sm font-medium text-default-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="iconify lucide--lock text-default-400 text-lg"></i>
                    </div>
                    <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm your new password" class="kt-input w-full pl-10 pr-10 @error('password_confirmation') kt-input-error @enderror" required autocomplete="new-password">
                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600">
                        <i class="iconify text-lg" :class="showConfirmPassword ? 'lucide--eye-off' : 'lucide--eye'"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="kt-btn kt-btn-primary w-full h-12 text-base">
                <span class="inline-flex items-center gap-2">
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
@endsection
