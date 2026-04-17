@extends('layouts.public')

@section('title', 'Video - ' . getSetting('site_name'))
@section('description', 'Koleksi video dari ' . getSetting('site_name'))

@section('content')
    <!-- Video Modal -->
    <x-video-modal />
    <!-- Video Header -->
    <x-page-header title="Video Kegiatan" description="Saksikan berbagai video dokumentasi dan kegiatan dari {{ getSetting('site_name') }}" />

    <!-- Videos List -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($videos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($videos as $video)
                        <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                            <!-- Video Thumbnail -->
                            <div class="relative aspect-video bg-gray-900 overflow-hidden cursor-pointer" onclick="openVideo('{{ $video->video_link }}')">
                                @if ($video->cover)
                                    <img src="{{ asset('storage/' . $video->cover) }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-polri-primary to-polri-secondary flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white/50" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5vibl 8l7-7-7 7"></path>
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Play Button Overlay -->
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/50 transition">
                                    <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-polri-primary ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Badge -->
                                @if ($video->badge)
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-white" style="background-color: {{ $video->badge_color ?? '#dc2626' }}">
                                            {{ $video->badge }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Video Info -->
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-polri-black mb-3 group-hover:text-polri-primary transition line-clamp-2">
                                    {{ $video->title }}
                                </h2>
                                @if ($video->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {!! Str::limit(strip_tags($video->description), 100) !!}
                                    </p>
                                @endif
                                <a href="{{ route('videos.show', array_merge(['slug' => $video->slug], request()->query())) }}" class="inline-flex items-center text-polri-primary font-semibold hover:text-polri-secondary transition">
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
                @if ($videos->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $videos->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">🎬</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Video</h3>
                    <p class="text-gray-500">Silakan kembali lagi nanti untuk video terbaru.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
