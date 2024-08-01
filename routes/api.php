<?php

// use App\Http\Controllers\CategoryController;

use App\Http\Controllers\ApiCate\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');

    Route::post('/', [CategoryController::class, 'store'])->name('store');

    Route::get('/{id}', [CategoryController::class, 'show'])->name('show')
        ->where('id', '[0-9]+');

    Route::post('/{id}', [CategoryController::class, 'update'])->name('update')
        ->where('id', '[0-9]+');

    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy')
        ->where('id', '[0-9]+');
});
