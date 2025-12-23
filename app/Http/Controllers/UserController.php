<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use Symfony\Component\Mime\Message;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        try {
            $user = new User();
            $user->fill($data);
            $user->password = bcrypt(123);
            $user->save();
            return response()->json($user, 201);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Falha ao inserir usuário!'
            ],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Falha ao buscar o usuário!'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if($user == null){
            return response()->json([
                'message' => 'Usuário não existe'
                ], 404);
        }

        $data = $request->validated();
        try {
            $user->update($data);
            return response()->json($user, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Falha ao atualizar o usuário!'
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if($user == null){
            return response()->json([
                'message' => 'Usuário não existe'
                ], 404);
        }
        try {
            $user->destroy($id);
            return response()->json($user, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Falha ao deletar o usuário!'
            ],400);
        }
    }
}
