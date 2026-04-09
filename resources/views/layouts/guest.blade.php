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
    </head>
    <body class="font-sans antialiased bg-slate-950 text-gray-100">
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
            <!-- Back to Home Button -->
            <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-300 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>

            <!-- Logo -->
            <div class="mb-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3 justify-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full shadow-lg shadow-blue-500/50"></div>
                    <span class="font-bold text-2xl text-white">AI Tools Hub</span>
                </a>
            </div>

            <!-- Auth Form Container -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-slate-900 border border-slate-700 shadow-xl rounded-xl">
                {{ $slot }}
            </div>

            <!-- Footer Link -->
            <div class="mt-8 text-center text-xs text-gray-500">
                <p>Discover & Master AI Tools • 2026</p>
            </div>
        </div>
    </body>
</html>
