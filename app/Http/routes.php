<?php

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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'], function () use ($app) {
    $app->get('/', 'AppController@index');
    $app->get('/{name}', 'AppController@show');
    $app->post('/', 'AppController@store');
    $app->put('/{name}', 'AppController@replace');
    $app->patch('/{name}', 'AppController@update');
    $app->delete('/{name}', 'AppController@destroy');
});