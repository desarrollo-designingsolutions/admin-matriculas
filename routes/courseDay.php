<?php

use App\Http\Controllers\CourseDayController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:course.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CourseDay
    |--------------------------------------------------------------------------
    */

    Route::get('/courseDay/list', [CourseDayController::class, 'list']);

    Route::get('/courseDay/create', [CourseDayController::class, 'create']);

    Route::post('/courseDay/store', [CourseDayController::class, 'store']);

    Route::get('/courseDay/{id}/edit', [CourseDayController::class, 'edit']);

    Route::post('/courseDay/update/{id}', [CourseDayController::class, 'update']);

    Route::delete('/courseDay/delete/{id}', [CourseDayController::class, 'delete']);
});
