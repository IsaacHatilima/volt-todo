<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ ($title ? "$title | " : null) . config('app.name') }}</title> --}}
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('light');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>

    </head>
    <body class="font-sans antialiased text-gray-900 bg-light-background dark:bg-dark-background">
        <div class="flex flex-col items-center min-h-screen md:pt-6 justify-center">
            <div class="w-full px-6 py-4 md:mt-6 sm:max-w-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
