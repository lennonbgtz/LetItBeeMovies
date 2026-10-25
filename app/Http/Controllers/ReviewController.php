<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cegah user review film yang sama 2x
        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('movie_id', $movie->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this movie.');
        }

        Review::create([
            'user_id'  => auth()->id(),
            'movie_id' => $movie->id,
            'rating'   => $validated['rating'],
            'comment'  => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Review submitted!');
    }

    public function destroy(\App\Models\Review $review)
{
    $user = auth()->user();

    abort_unless($user->is_admin || $review->user_id === $user->id, 403);

    $review->delete();

    return back()->with('success', 'Review deleted.');
}

public function edit(\App\Models\Review $review)
{
    abort_unless($review->user_id === auth()->id(), 403);

    $movie = \App\Models\Movie::findOrFail($review->movie_id);

    return view('reviews.edit', compact('review', 'movie'));
}

public function update(\Illuminate\Http\Request $request, \App\Models\Review $review)
{
    abort_unless($review->user_id === auth()->id(), 403);

    $data = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    $review->rating = $data['rating'];
    $review->comment = $data['comment'] ?? null;
    $review->save();

    return redirect()->route('movies.show', $review->movie_id)->with('success', 'Review updated.');
}
}