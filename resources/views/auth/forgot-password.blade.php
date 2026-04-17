@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-8 bg-default-50">
        <div class="w-full max-w-md">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="iconify lucide--lock text-3xl text-primary"></i>
                </div>
                <h2 class="text-3xl font-bold text-default-800 mb-2">Lupa Password?</h2>
                <p class="text-default-500">Jangan khawatir, kami akan mengirimkan petunjuk pengaturan ulang kepada Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center gap-2 text-green-800">
                        <i class="iconify lucide--check-circle text-xl"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-default-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="iconify lucide--mail text-default-400 text-lg"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" class="kt-input w-full pl-10 @error('email') kt-input-error @enderror" required autofocus autocomplete="email">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="kt-btn kt-btn-primary w-full h-12 text-base">
                    <span class="inline-flex items-center gap-2">
                        <i class="iconify lucide--send text-lg"></i>
                        Send Reset Link
                    </span>
                </button>
            </form>

            {{-- Back to Login --}}
            <div class="mt-6 text-center">
                <a href="{{ route('jt.login') }}" class="inline-flex items-center text-primary hover:text-primary/80 font-medium">
                    <i class="iconify lucide--arrow-left mr-2"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection
