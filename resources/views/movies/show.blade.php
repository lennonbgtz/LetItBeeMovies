<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} — Let It Bee Movies</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    .rating-input:checked + .rating-box {
        background-color: #F0D000;
        color: #1F3A5F;
        border-color: #F0D000;
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
            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.index') }}" class="text-sunset-white hover:text-sunset-yellow">Admin</a>
                    @endif
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

    <main class="max-w-4xl mx-auto px-6 py-12">

        <a href="{{ route('movies.index') }}" class="text-sunset-sky hover:text-sunset-yellow text-sm mb-6 inline-block">
            ← Back to catalog
        </a>

        <div class="flex flex-col sm:flex-row gap-8 mb-8">
    <div class="w-48 shrink-0">
        @if($movie->poster_url)
            <img src="{{ asset('storage/' . $movie->poster_url) }}" alt="{{ $movie->title }} poster" class="w-full rounded-xl shadow-xl">
        @else
            <div class="aspect-[2/3] rounded-xl bg-sunset-white/5 border border-sunset-sky/30 flex items-center justify-center">
                <img src="{{ asset('images/johnny.png') }}" alt="No poster yet" class="w-24 opacity-30">
            </div>
        @endif
    </div>

    <div>
        <h1 class="text-4xl font-bold text-sunset-yellow mb-2">{{ $movie->title }}</h1>
        <p class="text-sunset-sky mb-4">{{ $movie->year }}</p>

        <div class="flex flex-wrap gap-2 mb-6">
            @foreach($movie->genres as $genre)
                <span class="text-sm bg-sunset-sky/20 text-sunset-sky px-3 py-1 rounded">
                    {{ $genre->name }}
                </span>
            @endforeach
        </div>

        @if($movie->synopsis)
            <p class="text-sunset-white/80 leading-relaxed">{{ $movie->synopsis }}</p>
        @endif

        @if($movie->director || $movie->runtime || $movie->cast_members)
    <dl class="mt-6 space-y-2 text-sm">
        @if($movie->director)
            <div class="flex gap-3">
                <dt class="w-20 shrink-0 text-sunset-sky">Director</dt>
                <dd class="text-sunset-white/90">{{ $movie->director }}</dd>
            </div>
        @endif
        @if($movie->runtime)
            <div class="flex gap-3">
                <dt class="w-20 shrink-0 text-sunset-sky">Runtime</dt>
                <dd class="text-sunset-white/90">{{ $movie->runtime }} min</dd>
            </div>
        @endif
        @if($movie->cast_members)
            <div class="flex gap-3">
                <dt class="w-20 shrink-0 text-sunset-sky">Cast</dt>
                <dd class="text-sunset-white/90">{{ $movie->cast_members }}</dd>
            </div>
        @endif
    </dl>
@endif
    </div>
</div>

        @if($movie->trailerEmbedUrl())
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-sunset-yellow mb-4">Trailer</h2>
                <div class="aspect-video rounded-xl overflow-hidden border border-sunset-sky/30 shadow-xl">
                    <iframe
                        src="{{ $movie->trailerEmbedUrl() }}"
                        title="{{ $movie->title }} trailer"
                        class="w-full h-full"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                </div>
            </section>
        @endif

        <section class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 mb-8">
            <div class="flex items-center gap-3 mb-4">
                <h2 class="text-2xl font-bold text-sunset-yellow">NSK Scenes</h2>

                <div class="relative group">
                    <span tabindex="0" class="flex items-center justify-center w-6 h-6 rounded-full border border-sunset-sky/60 text-sunset-sky text-sm font-bold cursor-help">?</span>
                    <div class="absolute left-0 top-8 z-10 w-72 rounded-lg border border-sunset-sky/30 bg-sunset-navy p-3 text-sm text-sunset-white/90 shadow-xl hidden group-hover:block group-focus-within:block">
                        <span class="font-bold text-sunset-yellow">NSK</span> stands for <span class="font-bold">N</span>ude, <span class="font-bold">S</span>ex, and <span class="font-bold">K</span>issing, the three types of scenes this site tracks. Violence, gore, and language are not tracked.
                    </div>
                </div>
            </div>

            @if($movie->scenes->isEmpty())
                <p class="text-sunset-yellow font-bold">✅ No NSK scenes recorded for this movie.</p>
            @else
                <ul class="space-y-4">
                    @foreach($movie->scenes as $scene)
                        <li class="border-l-4 border-sunset-orange pl-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-sunset-orange uppercase">{{ $scene->type }}</span>
                                <span class="text-xs bg-sunset-orange/20 text-sunset-orange px-2 py-0.5 rounded">
                                    Intensity {{ $scene->intensity }}/5
                                </span>
                            </div>
                            @if($scene->description)
                                <p class="text-sunset-white/70 text-sm">{{ $scene->description }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        

        <section class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 mb-8">
            <h2 class="text-2xl font-bold text-sunset-yellow mb-4">Community Rating</h2>

            @if($reviewCount > 0)
                <div class="flex items-center gap-4">
                    <div class="text-5xl font-bold text-sunset-yellow">
                        {{ number_format($averageRating, 1) }}
                    </div>
                    <div>
                        <div class="text-2xl text-sunset-yellow">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= round($averageRating) ? '★' : '☆' }}
                            @endfor
                        </div>
                        <p class="text-sunset-white/60 text-sm">{{ $reviewCount }} review(s)</p>
                    </div>
                </div>
            @else
                <p class="text-sunset-white/60">No reviews yet. Be the first!</p>
            @endif
        </section>

        <section class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6 mb-8">
            <h2 class="text-2xl font-bold text-sunset-yellow mb-4">Leave a Review</h2>

            @auth
                @if(session('success'))
                    <div class="bg-sunset-yellow/20 border border-sunset-yellow text-sunset-yellow px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-sunset-orange/20 border border-sunset-orange text-sunset-orange px-4 py-2 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('reviews.store', $movie) }}" class="space-y-4">
                    @csrf

                    <div>
    <label class="block text-sunset-sky text-sm mb-2">How clean is this movie?</label>
    <div class="flex gap-3">
        @for($i = 1; $i <= 5; $i++)
            <label class="cursor-pointer">
                <input type="radio" name="rating" value="{{ $i }}" required class="hidden rating-input">
                <span class="rating-box block w-12 h-12 rounded-lg border-2 border-sunset-sky/50 bg-sunset-navy text-sunset-white flex items-center justify-center font-bold text-lg transition hover:border-sunset-yellow">
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
                        <textarea
                            name="comment"
                            id="comment"
                            rows="3"
                            maxlength="1000"
                            style="background-color: #1F3A5F; color: white; border: 2px solid rgba(107, 182, 214, 0.5);"
                            class="w-full rounded-lg focus:outline-none focus:border-sunset-orange"
                            placeholder="Share your thoughts...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-sunset-orange text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-sunset-orange hover:bg-sunset-yellow text-sunset-navy font-bold px-6 py-2 rounded-lg transition">
                        Submit Review
                    </button>
                </form>
            @else
                <p class="text-sunset-white/70">
                    Please
                    <a href="{{ route('login') }}" class="text-sunset-yellow underline">log in</a>
                    to leave a review.
                </p>
            @endauth
        </section>

        <section class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-6">
            <h2 class="text-2xl font-bold text-sunset-yellow mb-4">Reviews ({{ $reviewCount }})</h2>

            @if($movie->reviews->isEmpty())
                <p class="text-sunset-white/60">No reviews yet.</p>
            @else
                <div class="space-y-4">
                    @foreach($movie->reviews as $review)
                        <div class="border-l-4 border-sunset-sky pl-4">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="font-bold text-sunset-white">{{ $review->user->name ?? 'Anonymous' }}</span>
                                <span class="text-sunset-yellow">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    @endfor
                                </span>
                            </div>
                            @if($review->comment)
                                <p class="text-sunset-white/70 text-sm">{{ $review->comment }}</p>
                            @endif

                            @auth
                                @if(auth()->user()->is_admin || auth()->id() === $review->user_id)
                                    <div class="mt-2 flex items-center gap-3 text-xs">
                                        @if(auth()->id() === $review->user_id)
                                            <a href="{{ route('reviews.edit', $review) }}" class="text-sunset-sky hover:text-sunset-yellow underline">Edit</a>
                                        @endif

                                        <form method="POST" action="{{ route('reviews.destroy', $review) }}"
                                                onsubmit="return confirm('Delete this review?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sunset-orange hover:text-sunset-yellow underline">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </main>

    <footer class="text-center text-sunset-white/40 text-sm py-8">
        <img src="{{ asset('images/johnny.png') }}" alt="" class="inline-block h-5 w-auto mr-1 align-middle opacity-70"> Let It Bee Movies — {{ date('Y') }}
    </footer>

</body>
</html>