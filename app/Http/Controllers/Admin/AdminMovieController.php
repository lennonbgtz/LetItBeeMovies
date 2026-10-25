<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::withCount('scenes')->orderBy('title')->get();

        $onlineUsers = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
            ->distinct()
            ->count('user_id');

        return view('admin.movies.index', compact('movies', 'onlineUsers'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();

        return view('admin.movies.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1888|max:2100',
            'synopsis' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'poster' => 'nullable|image|max:2048',
            'trailer_url' => ['nullable', 'url', 'max:255', 'regex:/^https?:\/\/(www\.|m\.)?(youtube\.com|youtu\.be)\//i'],
            'director' => 'nullable|string|max:255',
            'runtime' => 'nullable|integer|min:1|max:600',
            'cast_members' => 'nullable|string|max:1000',
        ]);

        $movie = Movie::create([
            'title' => $data['title'],
            'year' => $data['year'],
            'synopsis' => $data['synopsis'] ?? null,
            'poster_url' => $request->hasFile('poster') ? $request->file('poster')->store('posters', 'public') : null,
            'trailer_url' => $data['trailer_url'] ?? null,
            'director' => $data['director'] ?? null,
            'runtime' => $data['runtime'] ?? null,
            'cast_members' => $data['cast_members'] ?? null,
        ]);

        $movie->genres()->sync($data['genres'] ?? []);

        return redirect()->route('admin.index')->with('success', 'Movie added successfully.');
    }

    public function toggleReviewed(Movie $movie)
    {
        $movie->is_reviewed = ! $movie->is_reviewed;
        $movie->save();

        return back()->with('success', $movie->is_reviewed ? 'Movie marked as reviewed.' : 'Movie marked as not reviewed.');
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::orderBy('name')->get();
        $movie->load('genres');

        return view('admin.movies.edit', compact('movie', 'genres'));
    }

    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1888|max:2100',
            'synopsis' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'poster' => 'nullable|image|max:2048',
            'trailer_url' => ['nullable', 'url', 'max:255', 'regex:/^https?:\/\/(www\.|m\.)?(youtube\.com|youtu\.be)\//i'],
            'director' => 'nullable|string|max:255',
            'runtime' => 'nullable|integer|min:1|max:600',
            'cast_members' => 'nullable|string|max:1000',
        ]);

        $movie->title = $data['title'];
        $movie->year = $data['year'];
        $movie->synopsis = $data['synopsis'] ?? null;
        $movie->trailer_url = $data['trailer_url'] ?? null;
        $movie->director = $data['director'] ?? null;
        $movie->runtime = $data['runtime'] ?? null;
        $movie->cast_members = $data['cast_members'] ?? null;

        if ($request->hasFile('poster')) {
            if ($movie->poster_url) {
                Storage::disk('public')->delete($movie->poster_url);
            }
            $movie->poster_url = $request->file('poster')->store('posters', 'public');
        }

        $movie->save();
        $movie->genres()->sync($data['genres'] ?? []);

        return redirect()->route('admin.index')->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
    {
        $movie->genres()->detach();
        $movie->reviews()->delete();
        $movie->scenes()->delete();

        if ($movie->poster_url) {
            Storage::disk('public')->delete($movie->poster_url);
        }

        $movie->delete();

        return redirect()->route('admin.index')->with('success', 'Movie deleted.');
    }
}