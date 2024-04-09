<?php

use App\Http\Controllers\ApiDetailsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/* Route para obter informações da API. */
Route::middleware('auth:api')->get('/', [ApiDetailsController::class, 'apiDetails']);

Route::controller(ProductController::class)->middleware('auth:api')->group(function () {
    /* Route para pesquisar por produtos. */
    Route::get('/products-search/{query}', 'search')->name('product-search');

    /* Route para atualização de produtos. */
    Route::put('/products/{code}', 'update')->name('product-update');

    /* Route para deletar um produto específico. */
    Route::delete('/products/{code}', 'destroy')->name('product-destroy');

    /* Route para exibir informações de um produto específico. */
    Route::get('/products/{code}', 'show')->name('product-show');

    /* Route para listar todos os produtos com paginação. */
    Route::get('/products', 'index')->name('product-index');
});
