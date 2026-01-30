<?php

use App\Http\Controllers\PeriodController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:period.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Period
    |--------------------------------------------------------------------------
    */

    Route::get('/period/list', [PeriodController::class, 'list']);

    Route::get('/period/create', [PeriodController::class, 'create']);

    Route::post('/period/store', [PeriodController::class, 'store']);

    Route::get('/period/{id}/edit', [PeriodController::class, 'edit']);

    Route::post('/period/update/{id}', [PeriodController::class, 'update']);

    Route::delete('/period/delete/{id}', [PeriodController::class, 'delete']);
});
