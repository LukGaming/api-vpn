<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->group(['prefix' => 'api'], function () use ($router) {
    /*Rotas de Games*/
    $router->get('/games/{paginate}/get', 'gamesController@index');
    //  $router->get('/games', 'gamesController@index');
    $router->post('/games/create', 'GamesController@store');
    $router->get('/games/{id}', 'GamesController@show');
    $router->patch('/games/{id}', 'GamesController@update');
    // $router->delete('/produtos/{id}', 'GamesController@destroy');
    $router->get('/games/{id}/edit', 'GamesController@edit');
    /*Rotas de Games*/
    /*Rota de Imagens*/
    $router->delete('/games/remove-image/{id}', 'ImagesGamesController@removeImage');
    /*Rota de Imagens*/
});
