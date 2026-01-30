<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:course.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Course
    |--------------------------------------------------------------------------
    */

    Route::get('/course/list', [CourseController::class, 'list']);

    Route::get('/course/create', [CourseController::class, 'create']);

    Route::post('/course/store', [CourseController::class, 'store']);

    Route::get('/course/{id}/edit', [CourseController::class, 'edit']);

    Route::post('/course/update/{id}', [CourseController::class, 'update']);

    Route::delete('/course/delete/{id}', [CourseController::class, 'delete']);
});
