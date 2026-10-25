<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scenes on {{ $movie->title }} — Let It Bee Movies</title>
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
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-12">
        <a href="{{ route('admin.index') }}" class="text-sunset-sky hover:text-sunset-yellow text-sm mb-6 inline-block">← Back to movie list</a>

        <h1 class="text-3xl font-bold text-sunset-yellow mb-6">Scenes: {{ $movie->title }}</h1>

        @if(session('success'))
            <div class="bg-sunset-yellow/20 border border-sunset-yellow text-sunset-yellow px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <section class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 mb-8">
            <h2 class="text-xl font-bold text-sunset-yellow mb-4">Recorded scenes</h2>

            @forelse($movie->scenes as $scene)
                <div class="flex items-start justify-between gap-4 border-l-4 border-sunset-orange pl-4 mb-4">
                    <div>
                        <span class="font-bold text-sunset-orange uppercase">{{ $scene->type }}</span>
                        <span class="text-xs bg-sunset-orange/20 text-sunset-orange px-2 py-0.5 rounded ml-2">
                            Intensity {{ $scene->intensity }}/5
                        </span>
                        @if($scene->description)
                            <p class="text-sunset-white/70 text-sm mt-1">{{ $scene->description }}</p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.scenes.destroy', [$movie, $scene]) }}"
                          onsubmit="return confirm('Delete this scene?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-sunset-orange hover:text-sunset-yellow underline">Delete</button>
                        <a href="{{ route('admin.scenes.edit', [$movie, $scene]) }}" class="text-sm text-sunset-sky hover:text-sunset-yellow underline ml-3">Edit</a>
                    </form>
                </div>
            @empty
                <p class="text-sunset-white/60">No scene recorded.</p>
            @endforelse
        </section>

        <section class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6">
            <h2 class="text-xl font-bold text-sunset-yellow mb-4">Add scene</h2>

            <form method="POST" action="{{ route('admin.scenes.store', $movie) }}" class="space-y-5">
                @csrf

                <div>
                    <label for="type" class="block text-sunset-sky text-sm mb-2">Scene type</label>
                    <select name="type" id="type" required
                        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
                        <option value="kissing" @selected(old('type') === 'kissing')>Kissing</option>
                        <option value="nudity" @selected(old('type') === 'nudity')>Nudity</option>
                        <option value="sex" @selected(old('type') === 'sex')>Sex</option>
                    </select>
                    @error('type')
                        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="intensity" class="block text-sunset-sky text-sm mb-2">Intensity (1 = light, 5 = very explicit)</label>
                    <input type="number" name="intensity" id="intensity" min="1" max="5" value="{{ old('intensity', 1) }}" required
                        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
                    @error('intensity')
                        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sunset-sky text-sm mb-2">Notes (optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-sunset-orange hover:bg-sunset-yellow text-sunset-navy font-bold px-6 py-2 rounded-lg transition">
                    Save Scene
                </button>
            </form>
        </section>
    </main>

</body>
</html>