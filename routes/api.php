<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiController::class)->group(function () {

    Route::get('test', 'test');

    Route::post('login', 'login');

    Route::post('register', 'register');

    Route::get('people/all', 'getAllPeople');

    Route::get('planets/all', 'getAllPlanets');

    Route::get('vehicles/all', 'getAllVehicles');

    Route::get('people/{id}', 'getPeopleById');

    Route::get('planets/{id}', 'getPlanetById');

    Route::get('vehicles/{id}', 'getVehicleById');

});
