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


$router->get('article/{id}', ['uses' => 'Content\ArticleController@getArticle']);
$router->get('articles', ['uses' => 'Content\ArticleController@getArticles']);
$router->post('article', ['uses' => 'Content\ArticleController@createArticle']);
$router->patch('article/{id}', ['uses' => 'Content\ArticleController@editArticle']);
$router->delete('article/{id}', ['uses' => 'Content\ArticleController@deleteArticle']);

$router->get('media/{id}', 'Content\MediaController@getMedia');
$router->get('media', 'Content\MediaController@getMedias');
$router->post('media/generic', 'Contetn\MediaController@createGenericMedia');
$router->post('media/image', 'Contetn\MediaController@createImageMedia');