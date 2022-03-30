<?php

namespace App\Http\Controllers;

use App\Models\PerfilUser;
use App\Providers\UploadImagesService;
use Illuminate\Http\Request;

class PerfilUserController extends Controller
{
    public function index()
    {
        return PerfilUser::get();
    }
    public function store(Request $request)
    {
        try {
            $upload_imagem = UploadImagesService::upload_image_perfil_user($request->image);
            $perfil_user = new PerfilUser();
            $perfil_user->name = $request->name;
            $perfil_user->birth_date = $request->birth_date;
            $perfil_user->caminho_imagem_perfil = $upload_imagem;
            $perfil_user->user_id = $request->user_id;
            $perfil_user->save();
        } catch (\Exception$e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        return response()->json([
            'mensagem' => 'Salvo com sucesso!',
            'perfil_usuario' => $perfil_user,
        ]);
    }
    public function edit($id)
    {
        $perfil_user = PerfilUser::where('user_id', $id)->first();
        return response()->json([
            'perfil_usuario' => $perfil_user,
        ]);
    }
    public function patch(Request $request, $id)
    {
        try {
            $upload_imagem = UploadImagesService::upload_image_perfil_user($request->image);
            $perfil_user = PerfilUser::where('user_id', $id)->first();
            $perfil_user->name = $request->name;
            $perfil_user->birth_date = $request->birth_date;
            $perfil_user->caminho_imagem_perfil = $upload_imagem;
            $perfil_user->save();
        } catch (\Exception$e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
        return response()->json([
            'mensagem' => 'Salvo com sucesso!',
            'perfil_usuario' => $perfil_user,
        ]);
    }
}
