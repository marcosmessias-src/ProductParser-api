<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)->middleware('auth:api')->group(function () {

    /* Route para obter informações da API. */
    Route::get('/', function () {
        return ['1'];
    });

    /* Route para pesquisar por produtos. */
    Route::get('/products-search/{query}', 'search');

    /* Route para atualização de produtos. */
    Route::put('/products/{code}', 'update');

    /* Route para deletar um produto específico. */
    Route::delete('/products/{code}', 'destroy');

    /* Route para exibir informações de um produto específico. */
    Route::get('/products/{code}', 'show');

    /* Route para listar todos os produtos com paginação. */
    Route::get('/products', 'index');
});
