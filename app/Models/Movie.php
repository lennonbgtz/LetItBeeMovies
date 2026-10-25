<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'year', 'synopsis', 'poster_url', 'trailer_url', 'director', 'runtime', 'cast_members'];

    public function genres(){
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function scenes(){
        return $this->hasMany(Scene::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function averageRating(){
        return $this->reviews()->avg('rating');
    }

    public function trailerEmbedUrl(): ?string
{
    if (! $this->trailer_url) {
        return null;
    }

    if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~i', $this->trailer_url, $m)) {
        return 'https://www.youtube-nocookie.com/embed/' . $m[1];
    }

    return null;
}
}
