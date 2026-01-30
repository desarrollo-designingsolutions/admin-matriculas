<?php

use App\Http\Controllers\DayController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:day.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Day
    |--------------------------------------------------------------------------
    */

    Route::get('/day/list', [DayController::class, 'list']);

    Route::get('/day/create', [DayController::class, 'create']);

    Route::post('/day/store', [DayController::class, 'store']);

    Route::get('/day/{id}/edit', [DayController::class, 'edit']);

    Route::post('/day/update/{id}', [DayController::class, 'update']);

    Route::delete('/day/delete/{id}', [DayController::class, 'delete']);
});
