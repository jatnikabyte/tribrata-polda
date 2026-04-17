@extends('layouts.public')

@section('title', 'Halaman - ' . getSetting('site_name'))
@section('description', 'Daftar semua halaman informasi dari ' . getSetting('site_name'))

@section('content')
    <!-- Page Header -->
    <x-page-header title="Halaman Informasi" description="Temukan berbagai informasi penting dan berita terkini dari {{ getSetting('site_name') }}" />

    <!-- Pages List -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($pages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($pages as $page)
                        <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-polri-black mb-3 group-hover:text-polri-primary transition">
                                    {{ $page->title }}
                                </h2>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($page->content), 150) }}
                                </p>
                                <a href="{{ route('pages.show', array_merge(['slug' => $page->slug], request()->query())) }}" class="inline-flex items-center text-polri-primary font-semibold hover:text-polri-secondary transition">
                                    {!! getTemplate('readmore') !!}
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($pages->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $pages->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">📄</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Halaman</h3>
                    <p class="text-gray-500">Silakan kembali lagi nanti untuk informasi terbaru.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
