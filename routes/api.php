<?php

use App\Http\Controllers\Backoffice\PositionController;
use App\Http\Controllers\Backoffice\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/users')->controller(UserController::class)->group(function() {
    Route::get('/', 'getAllData');
    Route::get('/{id}', 'getDataById');
    Route::post('/', 'upsertData');
});

Route::prefix('v1/position')->controller(PositionController::class)->group(function() {
    Route::get('/', 'getAllData');
    Route::get('/{id}', 'getDataById');
    Route::post('/', 'upsertData');
    Route::delete('/{id}', 'deleteData');
});
