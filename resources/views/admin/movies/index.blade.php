<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Let It Bee Movies</title>
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

    <main class="max-w-6xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-sunset-yellow mb-6">List of Movies</h1>

        <div class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl p-5 mb-6 w-fit">
            <p class="text-sunset-sky text-sm">Active logged-in users ( last 5 minutes)</p>
            <p class="text-4xl font-bold text-sunset-yellow">{{ $onlineUsers }}</p>
        </div>

        @if(session('success'))
    <div class="bg-sunset-yellow/20 border border-sunset-yellow text-sunset-yellow px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.movies.create') }}" class="inline-block bg-sunset-orange hover:bg-sunset-yellow text-sunset-navy font-bold px-4 py-2 rounded-lg transition mb-4">
    + Add Movie
</a>

        <div class="bg-sunset-white/5 border border-sunset-sky/30 rounded-xl overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-sunset-white/10 text-sunset-sky text-sm">
                    <tr>
                        <th class="px-4 py-3" text-left>Title</th>
                        <th class="px-4 py-3" text-left>Release year</th>
                        <th class="px-4 py-3" text-left>Number of Scenes</th>
                        <th class="px-4 py-3 text-left">Action</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movies as $movie)
                        <tr class="border-t border-sunset-sky/20">
                            <td class="px-4 py-3 font-bold">{{ $movie->title }}</td>
                            <td class="px-4 py-3">{{ $movie->year }}</td>
                            <td class="px-4 py-3">{{ $movie->scenes_count }}</td>
                               <td class="px-4 py-3">
                                   <a href="{{ route('admin.scenes.index', $movie) }}" class="text-sunset-sky hover:text-sunset-yellow underline">Manage scenes</a>
                                   <a href="{{ route('admin.movies.edit', $movie) }}" class="ml-4 text-sunset-sky hover:text-sunset-yellow underline">Edit</a>
                                   <form method="POST" action="{{ route('admin.movies.destroy', $movie) }}" class="inline"
                                            onsubmit="return confirm('Delete this movie? Its scenes and reviews will be removed too.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-4 text-sunset-orange hover:text-sunset-yellow underline">Delete</button>
                                    </form>
                               </td>

                            <td class="px-4 py-3">
                               <form method="POST" action="{{ route('admin.movies.reviewed', $movie) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Click to toggle" class="underline {{ $movie->is_reviewed ? 'text-sunset-yellow' : 'text-sunset-orange' }}">
                                       {{ $movie->is_reviewed ? 'Reviewed ✓' : 'Not reviewed' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sunset-white/60">No movies yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>