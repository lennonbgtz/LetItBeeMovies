<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        // Film 1: The Dark Knight (2008)
        $m1 = Movie::create([
            'title' => 'The Dark Knight',
            'year' => 2008,
            'synopsis' => 'Batman faces the Joker, a criminal mastermind who plunges Gotham into chaos.',
        ]);
        $m1->genres()->attach(Genre::whereIn('name', ['Action', 'Crime', 'Thriller'])->pluck('id'));
        $m1->scenes()->createMany([
            ['type' => 'kissing', 'intensity' => 1, 'description' => 'Brief kiss between Rachel and Harvey.'],
        ]);

        // Film 2: The Truman Show (1998)
        $m2 = Movie::create([
            'title' => 'The Truman Show',
            'year' => 1998,
            'synopsis' => 'An insurance salesman discovers his entire life is actually a reality TV show.',
        ]);
        $m2->genres()->attach(Genre::whereIn('name', ['Drama', 'Mystery'])->pluck('id'));
        $m2->scenes()->createMany([
            ['type' => 'kissing', 'intensity' => 1, 'description' => 'Brief romantic kiss between Truman and Sylvia.'],
        ]);
    }
}