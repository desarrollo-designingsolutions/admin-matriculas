<?php

use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas
Route::middleware(['check.permission:course.list'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Discount
    |--------------------------------------------------------------------------
    */

    Route::get('/discount/list', [DiscountController::class, 'list']);

    Route::get('/discount/create', [DiscountController::class, 'create']);

    Route::post('/discount/store', [DiscountController::class, 'store']);

    Route::get('/discount/{id}/edit', [DiscountController::class, 'edit']);

    Route::post('/discount/update/{id}', [DiscountController::class, 'update']);

    Route::delete('/discount/delete/{id}', [DiscountController::class, 'delete']);
});
