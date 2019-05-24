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

//Authentification & Register
$router->post('register', 'UserController@register');
$router->post('login','AuthController@login');
$router->post('logout','AuthController@logout');

//Troop - admin
$router->post('troop/create','TroopController@store');

//Buildings - admin
$router->post('building/create','BuildingController@store');

//Buildings - client
$router->get('/buildings/get_user_buildings/{userId}','BuildingController@getBuildings');

//UserBuilding - client
$router->post('building/build','UserBuildingController@store');
