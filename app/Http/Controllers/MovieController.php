<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with(['genres', 'scenes']);

        // Search berdasarkan judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sembunyikan film yang punya adegan bertipe tertentu
        $exclude = (array) $request->input('exclude', []);
        if (!empty($exclude)) {
            $query->where('is_reviewed', true);
            $query->whereDoesntHave('scenes', function ($q) use ($exclude) {
                $q->whereIn('type', $exclude);
            });
        }

        $movies = $query->orderBy('title')->get();

        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        $movie->load(['genres', 'scenes', 'reviews.user']);

        $averageRating = $movie->reviews()->avg('rating');
        $reviewCount = $movie->reviews()->count();

        return view('movies.show', compact('movie', 'averageRating', 'reviewCount'));
    }
}