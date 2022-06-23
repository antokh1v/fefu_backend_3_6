<?php

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\CartWebController;
use App\Http\Controllers\CatalogWebController;
use App\Http\Controllers\NewsWebController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OrderWebController;
use App\Http\Controllers\ProductWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageWebController;
use \App\Http\Controllers\AppealWebController;
use \App\Http\Controllers\ProfileWebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news', [NewsWebController::class, 'index']);
Route::get('/news/{slug}', [NewsWebController::class, 'show']);

Route::get('/catalog/product/{slug}', [ProductWebController::class, 'index'])->name('product');
Route::get('/catalog/{slug?}', [CatalogWebController::class, 'index'])->name('catalog');

Route::get('/appeal', [AppealWebController::class, 'form'])->name('appeal.form');
Route::post('/appeal', [AppealWebController::class, 'send'])->name('appeal.send');

Route::get('/profile',[ProfileWebController::class, 'show'])->middleware('auth')->name('profile');

Route::get('/login', [AuthWebController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::get('/register', [AuthWebController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.post');

Route::prefix('/oauth')->group(function () {
    Route::get('/{provider}/redirect', [OAuthController::class, 'redirectToService'])->name('oauth.redirect');
    Route::get('/{provider}/login', [OAuthController::class, 'login'])->name('oauth.login');
});

Route::get('/cart', CartWebController::class)->middleware('auth.optional');

Route::get('/checkout', [OrderWebController::class, 'show'])->name('checkout.show')->middleware('auth');
Route::post('/checkout', [OrderWebController::class, 'store'])->name('checkout.post')->middleware('auth');

Route::get('/{slug}', PageWebController::class);
