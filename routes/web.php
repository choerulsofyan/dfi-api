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

    $router->get('topics', ['uses' => 'TopicController@index']);
    $router->get('topics/{id}', ['uses' => 'TopicController@show']);
    $router->post('topics', ['uses' => 'TopicController@store']);
    $router->put('topics/{id}', ['uses' => 'TopicController@update']);
    $router->delete('topics/{id}', ['uses' => 'TopicController@destroy']);
    $router->get('topics/{id}/articles', ['uses' => 'TopicController@articles']);

    $router->get('comments', ['uses' => 'CommentController@index']);
    $router->get('comments/{id}', ['uses' => 'CommentController@show']);
    $router->put('comments/{id}', ['uses' => 'CommentController@update']);

    $router->get('subscriptions', ['uses' => 'SubscriptionController@index']);
    $router->delete('subscriptions/{id}', ['uses' => 'SubscriptionController@destroy']);

    $router->get('complaints', ['uses' => 'ComplaintController@index']);
    $router->get('complaints/{id}', ['uses' => 'ComplaintController@show']);
    $router->delete('complaints/{id}', ['uses' => 'ComplaintController@destroy']);

    $router->get('programs', ['uses' => 'ProgramController@index']);
    $router->get('programs/{id}', ['uses' => 'ProgramController@show']);
    $router->put('programs/{id}', ['uses' => 'ProgramController@update']);
    $router->delete('programs/{id}', ['uses' => 'ProgramController@destroy']);
});

$router->get('articles', ['uses' => 'ArticleController@index']);
$router->get('articles/{id}', ['uses' => 'ArticleController@show']);
$router->get('articles/{id}/comments', ['uses' => 'ArticleController@comments']);

$router->post('comments', ['uses' => 'CommentController@store']);
$router->delete('comments/{id}', ['uses' => 'CommentController@destroy']);

$router->post('complaints', ['uses' => 'ComplaintController@store']);

$router->post('subscriptions', ['uses' => 'SubscriptionController@store']);

$router->post('programs', ['uses' => 'ProgramController@store']);
