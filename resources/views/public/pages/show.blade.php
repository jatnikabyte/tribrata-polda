@extends('layouts.public')

@section('title', $page->title . ' - ' . getSetting('site_name'))
@section('description', Str::limit(strip_tags($page->content), 160))

@section('content')
    <!-- Page Header -->
    <x-page-header :title="$page->title" :breadcrumbs="[['title' => 'Beranda', 'url' => route('home', request()->query())], ['title' => 'Halaman', 'url' => route('pages.index', request()->query())], ['title' => $page->title, 'url' => null]]" />

    <!-- Page Content -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <div class="prose prose-lg max-w-none">
                    {!! $page->content !!}
                </div>

                @if ($page->value)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-polri-black mb-4">{!! getTemplate('page_section_back_additional') !!} </h3>
                        <p class="text-gray-600">{{ $page->value }}</p>
                    </div>
                @endif
            </article>

            <!-- Back Button -->
            <div class="mt-8">
                <a href="{{ route('pages.index', request()->query()) }}" class="inline-flex items-center text-polri-primary font-semibold hover:text-polri-secondary transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {!! getTemplate('page_section_back_list_title') !!}
                </a>
            </div>
        </div>
    </section>
@endsection
