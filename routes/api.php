<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/users', [UserController::class, 'index']);
// Route::post('/users', [UserController::class, 'store']);

Route::apiResource('/users', UserController::class);
Route::apiResource('/produtos', ProdutoController::class);
Route::put('produtos/estoque/{id}', [ProdutoController::class, 'updateEstoque']);
