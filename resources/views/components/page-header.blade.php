@props([
    'title' => '',
    'description' => null,
    'breadcrumbs' => [],
    'py' => 'py-10 md:py-12',
    'follower' => '0',
    'views' => '0',
    'buttonFollow' => false,
])

<section class="relative bg-polri-secondary {{ $py }} overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @if (count($breadcrumbs) > 0)
            <nav class="flex items-center space-x-2 text-sm text-white/70 mb-6">
                @foreach ($breadcrumbs as $index => $crumb)
                    @if ($crumb['url'])
                        <a href="{{ $crumb['url'] }}" class="hover:text-white transition">{{ $crumb['title'] }}</a>
                    @else
                        <span class="text-white">{{ $crumb['title'] }} </span>
                    @endif
                    @if ($index < count($breadcrumbs) - 1)
                        <span>/</span>
                    @endif
                @endforeach
            </nav>
        @endif

        <div class="{{ count($breadcrumbs) > 0 ? '' : 'text-center' }}">
            <div class="flex justify-center items-center w-full">
                <h1 class="text-2xl md:text-3xl font-black mb-2 text-white tracking-tight me-2">
                    {{ Str::title($title) }}
                </h1>
                @if (!request()->cookie('subscriber_email') && request()->is('tabloid'))
                    <button onclick="openSubscribeModal()" class="cursor-pointer inline-block px-4 py-1 bg-transparent border-2 border-polri-gold text-polri-gold font-black rounded-lg hover:bg-polri-gold hover:text-polri-black transition-all duration-300 shadow-lg hover:shadow-polri-gold/30 uppercase tracking-widest text-sm transform hover:scale-105">Follow</button>
                @endif
            </div>
            @if ($follower > 0)
                <div class="flex justify-center items-center w-full">
                    <p class="text-white/80 text-sm flex items-center justify-center gap-1 me-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white/80" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 3-1.79 3-4s-1.34-4-3-4-3 1.79-3 4 1.34 4 3 4zm-8 0c1.66 0 3-1.79 3-4S9.66 3 8 3 5 4.79 5 7s1.34 4 3 4zm0 2c-2.33 0-7 1.17-7 3.5V20h14v-3.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V20h6v-3.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        <span>{{ $follower }} Followers</span>
                    </p>
                    <p class="text-white/80 text-sm flex items-center justify-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white/80" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                        </svg>
                        <span>{{ $views }} Views</span>
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
