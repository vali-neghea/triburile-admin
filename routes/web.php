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
    $router->get('/buildings/upgrade', 'BuildingController@upgrade');

    //Village - client
    $router->get('village/{userId}/{villageId}', 'VillageController@getVillageById');

    //VillageBuilding - client
    $router->post('building/build', 'VillageBuildingController@store');
    $router->get('village/buildings/{villageId}','VillageBuildingController@getBuildings');
    $router->get('village/buildings/{villageId}/{buildingId}','VillageBuildingController@getBuildingDetails');
    $router->put('village/buildings/{villageId}/{buildingId}','VillageBuildingController@upgrade');

    //Trrops - client
    $router->post('troops/recruit','TroopController@recruit');

    //Test
    $router->post('test','ExampleController@test');
    $router->post('text/index','ExampleController@textIndex');

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
