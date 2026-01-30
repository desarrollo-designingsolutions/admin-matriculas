<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
// Route::middleware(['check.permission:book.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Book
    |--------------------------------------------------------------------------
    */

    Route::get('/book/list', [BookController::class, 'list']);

    Route::get('/book/create', [BookController::class, 'create']);

    Route::post('/book/store', [BookController::class, 'store']);

    Route::get('/book/{id}/edit', [BookController::class, 'edit']);

    Route::post('/book/update/{id}', [BookController::class, 'update']);

    Route::delete('/book/delete/{id}', [BookController::class, 'delete']);
// });
