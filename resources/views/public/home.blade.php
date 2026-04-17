@extends('layouts.public')
@section('content')
    <!-- ================= TABLOID SLIDER SECTION ================= -->
    <section class="relative pt-12 pb-12 md:pt-16 md:pb-24 sm:pt-12 sm:pb-20 bg-polri-black diagonal-stripes">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 hero-pattern"></div>
            <div class="absolute top-0 right-0 w-150 h-150 bg-polri-primary/20 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-100 h-100 bg-polri-secondary/20 rounded-full blur-[100px] translate-y-1/3 -translate-x-1/3"></div>
            <div class="absolute top-1/2 left-1/2 w-75 h-75 bg-polri-gold/10 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2"></div>
        </div>

        <!-- Section Title -->
        <div class="relative max-w-350 mx-auto px-4 z-10 mb-8">
            <div class="flex items-center justify-center gap-4">
                <div class="h-0.75 w-16 bg-linear-to-r from-transparent to-polri-gold"></div>
                <div class="text-center">
                    <h2 class="text-lg md:text-4xl font-black text-white tracking-wider uppercase">{!! getTemplate('tabloid_section_heading') !!}</h2>
                    <p class="text-polri-gold text-[10px] sm:text-sm font-bold tracking-widest mt-1">{!! getTemplate('tabloid_section_subheading') !!}</p>
                </div>
                <div class="h-0.75 w-16 bg-linear-to-l from-transparent to-polri-gold"></div>
            </div>
        </div>

        <div class="relative max-w-350 mx-auto px-4 z-10">

            <!-- Hero Swiper -->
            <div class="swiper heroSwiper pb-20! pt-1! lg:pb-24! lg:pt-10!">
                <div class="swiper-wrapper">

                    <!-- Slide -->
                    @foreach ($tabloids as $item)
                        <div class="swiper-slide">
                            <div class="relative group glass-reflection magazine-shadow rounded-r-lg rounded-l-sm bg-white transform transition-transform duration-500 hover:-translate-y-6 hover:scale-[1.03]">
                                <img src="{{ asset('storage/' . $item->cover) }}" class=" w-full h-full object-cover rounded-r-lg rounded-l-sm">
                                <!-- Spine Effect -->
                                <div class="absolute top-0 bottom-0 left-0 w-0.75 bg-linear-to-b from-white/50 to-white/10 z-20"></div>
                                <div class="absolute top-0 bottom-0 left-0.75 w-px bg-black/20 z-20"></div>

                                <!-- Badge -->
                                <div class="absolute top-4 right-4 bg-polri-primary text-white px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded z-30 shadow-lg">
                                    Edisi {{ $item->edition_of }}
                                </div>

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-linear-to-t from-polri-black via-polri-black/90 to-polri-primary/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-end p-6 text-center z-30 rounded-r-lg rounded-l-sm">
                                    <h3 class="font-sans text-white font-black text-2xl mb-2 translate-y-6 group-hover:translate-y-0 transition duration-500 delay-100 tracking-wide">
                                        {{ $item->title }}</h3>
                                    @if (request()->cookie('subscriber_email'))
                                        <div data-track-flipbook="{{ $item->encryptedId }}" source="{{ asset($item->file_pdf) }}" class="_df_button">
                                            <button class="cursor-pointer px-10 py-4 bg-polri-gold text-polri-black font-black rounded-lg transform scale-90 group-hover:scale-100 transition duration-300 hover:bg-white shadow-2xl uppercase tracking-wider text-sm">
                                                Baca Sekarang
                                            </button>
                                        </div>
                                    @else
                                        <button onclick="openSubscribeModal()" class="cursor-pointer px-10 py-4 bg-polri-gold text-polri-black font-black rounded-lg transform scale-90 group-hover:scale-100 transition duration-300 hover:bg-white shadow-2xl uppercase tracking-wider text-sm">
                                            Baca Sekarang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-pagination bottom-0!"></div>
            </div>

        </div>
    </section>


    <!-- ================= SPEECH SECTION ================= -->
    <section id="speech-of-head" class="h-auto md:h-87.5 flex items-center bg-linear-to-r from-polri-primary via-polri-primary to-polri-secondary relative z-20 overflow-visible py-12 md:py-0">
        @foreach ($speeches as $item)
            <!-- Decorative elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-0 w-full h-2 bg-polri-gold"></div>
                <div class="absolute bottom-0 left-0 w-full h-2 bg-polri-gold"></div>
                <div class="absolute top-1/2 left-0 w-32 h-32 bg-polri-gold/10 rounded-full -translate-y-1/2 -translate-x-1/2 blur-2xl"></div>
                <div class="absolute top-1/2 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

                <div class="flex flex-col md:flex-row items-center justify-between">

                    <!-- Text Content (Left) -->
                    <div class="w-full md:w-7/12 order-2 md:order-1 text-center md:text-left mt-4 md:mt-0">
                        <div class="inline-block px-4 py-1 bg-polri-gold text-polri-black rounded-full font-black text-xs mb-3 tracking-widest uppercase shadow-lg">
                            {{ $item->badge }}
                        </div>
                        <h2 class="text-2xl md:text-4xl font-black text-white font-serif mb-3 leading-tight text-shadow-strong">
                            {{ $item->title }}<br>
                            <span class="text-polri-gold text-xl md:text-3xl"> {{ $item->subtitle }}</span>
                        </h2>

                        <div class="relative py-3 strong-border pl-4">
                            <p class="text-lg md:text-xl text-white font-semibold italic relative z-10 leading-relaxed">
                                "{{ $item->description }}"
                            </p>
                        </div>

                        <div class="mt-4 flex items-center gap-3 justify-center md:justify-start">
                            <div class="w-16 h-1 bg-polri-gold rounded-full"></div>
                            <div class="w-8 h-1 bg-white/50 rounded-full"></div>
                            <div class="w-4 h-1 bg-white/30 rounded-full"></div>
                        </div>
                    </div>

                    <!-- Image (Right) -->
                    <div class="w-full md:w-5/12 order-1 md:order-2 flex flex-col items-center relative mb-4 md:mb-0 pointer-events-none md:pointer-events-auto">
                        <div class="relative md:-mt-24 lg:-mt-32 z-30 group">
                            <!-- Decorative ring behind image -->
                            <div class="absolute -inset-4 bg-polri-gold/20 rounded-full blur-xl"></div>
                            <div class="absolute -inset-2 border-4 border-polri-gold/30 rounded-full"></div>

                            <!-- Image -->
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Kapolda Banten" class="relative w-56 md:w-72 lg:w-80 drop-shadow-2xl object-cover transform transition duration-500 hover:scale-[1.03] filter brightness-110 rounded-full">
                        </div>

                        <!-- Name & Title with Command Style -->
                        <div class="flex flex-col items-center -mt-8 md:-mt-10 space-y-2 relative z-40">
                            <!-- Name Badge -->
                            <div class="relative bg-polri-gold shadow-2xl transform -skew-x-6">
                                <div class="absolute inset-0 bg-polri-gold/50 transform skew-x-6 translate-x-1 translate-y-1"></div>
                                <h3 class="relative px-8 py-3 text-xl md:text-2xl font-black text-polri-black font-serif transform skew-x-6 whitespace-nowrap tracking-wide">
                                    {{ $item->name }}
                                </h3>
                            </div>

                            <!-- Title Badge -->
                            <div class="relative bg-polri-black shadow-xl transform -skew-x-6 border-2 border-polri-gold/50">
                                <p class="px-6 py-2 text-white font-bold tracking-widest uppercase text-xs md:text-sm transform skew-x-6 whitespace-nowrap">
                                    {{ $item->jobtitle }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </section>

    <!-- ================= VIDEO SECTION ================= -->
    <section id="video" class="py-24 bg-polri-black relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 diagonal-stripes opacity-50"></div>
        <div class="absolute top-0 left-0 w-full h-1 bg-linear-to-r from-polri-primary via-polri-gold to-polri-secondary"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <div class="inline-block px-6 py-2 bg-polri-primary/20 border border-polri-primary/50 rounded-full mb-4">
                    <span class="text-polri-gold text-sm font-bold tracking-widest uppercase">{!! getTemplate('video_section_badge') !!}</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-white font-sans mb-4 tracking-tight">{!! getTemplate('video_section_heading_1') !!} <span class="text-polri-gold">{!! getTemplate('video_section_heading_2') !!}</span></h2>
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="h-0.75 w-20 bg-linear-to-r from-transparent to-polri-gold"></div>
                    <div class="w-3 h-3 bg-polri-gold rotate-45"></div>
                    <div class="h-0.75 w-20 bg-linear-to-l from-transparent to-polri-gold"></div>
                </div>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto text-lg">{!! getTemplate('video_section_subheading') !!}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if ($videos->count() > 0)
                    @foreach ($videos as $video)
                        <div class="group bg-linear-to-b from-gray-900 to-polri-black rounded-2xl shadow-2xl hover:shadow-polri-primary/30 transition-all duration-500 overflow-hidden border border-gray-800 hover:border-polri-gold/50 transform hover:-translate-y-2">
                            <div class="relative overflow-hidden aspect-video cursor-pointer" data-open-video="{{ $video->video_link }}">
                                <img src="{{ asset('storage/' . $video->cover) }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div class="absolute inset-0 bg-linear-to-t from-polri-black via-polri-black/50 to-transparent group-hover:from-polri-primary/80 group-hover:via-polri-primary/40 transition duration-500 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-polri-gold/20 backdrop-blur-md rounded-full flex items-center justify-center group-hover:scale-110 transition duration-500 border-2 border-polri-gold/50 shadow-2xl">
                                        <div class="w-14 h-14 bg-polri-gold rounded-full flex items-center justify-center pl-1 shadow-2xl">
                                            <svg class="w-6 h-6 text-polri-black" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <a href="{{ route('videos.show', array_merge(['slug' => $video->slug], request()->query())) }}">
                                    <div class="flex items-center gap-3 mb-4">
                                        @if ($video->badge)
                                            <span class="px-3 py-1 bg-polri-primary text-white text-xs font-black rounded uppercase tracking-wider">{{ $video->badge }}</span>
                                        @else
                                            <span class="px-3 py-1 bg-polri-primary text-white text-xs font-black rounded uppercase tracking-wider">Video</span>
                                        @endif
                                        <span class="text-xs text-gray-500 font-semibold">{{ $video->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="font-black text-white text-xl group-hover:text-polri-gold transition line-clamp-2 tracking-wide">
                                        {{ $video->title }}
                                    </h3>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-400 text-lg">Belum ada video tersedia</p>
                    </div>
                @endif

                <div class="col-span-full text-center mt-14">
                    <a href="{{ route('videos.index', request()->query()) }}" class="inline-block px-12 py-4 bg-transparent border-2 border-polri-gold text-polri-gold font-black rounded-lg hover:bg-polri-gold hover:text-polri-black transition-all duration-300 shadow-lg hover:shadow-polri-gold/30 uppercase tracking-widest text-sm transform hover:scale-105">
                        Lihat Semua Video
                    </a>
                </div>
            </div>
    </section>

    <!-- ================= VIDEO MODAL ================= -->
    <x-video-modal />
    @if (!request()->cookie('subscriber_email'))
        <x-subscribe-modal />
    @endif

@endsection
