@extends('layouts.public')

@section('title', $video->title . ' - Video - ' . getSetting('site_name'))
@section('description', Str::limit($video->description ?? '', 160))

@section('content')
    <!-- Video Modal -->
    <x-video-modal />

    <!-- Video Header -->
    <x-page-header :title="$video->title" :breadcrumbs="[['title' => 'Beranda', 'url' => route('home', request()->query())], ['title' => 'Video', 'url' => route('videos.index', request()->query())]]" />

    <!-- Video Player -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Video Cover -->
            <div data-open-video="{{ $video->video_link }}" class="bg-black rounded-2xl overflow-hidden shadow-2xl mb-8 cursor-pointer group hover:shadow-polri-gold/30 transition-all duration-300">
                <div class="aspect-video relative">
                    @if ($video->cover)
                        <img src="{{ asset('storage/' . $video->cover) }}" alt="{{ $video->title }}" class="w-full h-full object-cover group">
                    @else
                        <div class="w-full h-full bg-linear-to-br from-polri-primary to-polri-secondary flex items-center justify-center">
                            <svg class="w-20 h-20 text-white/50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/50 transition">
                        <div class="w-20 h-20 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border-2 border-polri-gold/50 shadow-2xl">
                            <div class="w-14 h-14 bg-polri-gold rounded-full flex items-center justify-center pl-1 shadow-2xl">
                                <svg class="w-6 h-6 text-polri-black" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Description -->
            <article class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                @if ($video->description)
                    <div class="prose prose-lg max-w-none">
                        <h3 class="text-2xl font-bold text-polri-black mb-4">{!! getTemplate('video_section_detail_title') !!}</h3>
                        <p class="text-gray-700 leading-relaxed">{!! $video->description !!}</p>
                    </div>
                @endif

                <!-- Video Meta -->
                <div class="mt-8 pt-8 border-t border-gray-200 flex flex-wrap gap-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {!! getTemplate('created_titile') !!}: {{ $video->created_at->format('d F Y') }}
                    </span>
                    @if ($video->updated_at != $video->created_at)
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {!! getTemplate('updated_titile') !!}: {{ $video->updated_at->format('d F Y') }}
                        </span>
                    @endif
                </div>
            </article>

            <!-- Back Button -->
            <div class="mt-8">
                <a href="{{ route('videos.index', request()->query()) }}" class="inline-flex items-center text-polri-primary font-semibold hover:text-polri-secondary transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {!! getTemplate('video_section_back_list_title') !!}
                </a>
            </div>
        </div>
    </section>
@endsection
