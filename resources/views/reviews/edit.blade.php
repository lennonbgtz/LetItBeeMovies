<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review — Let It Bee Movies</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .rating-input:checked + .rating-box {
            background-color: #EED300;
            color: #223F61;
            border-color: #EED300;
        }
    </style>
</head>
<body class="bg-sunset-navy min-h-screen font-sans text-sunset-white">
    @include('partials.johnny-bg')

    <nav class="bg-sunset-navy border-b border-sunset-sky/30 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('movies.index') }}" class="flex items-center gap-2 text-sunset-yellow text-2xl font-bold">
                <img src="{{ asset('images/johnny.png') }}" alt="" class="h-9 w-auto">
                <span>Let It Bee Movies</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sunset-white hover:text-sunset-yellow">Log out</button>
            </form>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-6 py-12">
        <a href="{{ route('movies.show', $movie) }}" class="text-sunset-sky hover:text-sunset-yellow text-sm mb-6 inline-block">← Back to {{ $movie->title }}</a>

        <h1 class="text-3xl font-bold text-sunset-yellow mb-6">Edit your review</h1>

        <form method="POST" action="{{ route('reviews.update', $review) }}" class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sunset-sky text-sm mb-2">How clean is this movie?</label>
                <div class="flex gap-3">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" required class="sr-only rating-input"
                                @checked((int) old('rating', $review->rating) === $i)>
                            <span class="rating-box flex w-12 h-12 rounded-lg border-2 border-sunset-sky/50 bg-sunset-navy text-sunset-white items-center justify-center font-bold text-lg transition hover:border-sunset-yellow">
                                {{ $i }}
                            </span>
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="comment" class="block text-sunset-sky text-sm mb-2">Comment (optional)</label>
                <textarea name="comment" id="comment" rows="3" maxlength="1000"
                    class="w-full rounded-lg border-sunset-sky/50 bg-sunset-white text-sunset-navy focus:border-sunset-orange focus:ring-sunset-orange">{{ old('comment', $review->comment) }}</textarea>
                @error('comment')
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