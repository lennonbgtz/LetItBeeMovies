<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scene — Let It Bee Movies</title>
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
                <a href="/" class="text-sunset-white hover:text-sunset-yellow">View site</a>
                <a href="{{ route('admin.index') }}" class="text-sunset-sky hover:text-sunset-yellow">Admin</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sunset-white hover:text-sunset-yellow">Log out</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-12">
        <a href="{{ route('admin.scenes.index', $movie) }}" class="text-sunset-sky hover:text-sunset-yellow text-sm mb-6 inline-block">← Back to scenes</a>

        <h1 class="text-3xl font-bold text-sunset-yellow mb-6">Edit scene: {{ $movie->title }}</h1>

        <form method="POST" action="{{ route('admin.scenes.update', [$movie, $scene]) }}" class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="type" class="block text-sunset-sky text-sm mb-2">Scene type</label>
                <select name="type" id="type" required
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
                    @foreach(['nudity' => 'Nudity', 'sex' => 'Sex', 'kissing' => 'Kissing'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $scene->type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="intensity" class="block text-sunset-sky text-sm mb-2">Intensity (1 = light, 5 = very explicit)</label>
                <input type="number" name="intensity" id="intensity" min="1" max="5" value="{{ old('intensity', $scene->intensity) }}" required
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">
                @error('intensity')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sunset-sky text-sm mb-2">Description (optional)</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">{{ old('description', $scene->description) }}</textarea>
                @error('description')
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