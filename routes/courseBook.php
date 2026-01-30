<?php

use App\Http\Controllers\CourseBookController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:course.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CourseBook
    |--------------------------------------------------------------------------
    */

    Route::get('/courseBook/list', [CourseBookController::class, 'list']);

    Route::get('/courseBook/create', [CourseBookController::class, 'create']);

    Route::post('/courseBook/store', [CourseBookController::class, 'store']);

    Route::get('/courseBook/{id}/edit', [CourseBookController::class, 'edit']);

    Route::post('/courseBook/update/{id}', [CourseBookController::class, 'update']);

    Route::delete('/courseBook/delete/{id}', [CourseBookController::class, 'delete']);
});
