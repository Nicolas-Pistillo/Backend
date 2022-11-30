<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiController::class)->group(function () {

    Route::get('test', 'test');

    Route::post('login', 'login');

    Route::post('register', 'register');

});
