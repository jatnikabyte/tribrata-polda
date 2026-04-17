<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/settings/' . getSetting('site_favicon')) }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Majalah Digital POLDA BANTEN - Media Publikasi Resmi')</title>
    <meta name="description" content="@yield('description', 'Media Publikasi Resmi Kepolisian Republik Indonesia. Transparan, Profesional, Terpercaya.')" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Majalah Digital POLDA BANTEN - Media Publikasi Resmi')">
    <meta property="og:description" content="@yield('description', 'Media Publikasi Resmi Kepolisian Republik Indonesia. Transparan, Profesional, Terpercaya.')">
    <meta property="og:image" content="{{ asset('storage/settings/' . getSetting('site_logo')) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Majalah Digital POLDA BANTEN - Media Publikasi Resmi')">
    <meta property="twitter:description" content="@yield('description', 'Media Publikasi Resmi Kepolisian Republik Indonesia. Transparan, Profesional, Terpercaya.')">
    <meta property="twitter:image" content="{{ asset('storage/settings/' . getSetting('site_logo')) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Flipbook StyleSheet -->
    <link href="{{ asset('assets/dflip/css/dflip.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .df-container {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        ._df_button {
            all: unset;
            display: inline-flex !important;
            cursor: pointer !important;
        }
    </style>
    <!-- Icons Stylesheet -->
    <link href="{{ asset('assets/dflip/css/themify-icons.min.css') }} " rel="stylesheet" type="text/css">
    @vite(['resources/css/public.css', 'resources/js/public.js'])

    @stack('styles')

    <!-- Google tag (gtag.js) -->
    @if (env('GOOGLE_ANALYTICS_MEASUREMENT_ID'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_MEASUREMENT_ID') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ env('GOOGLE_ANALYTICS_MEASUREMENT_ID') }}');
        </script>
    @endif
</head>

<body class="font-sans antialiased text-gray-800 bg-polri-black">

    <!-- ================= HEADER TOP ================= -->
    <div class="bg-linear-to-r from-polri-black via-polri-black to-polri-primary text-white py-3 text-xs relative z-50 border-b-2 border-polri-gold">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <!-- Left: Text Slide -->
            <div class="flex-1 overflow-hidden relative max-w-2xl">
                <div class="animate-marquee whitespace-nowrap flex space-x-8">
                    @foreach (getHeadline() as $item)
                        <a target="_blank" href="{{ $item->link }}" class="hover:text-polri-gold transition flex items-center space-x-2">
                            <span style="background-color: {{ $item->badge_color }}" class="px-3 py-1 rounded text-[10px] font-black uppercase tracking-wider badge-shine">{{ $item->badge }}</span>
                            <span class="font-semibold">{{ $item->title }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Right: Social Media -->
            <div class="flex items-center space-x-4 ml-4 shrink-0">
                <a href="{{ getSetting('site_ig') }}" target="_blank" class="text-polri-gold hover:text-polri-secondary transition transform hover:scale-110"><span class="sr-only">Instagram</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg></a>
                <a href="{{ getSetting('site_x') }}" target="_blank" class="text-polri-gold hover:text-polri-secondary transition transform hover:scale-110"><span class="sr-only">Twitter/X</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg></a>
                <a href="{{ getSetting('site_fb') }}" target="_blank" class="text-polri-gold hover:text-polri-secondary transition transform hover:scale-110"><span class="sr-only">Facebook</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg></a>
                <a href="{{ getSetting('site_youtube') }}" target="_blank" class="text-polri-gold hover:text-polri-secondary transition transform hover:scale-110"><span class="sr-only">YouTube</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg></a>
            </div>
        </div>
    </div>

    <!-- ================= HEADER ================= -->
    <header class="sticky top-0 w-full z-40 bg-white shadow-2xl transition-all duration-300" id="navbar">

        <!-- Bold Red Trapezoid Background -->
        <div class="absolute inset-y-0 left-0 w-[80%] md:w-[55%] bg-linear-to-r from-polri-primary to-polri-primary z-0 pointer-events-none" style="clip-path: polygon(0 0, 100% 0, 80% 100%, 0 100%);"></div>

        <!-- Gold accent line -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-linear-to-r from-polri-gold via-polri-primary to-polri-secondary z-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex justify-between items-center h-16 sm:h-20 md:h-24">
                <!-- Logo & Title (On Red Background -> White Text) -->
                <a href="{{ route('home', request()->query()) }}">
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <div class="relative">
                            <img src="{{ asset('storage/settings/' . getSetting('site_logo')) }}" alt="Logo POLDA BANTEN" class="h-12 sm:h-16 md:h-18 lg:h-20 w-auto drop-shadow-2xl">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white font-black text-[10px] sm:text md:text-[12px] lg:text-xl tracking-widest leading-none font-sans drop-shadow-lg">{{ getSetting('site_title_1') }}</span>
                            <span class="text-polri-gold text-[8px] sm:text-sm md:text-[10px] lg:text-base font-black tracking-[0.2em] sm:tracking-[0.25em] md:tracking-[0.3em] drop-shadow-md">{{ getSetting('site_title_2') }}</span>
                            <span class="text-white/80 text-[8px] sm:text-[9px] md:text-[10px] font-semibold tracking-wider mt-0.5 sm:mt-1">{{ getSetting('site_subtitle') }}</span>
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation (On White Background -> Dark Text) -->
                <nav class="hidden md:flex space-x-10">
                    <a href="{{ route('home', request()->query()) }}" class="nav-link relative text-polri-black hover:text-polri-primary transition font-bold text-sm uppercase tracking-widest">Beranda</a>
                    <a href="{{ route('pages.index', request()->query()) }}" class="nav-link relative text-polri-black hover:text-polri-primary transition font-bold text-sm uppercase tracking-widest">Halaman</a>
                    <a href="{{ route('videos.index', request()->query()) }}" class="nav-link relative text-polri-black hover:text-polri-primary transition font-bold text-sm uppercase tracking-widest">Video</a>
                    <a href="{{ route('tabloids.index', request()->query()) }}" class="nav-link relative text-polri-black hover:text-polri-primary transition font-bold text-sm uppercase tracking-widest">Tabloid</a>
                </nav>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-polri-secondary focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="fixed inset-0 bg-polri-black/95 z-50 hidden flex-col items-center justify-center backdrop-blur-md opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-transform duration-300" id="mobileMenuContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-polri-black">Menu</h3>
                    <button onclick="toggleMobileMenu()" class="text-gray-500 hover:text-polri-primary transition p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12 12-12"></path>
                        </svg>
                    </button>
                </div>
                <nav class="space-y-4">
                    <a href="{{ route('home', request()->query()) }}" onclick="toggleMobileMenu()" class="block px-4 py-3 rounded-lg text-polri-black hover:bg-polri-primary hover:text-white transition font-bold text-lg">
                        Beranda
                    </a>
                    <a href="{{ route('pages.index', request()->query()) }}" onclick="toggleMobileMenu()" class="block px-4 py-3 rounded-lg text-polri-black hover:bg-polri-primary hover:text-white transition font-bold text-lg">
                        Halaman
                    </a>
                    <a href="{{ route('videos.index', request()->query()) }}" onclick="toggleMobileMenu()" class="block px-4 py-3 rounded-lg text-polri-black hover:bg-polri-primary hover:text-white transition font-bold text-lg">
                        Video
                    </a>
                    <a href="{{ route('tabloids.index', request()->query()) }}" onclick="toggleMobileMenu()" class="block px-4 py-3 rounded-lg text-polri-black hover:bg-polri-primary hover:text-white transition font-bold text-lg">
                        Tabloid
                    </a>
                </nav>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- ================= FOOTER ================= -->
    <footer class="bg-linear-to-b from-gray-900 to-polri-black text-white pt-8 lg:pt-20 lg:pb-8 border-t-4 border-polri-gold relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 diagonal-stripes opacity-30"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-polri-primary/10 rounded-full blur-[120px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-polri-secondary/10 rounded-full blur-[100px] -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="lg:flex lg:items-center space-x-2 sm:space-x-3 md:space-x-4 mb-6">
                        <div class="relative shrink-0">
                            <img src="{{ asset('storage/settings/' . getSetting('site_logo_2')) }}" alt="Logo POLDA BANTEN" class="h-10 sm:h-12 md:h-14 lg:h-16 w-auto drop-shadow-xl max-h-16">
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-white font-black text-sm sm:text-md md:text-lg lg:text-xl tracking-wider font-sans leading-tight">{{ getSetting('site_title_1') }}</span>
                            <span class="text-polri-gold text-md sm:text-md md:text-md font-bold tracking-widest sm:tracking-[0.15em] md:tracking-[0.2em] leading-tight">{{ getSetting('site_title_2') }}</span>
                        </div>
                    </div>
                    <p class="text-gray-400 leading-relaxed mb-6 text-sm">
                        {{ getSetting('site_tagline') }}
                    </p>
                    <div class="flex space-x-3">
                        <a href="{{ getSetting('site_x') }}" target="_blank" class="w-11 h-11 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-polri-secondary hover:border-polri-secondary transition-all duration-300 text-white transform hover:scale-110 hover:-rotate-6">

                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2H21.5l-7.37 8.42L23 22h-6.828l-5.347-6.99L4.5 22H1.244l7.87-9.01L1 2h6.828l4.84 6.36L18.244 2zm-2.396 18h1.89L7.102 4h-2.03l10.776 16z" />
                            </svg>

                        </a>
                        <a href="{{ getSetting('site_ig') }}" target="_blank" class="w-11 h-11 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-polri-primary hover:border-polri-primary transition-all duration-300 text-white transform hover:scale-110 hover:-rotate-6">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="{{ getSetting('site_youtube') }}" target="_blank" class="w-11 h-11 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-polri-primary hover:border-polri-primary transition-all duration-300 text-white transform hover:scale-110 hover:-rotate-6">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </a>
                        <a href="{{ getSetting('site_fb') }}" target="_blank" class="w-11 h-11 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-polri-secondary hover:border-polri-secondary transition-all duration-300 text-white transform hover:scale-110 hover:-rotate-6">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22 12.073C22 6.477 17.523 2 12 2S2 6.477 2 12.073c0 5.017 3.657 9.176 8.438 9.927v-7.02H7.898v-2.907h2.54V9.845c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562v1.877h2.773l-.443 2.907h-2.33V22c4.78-.75 8.437-4.91 8.437-9.927z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-lg font-black text-polri-gold mb-6 uppercase tracking-widest">Tautan Cepat</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home', request()->query()) }}" class="text-gray-400 hover:text-polri-gold transition flex items-center font-semibold group">
                                <span class="mr-3 text-polri-primary group-hover:text-polri-gold transition">▸</span> Beranda</a></li>
                        <li><a href="{{ route('pages.index', request()->query()) }}" class="text-gray-400 hover:text-polri-gold transition flex items-center font-semibold group">
                                <span class="mr-3 text-polri-primary group-hover:text-polri-gold transition">▸</span> Halaman</a></li>
                        <li><a href="{{ route('videos.index', request()->query()) }}" class="text-gray-400 hover:text-polri-gold transition flex items-center font-semibold group">
                                <span class="mr-3 text-polri-primary group-hover:text-polri-gold transition">▸</span> Video</a></li>
                        <li><a href="{{ route('tabloids.index', request()->query()) }}" class="text-gray-400 hover:text-polri-gold transition flex items-center font-semibold group">
                                <span class="mr-3 text-polri-primary group-hover:text-polri-gold transition">▸</span> Tabloid</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-black text-polri-gold mb-6 uppercase tracking-widest">Hubungi Kami</h3>
                    <ul class="space-y-5">
                        <li class="flex items-start text-gray-400">
                            <div class="w-10 h-10 rounded-lg bg-polri-primary/20 flex items-center justify-center mr-4 shrink-0">
                                <svg class="w-5 h-5 text-polri-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm leading-relaxed">{{ getSetting('site_address') }}</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <div class="w-10 h-10 rounded-lg bg-polri-secondary/20 flex items-center justify-center mr-4 shrink-0">
                                <svg class="w-5 h-5 text-polri-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <span class="font-semibold">{{ getSetting('site_phone') }}</span>
                        </li>
                        <li class="flex items-center text-gray-400">
                            <div class="w-10 h-10 rounded-lg bg-polri-gold/20 flex items-center justify-center mr-4 shrink-0">
                                <svg class="w-5 h-5 text-polri-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="font-semibold">{{ getSetting('site_email') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-sm text-gray-500">© 2026 {{ getSetting('site_name') }}. <span class="text-polri-gold font-bold">All Rights Reserved.</span></p>
            </div>
        </div>
    </footer>

    <!-- ================= SCRIPTS ================= -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- jQuery  -->
    <script src="{{ asset('assets/dflip/js/libs/jquery.min.js') }}" type="text/javascript"></script>
    <!-- Flipbook main Js file -->
    <script src="{{ asset('assets/dflip/js/dflip.min.js') }}" type="text/javascript"></script>

    @stack('scripts')

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            var mobileMenu = document.getElementById('mobileMenu');
            var mobileMenuContent = document.getElementById('mobileMenuContent');

            if (!mobileMenu || !mobileMenuContent) {
                console.error('Mobile menu elements not found');
                return;
            }

            if (mobileMenu.classList.contains('hidden')) {
                // Show menu
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('flex');

                setTimeout(function() {
                    mobileMenu.classList.remove('opacity-0');
                    mobileMenuContent.classList.remove('scale-95');
                    mobileMenuContent.classList.add('scale-100');
                }, 10);
            } else {
                // Hide menu
                mobileMenu.classList.add('opacity-0');
                mobileMenuContent.classList.remove('scale-100');
                mobileMenuContent.classList.add('scale-95');

                setTimeout(function() {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                }, 300);
            }
        }

        function trackAndOpenFlipbook(tabloidId) {
            fetch(`/tabloid/view/${tabloidId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            }).catch(() => {});
        }

        // Close mobile menu on click outside
        document.addEventListener('click', function(e) {
            var mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu && e.target === mobileMenu && !mobileMenu.classList.contains('hidden')) {
                toggleMobileMenu();
            }
        });

        // Close mobile menu on ESC key
        document.addEventListener('keydown', function(e) {
            var mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu && !mobileMenu.classList.contains('hidden') && e.key === 'Escape') {
                toggleMobileMenu();
            }
        });
    </script>

    {{-- Template Inline Editor (only in edit mode) --}}
    @if (auth()->check() && request()->has('edit-template'))
        <style>
            /* ─── Edit Mode Bar ──────────────────────────────── */
            .tpl-edit-bar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 9999;
                background: linear-gradient(135deg, #1a1a2e, #16213e);
                color: #d4af37;
                padding: 10px 20px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 13px;
                font-weight: 600;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .4);
                letter-spacing: .5px
            }

            .tpl-edit-bar a.tpl-edit-bar-close {
                margin-left: auto;
                color: #fff;
                background: #c0392b;
                padding: 4px 14px;
                border-radius: 6px;
                text-decoration: none;
                font-size: 12px;
                font-weight: 700;
                transition: all .2s
            }

            .tpl-edit-bar a.tpl-edit-bar-close:hover {
                background: #e74c3c;
                transform: scale(1.05)
            }

            /* ─── Editable Wrapper ───────────────────────────── */
            .tpl-editable {
                position: relative;
                display: inline
            }

            .tpl-edit-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 22px;
                height: 22px;
                border: none;
                background: #d4af37;
                color: #1a1a2e;
                border-radius: 4px;
                cursor: pointer;
                margin-left: 4px;
                vertical-align: middle;
                transition: all .2s;
                padding: 0;
                line-height: 1
            }

            .tpl-edit-btn:hover {
                background: #f0c040;
                transform: scale(1.15);
                box-shadow: 0 2px 8px rgba(212, 175, 55, .5)
            }

            /* ─── Modal ──────────────────────────────────────── */
            .tpl-modal-overlay {
                position: fixed;
                inset: 0;
                z-index: 10000;
                background: rgba(0, 0, 0, .7);
                backdrop-filter: blur(6px);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                visibility: hidden;
                transition: all .25s
            }

            .tpl-modal-overlay.tpl-modal-visible {
                opacity: 1;
                visibility: visible
            }

            .tpl-modal-container {
                background: #fff;
                border-radius: 16px;
                width: 90%;
                max-width: 640px;
                max-height: 85vh;
                overflow: hidden;
                box-shadow: 0 25px 60px rgba(0, 0, 0, .4);
                border: 2px solid #d4af37;
                transform: scale(.95) translateY(10px);
                transition: transform .25s
            }

            .tpl-modal-visible .tpl-modal-container {
                transform: scale(1) translateY(0)
            }

            .tpl-modal-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 24px;
                background: linear-gradient(135deg, #1a1a2e, #16213e);
                color: #d4af37;
                border-bottom: 2px solid #d4af37
            }

            .tpl-modal-header-left {
                display: flex;
                align-items: center;
                gap: 10px
            }

            .tpl-modal-header h3 {
                margin: 0;
                font-size: 16px;
                font-weight: 800;
                letter-spacing: .5px
            }

            .tpl-modal-close-btn {
                background: none;
                border: none;
                color: #fff;
                cursor: pointer;
                padding: 4px;
                border-radius: 6px;
                transition: all .2s;
                display: flex;
                align-items: center
            }

            .tpl-modal-close-btn:hover {
                background: rgba(255, 255, 255, .1);
                color: #d4af37
            }

            .tpl-modal-body {
                padding: 24px;
                overflow-y: auto;
                max-height: 50vh
            }

            .tpl-label {
                display: block;
                margin-bottom: 16px
            }

            .tpl-label-text {
                display: block;
                font-size: 12px;
                font-weight: 700;
                color: #666;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 6px
            }

            .tpl-input {
                width: 100%;
                padding: 10px 14px;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                font-size: 14px;
                color: #999;
                background: #f8fafc;
                outline: none;
                box-sizing: border-box
            }

            .tpl-textarea {
                width: 100%;
                padding: 12px 14px;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                font-size: 14px;
                font-family: inherit;
                resize: vertical;
                min-height: 120px;
                outline: none;
                transition: border-color .2s;
                box-sizing: border-box
            }

            .tpl-textarea:focus {
                border-color: #d4af37;
                box-shadow: 0 0 0 3px rgba(212, 175, 55, .15)
            }

            .tpl-modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                padding: 16px 24px;
                border-top: 1px solid #e2e8f0;
                background: #f8fafc
            }

            .tpl-btn {
                padding: 10px 24px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
                border: none;
                transition: all .2s
            }

            .tpl-btn-cancel {
                background: #e2e8f0;
                color: #64748b
            }

            .tpl-btn-cancel:hover {
                background: #cbd5e1
            }

            .tpl-btn-save {
                background: #d4af37;
                color: #1a1a2e
            }

            .tpl-btn-save:hover {
                background: #f0c040;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(212, 175, 55, .4)
            }

            .tpl-btn-save:disabled {
                opacity: .6;
                cursor: not-allowed;
                transform: none
            }

            .tpl-hidden {
                display: none !important
            }

            /* ─── Toast ──────────────────────────────────────── */
            .tpl-toast {
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 10001;
                padding: 14px 24px;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 600;
                color: #fff;
                opacity: 0;
                transform: translateY(20px);
                transition: all .3s;
                box-shadow: 0 8px 24px rgba(0, 0, 0, .3)
            }

            .tpl-toast-visible {
                opacity: 1;
                transform: translateY(0)
            }

            .tpl-toast-success {
                background: linear-gradient(135deg, #059669, #10b981)
            }

            .tpl-toast-error {
                background: linear-gradient(135deg, #dc2626, #ef4444)
            }

            /* Push body down for edit bar */
            body {
                padding-top: 42px !important
            }
        </style>
        @vite('resources/js/template-editor.js')
    @endif

</body>

</html>
