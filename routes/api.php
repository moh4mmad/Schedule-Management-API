<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::get('permissions', 'AuthController@permissions');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::resource('employees', UserController::class);
    Route::resource('taskSchedules', TaskScheduleController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
