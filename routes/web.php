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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('auth/login', ['uses' => 'AuthController@authenticate']);

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('users', function () {
        $users = \App\User::all();
        return response()->json($users);
    });

    $router->post('articles', ['uses' => 'ArticleController@store']);
    $router->put('articles/{id}', ['uses' => 'ArticleController@update']);
    $router->delete('articles/{id}', ['uses' => 'ArticleController@destroy']);
});

$router->get('articles', ['uses' => 'ArticleController@index']);
$router->get('articles/{id}', ['uses' => 'ArticleController@show']);

$router->get('complaints', ['uses' => 'ComplaintController@index']);
$router->get('complaints/{id}', ['uses' => 'ComplaintController@show']);
$router->post('complaints', ['uses' => 'ComplaintController@store']);
$router->delete('complaints/{id}', ['uses' => 'ComplaintController@destroy']);

$router->get('subscriptions', ['uses' => 'SubscriptionController@index']);
$router->post('subscriptions', ['uses' => 'SubscriptionController@store']);
$router->delete('subscriptions/{id}', ['uses' => 'SubscriptionController@destroy']);
