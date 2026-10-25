<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    protected $fillable = ['movie_id', 'type', 'intensity', 'description'];

    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
