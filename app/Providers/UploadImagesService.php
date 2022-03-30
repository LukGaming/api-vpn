<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadImagesService extends ServiceProvider
{
   public static function uploads_images_from_product($image)
   {
      $picName = $image->getClientOriginalName();
      $path = 'uploads' . DIRECTORY_SEPARATOR . 'produtos' . DIRECTORY_SEPARATOR;
      $picName = uniqid() . '_' . $picName;
      $destinationPath = public_path($path);
      File::makeDirectory($destinationPath, 0777, true, true);
      $image->move(public_path("/uploads"), $picName);
      return 'uploads/' . $picName;
   }
   public static function removeImage($caminho_imagem){
      File::delete($caminho_imagem);
   }
   public static function upload_image_perfil_user($img){
        $folderPath = "";//path location
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $uniqid = uniqid();
        $file = 'uploads/perfil/'.$folderPath . $uniqid . '.' . $image_type;
        file_put_contents($file, $image_base64);
        return $file;
   }
}
