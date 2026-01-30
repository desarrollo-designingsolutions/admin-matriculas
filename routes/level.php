<?php

use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:level.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Level
    |--------------------------------------------------------------------------
    */

    Route::get('/level/list', [LevelController::class, 'list']);

    Route::get('/level/create', [LevelController::class, 'create']);

    Route::post('/level/store', [LevelController::class, 'store']);

    Route::get('/level/{id}/edit', [LevelController::class, 'edit']);

    Route::post('/level/update/{id}', [LevelController::class, 'update']);

    Route::delete('/level/delete/{id}', [LevelController::class, 'delete']);
});
