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

$router->options(
    '/{any:.*}',
    [
        'middleware' => ['cors'],
        function () {
            return response(['status' => 'success'], 200);
        }
    ]
);

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('messages', 'MessageController@index');
    $router->post('messages', 'MessageController@store');
    $router->get('messages/{id}', 'MessageController@show');
    $router->put('messages/{id}', 'MessageController@update');
    $router->delete('messages/{id}', 'MessageController@destroy');
    $router->post('/translate-and-update', 'MessageController@translateAndUpdate');
});

