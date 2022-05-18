<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\NewsApiController;
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

Route::apiResource('pages', PageApiController::class)->only([
    'index',
    'show',
]);


Route::post('appeal', [AppealApiController::class, 'send']);

Route::post('login', [AuthApiController::class, 'login']);
Route::post('register', [AuthApiController::class, 'register']);
Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');

