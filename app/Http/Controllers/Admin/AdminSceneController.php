<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Scene;
use Illuminate\Http\Request;

class AdminSceneController extends Controller
{
    public function index(Movie $movie)
    {
        $movie->load('scenes');

        return view('admin.scenes.index', compact('movie'));
    }

    public function store(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'type' => 'required|in:kissing,nudity,sex',
            'intensity' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string|max:500',
        ]);

        $scene = new Scene();
        $scene->movie_id = $movie->id;
        $scene->type = $data['type'];
        $scene->intensity = $data['intensity'];
        $scene->description = $data['description'] ?? null;
        $scene->save();

        return redirect()->route('admin.scenes.index', $movie)->with('success', 'Scenes added successfully.');
    }

    public function destroy(Movie $movie, Scene $scene)
    {
        abort_if($scene->movie_id !== $movie->id, 404);

        $scene->delete();

        return redirect()->route('admin.scenes.index', $movie)->with('success', 'Scenes deleted.');
    }

    public function edit(Movie $movie, Scene $scene)
{
    abort_if($scene->movie_id !== $movie->id, 404);

    return view('admin.scenes.edit', compact('movie', 'scene'));
}

public function update(Request $request, Movie $movie, Scene $scene)
{
    abort_if($scene->movie_id !== $movie->id, 404);

    $data = $request->validate([
        'type' => 'required|in:kissing,nudity,sex',
        'intensity' => 'required|integer|min:1|max:5',
        'description' => 'nullable|string|max:500',
    ]);

    $scene->type = $data['type'];
    $scene->intensity = $data['intensity'];
    $scene->description = $data['description'] ?? null;
    $scene->save();

    return redirect()->route('admin.scenes.index', $movie)->with('success', 'Scene updated successfully.');
}
}