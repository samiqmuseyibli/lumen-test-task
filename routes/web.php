<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('register', ['uses' => 'UserController@store']);//+
        $router->post('sign-in', ['uses' => 'UserController@authenticate']);//+
        $router->post('recover-password', ['uses' => 'UserController@forgotPassword']);//+
        $router->patch('recover-password', ['uses' => 'UserController@recoverPassword']);//+
    });

    $router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
        $router->get('/', ['uses' => 'UserController@get']);//+
        $router->post('companies', ['uses' => 'CompanyController@store']);
        $router->get('companies', ['uses' => 'CompanyController@get']);
    });
});
