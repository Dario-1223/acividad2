<?php

use App\Http\Controllers\ApiCategoriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




// CATEGORIAS
Route::get('categorias', [ApiCategoriaController::class, 'indexV'])->name('categorias.index');

