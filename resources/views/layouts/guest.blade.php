<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Let It Bee Movies</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @php
            $heading = request()->routeIs('login') ? 'Welcome back'
                : (request()->routeIs('register') ? 'Create your account' : null);
        @endphp

        <div class="min-h-screen grid grid-cols-2">

            {{-- Left: brand panel --}}
            <div class="relative overflow-hidden flex flex-col items-center justify-center text-center p-12 bg-sunset-navy bg-gradient-to-br from-sunset-orange/40 via-sunset-navy to-sunset-sky/50">
                <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-sunset-yellow/20 blur-3xl"></div>
                <div class="absolute -bottom-32 -right-24 w-96 h-96 rounded-full bg-sunset-sky/25 blur-3xl"></div>

                <div class="relative flex flex-col items-center">
                    <img src="{{ asset('images/johnny.png') }}" alt="Johnny the bee" class="w-36 mb-6" style="filter: drop-shadow(0 0 2px #ffffff) drop-shadow(0 0 14px rgba(109, 184, 224, 0.55));">
                    <h1 class="text-5xl font-bold text-sunset-yellow mb-4">Let It Bee Movies</h1>
                    <p class="text-sunset-white/80 text-lg max-w-sm">Filter movies free from nudity, sex, or kissing scenes.</p>

                    <ul class="mt-10 space-y-3 w-full max-w-sm text-left text-sunset-white/90">
                        <li class="flex items-center gap-3 bg-sunset-white/10 border border-sunset-sky/30 rounded-xl px-4 py-3">
                            <span class="text-sunset-yellow font-bold">✓</span>
                            <span>Scenes recorded and checked by admins</span>
                        </li>
                        <li class="flex items-center gap-3 bg-sunset-white/10 border border-sunset-sky/30 rounded-xl px-4 py-3">
                            <span class="text-sunset-yellow font-bold">✓</span>
                            <span>Hide nudity, sex, or kissing in one click</span>
                        </li>
                        <li class="flex items-center gap-3 bg-sunset-white/10 border border-sunset-sky/30 rounded-xl px-4 py-3">
                            <span class="text-sunset-yellow font-bold">✓</span>
                            <span>Unchecked movies never slip through the filter</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Right: form --}}
            <div class="relative overflow-hidden flex items-center justify-center bg-white px-12 py-12">
                <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-sunset-yellow/30 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-16 w-80 h-80 rounded-full bg-sunset-sky/30 blur-3xl"></div>
                <img src="{{ asset('images/johnny.png') }}" alt="" aria-hidden="true" class="absolute -bottom-20 -right-24 w-[34rem] -rotate-12 opacity-10 pointer-events-none select-none">

                <div class="relative w-full max-w-sm">
                    @if($heading)
                        <h2 class="text-3xl font-bold text-sunset-navy mb-2">{{ $heading }}</h2>
                        <p class="text-gray-500 mb-8">Rate movies and leave reviews for the community.</p>
                    @endif

                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>