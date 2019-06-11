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

//move inside middleware
$router->post('login', 'AuthController@login');

$router->group(['middleware' => 'updateInfo'], function () use ($router) {

    //Buildings - client
    $router->get('/buildings/get_user_buildings/{userId}', 'BuildingController@getBuildings');
    $router->get('/buildings/upgrade', 'BuildingController@upgrade');

    //Village - client
    $router->get('village/{userId}', 'VillageController@getVillageById');

    //VillageBuilding - client
    $router->post('building/build', 'VillageBuildingController@store');

    //Trrops - client
    $router->post('troops/recruit','TroopController@recruit');

    //Test
    $router->post('test','ExampleController@test');

});


//Authentification & Register
$router->post('register', 'UserController@register');
$router->post('logout', 'AuthController@logout');

//Troop - admin
$router->post('troop/create', 'TroopController@store');

//Buildings - admin
$router->post('building/create', 'BuildingController@store');

//Continents - admin
$router->post('continent/create', 'ContinentController@store');
$router->get('continents', 'ContinentController@index');

//Villages - admin
$router->get('villages', 'VillageController@index');

//Users
$router->get('users/getall', 'UserController@getAll');
