<?php

use Illuminate\Support\Facades\Route;

Route::group(function () {

    /* Route para obter informações da API. */
    Route::get('/', function () {
        return ['1'];
    });

    /* Route para atualização de produtos. */
    Route::put('/products/{code}', 'ProductController@update');

    /* Route para deletar um produto específico. */
    Route::delete('/products/{code}', 'ProductController@destroy');

    /* Route para exibir informações de um produto específico. */
    Route::get('/products/{code}', 'ProductController@show');

    /* Route para listar todos os produtos com paginação. */
    Route::get('/products', 'ProductController@index');

    /* Route para listar todos os produtos com paginação. */
    Route::get('/products/search/{query}', 'ProductController@index');
});
