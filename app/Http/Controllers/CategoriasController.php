<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        return  Categorias::paginate(1000);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome_categoria' => 'required|string|unique:categorias',
       ]);
        try {
            $categoria = new Categorias();
            $categoria->nome_categoria = $request->nome_categoria;
            $categoria->user_id = $request->user_id;//Trocar para o user Id da sessão depois
            if ($categoria->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Categoria Criada com sucesso!',
                    'categoria' => $categoria
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        return Categorias::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        
        $categoria = Categorias::findOrFail($id);
        if ($categoria) {
            try {
                $categoria->nome_categoria = $request->nome_categoria;
                if ($categoria->save()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Categoria Editada com sucesso!',
                        'categoria' => $categoria
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function destroy($id)
    {
        $categoria = Categorias::findOrFail($id);
        if ($categoria) {
            try {
                if ($categoria->delete()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Categoria Excluida com sucesso!'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
