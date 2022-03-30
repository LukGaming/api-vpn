<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class games extends Model
{
    protected $filliable = [
        'id',
        'name',
        'release_year',
        'description',
        'gameImages'
    ];
    public function gameImages()
    {
        return $this->hasMany(ImagesGames::class);
    }
    public function gameVideos()
    {
        return $this->hasMany(gameVideos::class);
    }

}
