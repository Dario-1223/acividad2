<?php

use App\Http\Controllers\ApiCategoriaController;
use App\Http\Controllers\ApiProductoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 

/* Route::apiResource('productos', ApiProductoController::class)->only([
    'index', 'show', 'store', 'update', 'destroy'
]); */
    

Route::apiResource('categorias', ApiCategoriaController::class)->only([
    'index', 'show', 'store', 'update', 'destroy'
]);


//Route::post('/login', [AuthController::class, 'login']);
//Route::post('/registro', [AuthController::class, 'registro']);


Route::get('/prueba-api', function () {
    return 'Funciona';
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);