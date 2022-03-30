<?php

namespace App\Http\Controllers;

use App\Models\ImagesGames;
use Illuminate\Support\Facades\File;

class ImagesGamesController extends Controller
{
    public function storeImagesGames($image)
    {
        $picName = $image->getClientOriginalName();
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR. 'images'. DIRECTORY_SEPARATOR;
        $picName = uniqid() . '_' . $picName;
        $image_name = $path . $picName;
        $destinationPath = public_path($path);
        File::makeDirectory($destinationPath, 0777, true, true);
        $image->move(public_path($path), $picName);
        return $image_name;
    }
    public function removeImage($id)
    {
        $image = ImagesGames::find($id);
        if ($image) {
            unlink($image->caminho_imagem_game);
            $image->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Imagem removida com sucesso!',
            ]);

        }
    }
}
