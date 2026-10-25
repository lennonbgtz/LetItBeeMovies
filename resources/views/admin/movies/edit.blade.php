<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie — Let It Bee Movies</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sunset-navy min-h-screen font-sans text-sunset-white">
       @include('partials.johnny-bg')

    <nav class="bg-sunset-navy border-b border-sunset-sky/30 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 text-sunset-yellow text-2xl font-bold">
                <img src="{{ asset('images/johnny.png') }}" alt="" class="h-9 w-auto">
                <span>Let It Bee Movies</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="/" class="text-sunset-white hover:text-sunset-yellow">View site</a> <a href="{{ route('admin.index') }}" class="text-sunset-sky hover:text-sunset-yellow">Admin</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sunset-white hover:text-sunset-yellow">Log out</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-6 py-12">
        <a href="{{ route('admin.index') }}" class="text-sunset-sky hover:text-sunset-yellow text-sm mb-6 inline-block">← Back to movie list</a>

        <h1 class="text-3xl font-bold text-sunset-yellow mb-6">Edit Movie</h1>

        <form method="POST" action="{{ route('admin.movies.update', $movie) }}" enctype="multipart/form-data" class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sunset-sky text-sm mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" required
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
                @error('title')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="year" class="block text-sunset-sky text-sm mb-2">Year</label>
                <input type="number" name="year" id="year" value="{{ old('year', $movie->year) }}" required
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
                @error('year')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="synopsis" class="block text-sunset-sky text-sm mb-2">Synopsis (optional)</label>
                <textarea name="synopsis" id="synopsis" rows="4"
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">{{ old('synopsis', $movie->synopsis) }}</textarea>
                @error('synopsis')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <span class="block text-sunset-sky text-sm mb-2">Genre</span>
                <div class="flex flex-wrap gap-x-5 gap-y-2">
                    @foreach($genres as $genre)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                @checked(in_array($genre->id, old('genres', $movie->genres->pluck('id')->all())))
                                class="rounded border-sunset-sky/50 text-sunset-orange focus:ring-sunset-orange">
                            <span>{{ $genre->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
    <label for="director" class="block text-sunset-sky text-sm mb-2">Director (optional)</label>
    <input type="text" name="director" id="director" value="{{ old('director', $movie->director) }}"
        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
    @error('director')
        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="runtime" class="block text-sunset-sky text-sm mb-2">Runtime in minutes (optional)</label>
    <input type="number" name="runtime" id="runtime" min="1" max="600" value="{{ old('runtime', $movie->runtime) }}"
        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
    @error('runtime')
        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="cast_members" class="block text-sunset-sky text-sm mb-2">Cast (optional, separate names with commas)</label>
    <textarea name="cast_members" id="cast_members" rows="2"
        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">{{ old('cast_members', $movie->cast_members) }}</textarea>
    @error('cast_members')
        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

            <div>
    <label for="trailer_url" class="block text-sunset-sky text-sm mb-2">YouTube trailer link (optional)</label>
    <input type="url" name="trailer_url" id="trailer_url" value="{{ old('trailer_url', $movie->trailer_url) }}" placeholder="https://www.youtube.com/watch?v=..."
        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
    @error('trailer_url')
        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

            <div>
                <span class="block text-sunset-sky text-sm mb-2">Poster (optional, max 2 MB)</span>

                @if($movie->poster_url)
                    <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="Current poster" class="w-40 rounded-lg mb-3">
                @endif

                <input type="file" name="poster" accept="image/*"
                    class="block w-full text-sunset-white/80 text-sm">
                @error('poster')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-sunset-orange hover:bg-sunset-yellow text-sunset-navy font-bold px-6 py-2 rounded-lg transition">
                Save Changes
            </button>
        </form>
    </main>

</body>
</html>