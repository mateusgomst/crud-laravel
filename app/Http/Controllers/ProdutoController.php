<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateEstoqueRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::all();
        return response()->json($produtos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        $data =  $request->validated();
        try {
            $produto = new Produto();
            $produto->fill($data);
            $produto->save();
            return response()->json($produto, 200);
        } catch (\Exception $ex) {
            return response()->json(['response' =>'Não foi possivel cadastrar esse produto!'],400);
        }
    }

    public function updateEstoque(UpdateEstoqueRequest $request, string $id){
        $estoque = $request->validated();
        $produto = Produto::find($id);
        if($produto == false){
            return response()->json(['response' => 'Produto não existe!'],404);
        }

        try {
            $produto->estoque = $estoque["estoque"];
            $produto->save();
            return response()->json(['response' => 'Estoque atualizado!'], 200);
        } catch (\Exception $ex) {
            return response()->json(['response' => 'Não foi possivel atualizar o estoque!'],404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Produto::findOrFail($id),200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, string $id)
    {
        $data = $request->validated();

        $produto = Produto::find($id);
        if($produto == false){
            return response()->json(['response' => 'Produto não existe!'],404);
        }

        try {
            $produto->fill($data);
            $produto->save();
            return response()->json($produto,200);
        } catch (\Exception $ex) {
            return response()->json(['response'=>'Não foi possivel atualizar o produto!'],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Produto::find($id);
        if($produto == false){
            return response()->json(['response' => 'Produto não existe!'],404);
        }

        try {
            $produto->ativo = false;
            $produto->save();
            return response()->json(['response'=>'Produto desativado com sucesso!'],200);
        } catch (\Exception $ex) {
            return response()->json(['response'=>'Não foi possivel desativar o produto!'],400);
        }
    }
}
