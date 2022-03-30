<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GameVideosController extends Controller
{
    public function storeGamesVideo($video)
    {
        $picName = $video->getClientOriginalName();
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR. 'videos'. DIRECTORY_SEPARATOR;
        $picName = uniqid() . '_' . $picName;
        $video_name = $path . $picName;
        $destinationPath = public_path($path);
        File::makeDirectory($destinationPath, 0777, true, true);
        $video->move(public_path($path), $picName);
        return $video_name;
    }
}
