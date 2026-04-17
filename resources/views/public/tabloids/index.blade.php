@extends('layouts.public')

@section('title', 'Tabloid - ' . getSetting('site_name'))
@section('description', 'Koleksi tabloid majalah dari ' . getSetting('site_name'))

@section('content')
    <!-- Flipbook Modal -->
    <x-flipbook-modal />

    <!-- Tabloid Header -->
    <x-page-header views="{{ $totalViews }}" follower="{{ $totalFollow }}" title="Tabloid Digital" description="Baca edisi terbaru tabloid majalah dari {{ getSetting('site_name') }}" />

    <!-- Tabloids List -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($tabloids->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($tabloids as $tabloid)
                        <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                            <!-- Tabloid Cover -->
                            <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                                @if ($tabloid->cover)
                                    <img src="{{ asset('storage/' . $tabloid->cover) }}" alt="{{ $tabloid->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-polri-primary to-polri-secondary flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Edition Badge -->
                                @if ($tabloid->edition_of)
                                    <div class="absolute top-4 right-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-polri-gold text-polri-black">
                                            Edisi {{ $tabloid->edition_of }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Tabloid Info -->
                            <div class="p-6">
                                <h2 class="text-lg font-bold text-polri-black mb-2 group-hover:text-polri-primary transition line-clamp-2">
                                    {{ $tabloid->title }}
                                </h2>

                                <!-- Stats Badges -->
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center gap-1 text-sm text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>{{ Number::format($tabloid->view_count) }} views</span>
                                    </span>
                                </div>

                                @if (request()->cookie('subscriber_email'))
                                    <div onclick="trackAndOpenFlipbook('{{ $tabloid->encryptedId }}')" source="{{ asset($tabloid->file_pdf) }}" class="_df_button">
                                        <button class="cursor-pointer inline-flex items-center text-polri-primary font-semibold hover:text-polri-secondary transition">
                                            Baca Tabloid
                                        </button>
                                    </div>
                                @else
                                    <button onclick="openSubscribeModal('{{ $tabloid->encryptedId }}', '{{ $tabloid->title }}')" class="cursor-pointer inline-flex items-center text-polri-primary font-semibold hover:text-polri-secondary transition">
                                        Baca Tabloid
                                    </button>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($tabloids->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $tabloids->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">📰</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Tabloid</h3>
                    <p class="text-gray-500">Silakan kembali lagi nanti untuk tabloid terbaru.</p>
                </div>
            @endif
        </div>
    </section>
    @if (!request()->cookie('subscriber_email'))
        <x-subscribe-modal />
    @endif
@endsection
