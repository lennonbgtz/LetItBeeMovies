<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Horror', 'Action', 'Thriller', 'Drama', 'Crime','Mystery'];

        foreach ($genres as $name){
            Genre::create(['name' => $name]);
        }
    }
}
