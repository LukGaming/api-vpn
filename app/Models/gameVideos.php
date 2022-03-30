<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gameVideos extends Model
{
    protected $filliable = [
        'id',
        'caminho_video_game',
        'games_id',
    ];
    public function games()
    {
        return $this->belongsTo(games::class);
    }
}
