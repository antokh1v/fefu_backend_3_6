<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CartApiController;
use App\Http\Controllers\CatalogApiController;
use App\Http\Controllers\NewsApiController;
use App\Http\Controllers\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageApiController;
use App\Http\Controllers\AppealApiController;


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

Route::apiResource('news', NewsApiController::class)->only([
        'index',
        'show',
    ]
);

Route::apiResource('categories', CatalogApiController::class)->only([
    'index',
    'show',
]);

Route::prefix('catalog')->group(function () {
    Route::get('product/list', [ProductApiController::class, 'index']);
    Route::get('product/details/{slug}', [ProductApiController::class, 'show']);
});

Route::apiResource('pages', PageApiController::class)->only([
    'index',
    'show',
]);

Route::post('/cart/set_quantity', [CartApiController::class, 'setQuantity']);
Route::get('/cart/', [CartApiController::class, 'show']);

Route::post('appeal', [AppealApiController::class, 'send']);

Route::post('login', [AuthApiController::class, 'login']);
Route::post('register', [AuthApiController::class, 'register']);
Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');

