<?php

use App\Http\Controllers\Api\ApiProductController;
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


Route::get('products', [ApiProductController::class, 'index']);
Route::post('add-products', [ApiProductController::class, 'store']);
Route::get('product/{id}', [ApiProductController::class, 'show']);
Route::get('product/{id}/edit', [ApiProductController::class, 'edit']);
Route::post('product/{id}/update', [ApiProductController::class, 'update']);
Route::delete('product/{id}/delete', [ApiProductController::class, 'destroy']);
