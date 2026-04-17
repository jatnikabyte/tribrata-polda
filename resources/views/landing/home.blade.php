@extends('layouts.landing')
@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center section-padding bg-linear-to-br from-[#2563EB] to-[#1E40AF] overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        Kelola Laundry Lebih Mudah dengan {{ getSetting('title') }}
                    </h1>
                    <p class="text-lg md:text-xl text-blue-100 mb-8">
                        Solusi pintar untuk operasional laundry modern, cepat, dan terintegrasi.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ getSetting('link_appstore') }}" target="_blank" class="btn-primary">
                            Mulai Sekarang
                        </a>
                        <a href="{{ getSetting('link_demo') }}" target="_blank" class="border-2 border-white text-white font-semibold py-4 px-8 rounded-lg hover:bg-white/10 transition-colors text-center">
                            Lihat Demo
                        </a>
                    </div>
                </div>

                <div class="flex justify-center lg:justify-end">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-3xl transform rotate-6"></div>
                        <img src="{{ asset('storage/settings/' . getSetting('img_hero')) }}" alt="{{ getSetting('title') }} App Mockup" class="relative z-10 w-full max-w-md rounded-3xl shadow-2xl">
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#solutions" class="text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Problem & Solution Section -->
    <section id="solutions" class="section-padding bg-gray-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Masalah yang Sering Dihadapi
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ getSetting('title') }} hadir sebagai solusi untuk berbagai tantangan dalam mengelola bisnis laundry
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Problems -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Masalah</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Catatan manual yang rentan kesalahan</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Rekap layanan dan pendapatan sering tidak sinkron</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Sulit memantau status order pelanggan</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Laporan keuangan tidak real-time</span>
                        </li>
                    </ul>
                </div>

                <!-- Solutions -->
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Solusi {{ getSetting('title') }}</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Pencatatan digital otomatis dan terpusat</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Sistem terintegrasi antara layanan dan pendapatan</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Monitoring status order secara real-time</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Laporan keuangan otomatis dan akurat</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section id="features" class="section-padding">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kelola bisnis laundry Anda dengan fitur-fitur lengkap dan modern
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Order Laundry</h3>
                    <p class="text-gray-600">Terima, kelola, dan track setiap order pelanggan dengan mudah dan terorganisir.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tracking Status Cucian</h3>
                    <p class="text-gray-600">Pantau status cucian dari masuk hingga selesai dengan notifikasi otomatis.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Outlet & Karyawan</h3>
                    <p class="text-gray-600">Kelola multiple outlet dan atur role akses karyawan dengan efisien.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kelola Data Master</h3>
                    <p class="text-gray-600">Kelola seluruh data utama aplikasi agar operasional berjalan konsisten dan efisien.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Keuangan Real-time</h3>
                    <p class="text-gray-600">Akses laporan pendapatan, pengeluaran, dan profit kapan saja dibutuhkan.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notifikasi Pelanggan</h3>
                    <p class="text-gray-600">Kirim notifikasi tentang status cucian ke pelanggan via WhatsApp.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section-padding bg-gray-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Cara Kerja {{ getSetting('title') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Mulai digitalisasi bisnis laundry Anda dalam 4 langkah mudah
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg text-center relative z-10">
                        <div class="w-16 h-16 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Daftar Akun</h3>
                        <p class="text-gray-600">Buat akun {{ getSetting('title') }} Anda dengan mengisi form pendaftaran sederhana.</p>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-linear-to-r from-[#2563EB] to-[#1E40AF]"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg text-center relative z-10">
                        <div class="w-16 h-16 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Setup Outlet</h3>
                        <p class="text-gray-600">Konfigurasi profil outlet dan daftarkan layanan laundry yang tersedia.</p>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-linear-to-r from-[#2563EB] to-[#1E40AF]"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg text-center relative z-10">
                        <div class="w-16 h-16 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Terima Order</h3>
                        <p class="text-gray-600">Mulai terima order pelanggan melalui aplikasi dengan sistem digital.</p>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 w-8 h-0.5 bg-linear-to-r from-[#2563EB] to-[#1E40AF]"></div>
                </div>

                <!-- Step 4 -->
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-2xl font-bold text-white">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Kelola Operasional</h3>
                        <p class="text-gray-600">Pantau dan kelola seluruh operasional laundry dari satu dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- App Screenshots Gallery -->
    <section class="section-padding">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Tampilan Aplikasi
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Desain modern dan intuitif untuk kemudahan penggunaan
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <img src="{{ asset('storage/settings/' . getSetting('img_feature_1')) }}" alt="Dashboard Aplikasi" class="w-full h-auto">
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <img src="{{ asset('storage/settings/' . getSetting('img_feature_2')) }}" alt="Halaman Order" class="w-full h-auto">
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <img src="{{ asset('storage/settings/' . getSetting('img_feature_3')) }}" alt="Halaman Laporan" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section-padding bg-gray-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pilihan Paket
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pilih paket yang sesuai dengan kebutuhan bisnis laundry Anda
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @foreach ($plans as $plan)
                    @php
                        $isPopular = $plan->is_popular;
                        $pricing = $plan->billingPlanPricings->first();
                        $pricingPrice = $pricing->price ?? 0;
                        $price = parseCurrency($pricingPrice / 1000 ?? 0, 0) . 'K';
                        $cycle = $pricing && $pricing->billingCycle ? '/' . strtolower($pricing->billingCycle->name) : '';
                    @endphp

                    <div class="{{ $isPopular ? 'bg-linear-to-br from-[#2563EB] to-[#1E40AF] transform md:-translate-y-4 shadow-xl' : 'bg-white shadow-lg' }} rounded-2xl p-8 relative">
                        @if ($isPopular)
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-2xl font-bold text-white">{{ $plan->name }}</h3>
                                <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">POPULAR</span>
                            </div>
                        @else
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        @endif

                        <p class="{{ $isPopular ? 'text-blue-100' : 'text-gray-600' }} mb-6">Paket terbaik untuk anda</p>

                        <div class="mb-6">
                            <span class="text-4xl font-bold {{ $isPopular ? 'text-white' : 'text-gray-900' }}">Rp {{ $price }}</span>
                            <span class="{{ $isPopular ? 'text-blue-100' : 'text-gray-600' }}">{{ $cycle }}</span>
                        </div>

                        <ul class="space-y-3 mb-8">
                            {{-- Basic Limits --}}
                            <li class="flex items-center {{ $isPopular ? 'text-white' : 'text-gray-700' }}">
                                <svg class="w-5 h-5 {{ $isPopular ? 'text-white' : 'text-green-500' }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $plan->max_outlet >= getSetting('unlimited_limit') ? 'Unlimited' : $plan->max_outlet }} Outlet / Tenant
                            </li>
                            <li class="flex items-center {{ $isPopular ? 'text-white' : 'text-gray-700' }}">
                                <svg class="w-5 h-5 {{ $isPopular ? 'text-white' : 'text-green-500' }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $plan->max_user >= getSetting('unlimited_limit') ? 'Unlimited' : $plan->max_user }} Kasir / Outlet
                            </li>
                            <li class="flex items-center {{ $isPopular ? 'text-white' : 'text-gray-700' }}">
                                <svg class="w-5 h-5 {{ $isPopular ? 'text-white' : 'text-green-500' }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $plan->max_transaction >= getSetting('unlimited_limit') ? 'Unlimited' : $plan->max_transaction }} Trx / Hari (Per-Outlet)
                            </li>

                            {{-- Features --}}
                            @foreach ($plan->billingPlanFeatures as $feature)
                                <li class="flex items-center {{ $isPopular ? 'text-white' : 'text-gray-700' }}">
                                    <svg class="w-5 h-5 {{ $isPopular ? 'text-white' : 'text-green-500' }} mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ $feature->feature }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ getSetting('link_appstore') }}" target="_blank" class="{{ $isPopular ? 'bg-white text-primary hover:bg-gray-100' : 'btn-secondary' }} font-semibold py-3 px-6 rounded-lg block text-center transition-colors">
                            Pilih Paket
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="section-padding">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Apa Kata Mereka
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pengalaman nyata dari pengguna {{ getSetting('title') }}
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($testimonials as $testimonial)
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                @for ($i = 0; $i < $testimonial->rating; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6">"{{ $testimonial->content }}"</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-linear-to-r from-[#2563EB] to-[#1E40AF] rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold">{{ initialName($testimonial->name) }}</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $testimonial->role }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="section-padding bg-gray-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Temukan jawaban untuk pertanyaan yang sering diajukan
                </p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                @foreach ($faqs as $faq)
                    <details class="bg-white rounded-xl shadow-lg group">
                        <summary class="flex items-center justify-between p-6 cursor-pointer">
                            <span class="font-semibold text-gray-900">{{ $faq->question }}</span>
                            <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="px-6 pb-6 text-gray-600">
                            {{ $faq->answer }}
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section id="cta" class="section-padding bg-linear-to-br from-[#2563EB] to-[#1E40AF]">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                    Siap Transformasi Bisnis Laundry Anda?
                </h2>
                <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                    Bergabunglah dengan ratusan pemilik laundry yang telah sukses digitalisasi operasional dengan {{ getSetting('title') }}.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ getSetting('link_appstore') }}" target="_blank" class="btn-primary">
                        Daftar Sekarang
                    </a>
                    <a target="_blank" href="https://wa.me/{{ getSetting('whatsapp') }}" class="border-2 border-white text-white font-semibold py-4 px-8 rounded-lg hover:bg-white/10 transition-colors text-center">
                        Hubungi Kami
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="mt-12 pt-12 border-t border-white/20">
                    <div class="flex flex-col md:flex-row items-center justify-center gap-8 text-white">
                        <a href="mailto:{{ getSetting('support_email') }}" class="flex items-center hover:text-blue-200 transition-colors">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ getSetting('support_email') }}
                        </a>
                        <a target="_blank" href="https://wa.me/{{ getSetting('whatsapp') }}" class="flex items-center hover:text-blue-200 transition-colors">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            +{{ getSetting('whatsapp') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
