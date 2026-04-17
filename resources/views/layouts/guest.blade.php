<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Login') - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white min-h-screen">

    {{ $slot ?? '' }}
    @yield('content')

</body>

</html>
