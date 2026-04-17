<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/settings/' . getSetting('app_favicon')) }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="antialiased overflow-x-hidden font-normal text-sm leading-normal bg-default-50 text-default-600 min-h-screen">

    <div class="wrapper flex flex-col min-h-screen">
        <!-- Sidebar -->
        <x-layouts.admin.sidebar />

        <!-- Page Content -->
        <div class="page-content flex flex-col flex-grow h-screen lg:ms-sidenav transition-all">
            <!-- Navbar -->
            <x-layouts.admin.navbar :title="$title ?? ''" />

            <!-- Main Content -->
            <main class="flex-grow w-full px-6 py-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-layouts.admin.footer />
        </div>
    </div>

    @livewireScripts
    @filemanagerScripts
    @stack('scripts')
</body>

</html>
