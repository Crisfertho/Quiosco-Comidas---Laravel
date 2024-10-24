<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']); //->middleware('auth:sanctum');

    //Almacenar ordenes
    Route::apiResource('/pedidos',PedidoController::class); //->middleware('auth:sanctum');
});


Route::apiResource('/categorias', CategoriaController::class);
Route::apiResource('/productos', ProductoController::class);

//Autenticación
Route::post('/registro', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);