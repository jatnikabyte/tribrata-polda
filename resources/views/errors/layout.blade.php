<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-normal text-sm leading-normal bg-default-50 text-default-600 min-h-screen flex items-center justify-center">

    <div class="max-w-lg mx-auto text-center px-6 py-12">
        <div class="mb-8 flex justify-center">
             {{-- Icon or Illustration Placeholder --}}
             <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center text-primary mb-6 animate-bounce">
                @yield('icon')
             </div>
        </div>

        <h1 class="text-6xl font-bold text-primary mb-4 tracking-tighter">@yield('code')</h1>
        
        <h2 class="text-2xl font-semibold text-default-900 mb-4">@yield('message')</h2>
        
        <p class="text-default-500 mb-8 max-w-md mx-auto">
            @yield('description')
        </p>

        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200 shadow-lg shadow-primary/30">
            <span class="icon-[solar--home-smile-bold] w-5 h-5 me-2"></span>
            Kembali ke Beranda
        </a>
    </div>

</body>

</html>
