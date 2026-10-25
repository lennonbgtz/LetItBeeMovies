<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let It Bee Movies — Clean Movie Database</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sunset-navy min-h-screen font-sans overflow-x-hidden">

    {{-- Navbar --}}
    <nav class="bg-sunset-navy border-b border-sunset-sky/30 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 text-sunset-yellow text-2xl font-bold">
                <img src="{{ asset('images/johnny.png') }}" alt="" class="h-9 w-auto">
                <span>Let It Bee Movies</span>
            </a>
            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.index') }}" class="text-sunset-white hover:text-sunset-yellow">Admin</a>
                    @endif
                    <span class="text-sunset-white/80">Hello, {{ auth()->user()->name }}!</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sunset-white hover:text-sunset-yellow">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sunset-white hover:text-sunset-yellow">Log in</a>
                    <a href="{{ route('register') }}" class="bg-sunset-orange hover:bg-sunset-yellow text-sunset-navy font-bold px-4 py-2 rounded-lg transition">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero + Search --}}
    <header class="relative bg-gradient-to-b from-sunset-navy via-sunset-sky/40 to-sunset-navy px-6 py-16">
           <div class="absolute top-0 left-0 w-80 h-80 rounded-full bg-sunset-orange/20 blur-3xl"></div>
           <div class="absolute bottom-0 right-0 w-96 h-80 rounded-full bg-sunset-sky/25 blur-3xl"></div>
           <img src="{{ asset('images/johnny.png') }}" alt="" aria-hidden="true" class="absolute bottom-10 right-16 w-72 -rotate-12 opacity-15 pointer-events-none select-none">
           <img src="{{ asset('images/johnny.png') }}" alt="" aria-hidden="true" class="absolute top-16 left-16 w-56 -scale-x-100 -rotate-12 opacity-15 pointer-events-none select-none">
        <div class="relative max-w-3xl mx-auto text-center">
            <img src="{{ asset('images/johnny.png') }}" alt="Johnny the bee" class="w-24 mx-auto mb-4" style="filter: drop-shadow(0 0 2px #ffffff) drop-shadow(0 0 14px rgba(109, 184, 224, 0.55));">
            <h1 class="text-4xl md:text-5xl font-bold text-sunset-yellow mb-3">
                Clean Movie Database
            </h1>
            <div class="flex items-center justify-center gap-2 mb-8">
                <p class="text-sunset-white/80">Filter movies free from NSK scenes.</p>

                <div class="relative group">
                    <span tabindex="0" class="flex items-center justify-center w-6 h-6 rounded-full border border-sunset-sky/60 text-sunset-sky text-sm font-bold cursor-help">?</span>
                    <div class="absolute left-1/2 -translate-x-1/2 top-8 z-20 w-72 rounded-lg border border-sunset-sky/30 bg-sunset-navy p-3 text-left text-sm text-sunset-white/90 shadow-xl hidden group-hover:block group-focus-within:block">
                        <span class="font-bold text-sunset-yellow">NSK</span> stands for <span class="font-bold">N</span>ude, <span class="font-bold">S</span>ex, and <span class="font-bold">K</span>issing, the three types of scenes this site tracks. Violence, gore, and language are not tracked.
                    </div>
                </div>
            </div>

            <form method="GET" action="/" class="max-w-xl mx-auto">
    <div class="flex gap-2">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search movie title..."
            class="flex-1 rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy placeholder-sunset-navy/50 focus:border-sunset-orange focus:ring-sunset-orange"
        >
        <button type="submit" class="bg-sunset-orange hover:bg-sunset-yellow text-sunset-navy font-bold px-6 rounded-lg transition">
            Search
        </button>
    </div>

    <div class="mt-4 flex flex-wrap justify-center items-center gap-x-5 gap-y-2 text-sunset-white">
        <span class="text-sunset-white/80">Hide movies with:</span>

        @foreach(['nudity' => 'Nudity', 'sex' => 'Sex', 'kissing' => 'Kissing'] as $value => $label)
            <label class="flex items-center gap-2 cursor-pointer">
                <input
                    type="checkbox"
                    name="exclude[]"
                    value="{{ $value }}"
                    @checked(in_array($value, (array) request('exclude', [])))
                    class="rounded border-sunset-sky/50 text-sunset-orange focus:ring-sunset-orange"
                >
                <span>{{ $label }}</span>
            </label>
        @endforeach
    </div>
</form>

        </div>
    </header>

    {{-- Movie Catalog --}}
    <main class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-sunset-yellow mb-6">
            @if(request('search'))
                Results for: "{{ request('search') }}"
            @else
                All Movies
            @endif
        </h2>

        @if($movies->isEmpty())
            <p class="text-sunset-white/70 text-center py-12">No movies found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($movies as $movie)
                    <a href="{{ route('movies.show', $movie) }}"
                       class="block bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-5 hover:border-sunset-yellow transition">

                        <div class="aspect-[2/3] mb-4 overflow-hidden rounded-lg bg-sunset-white/5 flex items-center justify-center">
                            @if($movie->poster_url)
                               <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="{{ $movie->title }} poster" class="w-full h-full object-cover">
                            @else
                               <img src="{{ asset('images/johnny.png') }}" alt="No poster yet" class="w-24 opacity-30">
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-sunset-white mb-1">{{ $movie->title }}</h3>
                        <p class="text-sunset-sky text-sm mb-3">{{ $movie->year }}</p>

                        {{-- Genres --}}
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($movie->genres as $genre)
                                <span class="text-xs bg-sunset-sky/20 text-sunset-sky px-2 py-1 rounded">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Scene warning --}}
                            @if(! $movie->is_reviewed)
                               <p class="text-sunset-sky text-sm">⏳ Not yet reviewed</p>
                            @elseif($movie->scenes->isEmpty())
                            <p class="text-sunset-yellow text-sm font-bold">✅ No NSK scenes</p>
                        @else
                            <p class="text-sunset-orange text-sm">
                                ⚠️ {{ $movie->scenes->count() }} scene(s) recorded
                            </p>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="relative overflow-hidden text-center text-sunset-white/40 text-sm py-16">
    
    <img src="{{ asset('images/johnny.png') }}" alt="" aria-hidden="true" class="absolute -bottom-12 left-10 w-44 scale-x-100 -rotate-6 opacity-10 pointer-events-none select-none">

</body>
</html>