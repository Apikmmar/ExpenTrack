<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            // Dark mode toggle functionality - default to light mode
            if (localStorage.getItem('color-theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                // Ensure light mode is set as default
                if (!localStorage.getItem('color-theme')) {
                    localStorage.setItem('color-theme', 'light');
                }
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <script>
            // Dark mode toggle functionality
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleMobileBtn = document.getElementById('theme-toggle-mobile');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
            const themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('color-theme') === 'dark') {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleLightIconMobile.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleDarkIconMobile.classList.remove('hidden');
            }

            function toggleTheme() {
                // Toggle icons
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');
                themeToggleDarkIconMobile.classList.toggle('hidden');
                themeToggleLightIconMobile.classList.toggle('hidden');

                // Toggle theme
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            }

            themeToggleBtn.addEventListener('click', toggleTheme);
            themeToggleMobileBtn.addEventListener('click', toggleTheme);
        </script>
    </body>
</html>
