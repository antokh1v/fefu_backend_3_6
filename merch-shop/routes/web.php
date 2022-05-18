<?php

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\NewsWebController;
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

Route::get('/appeal', [AppealWebController::class, 'form'])->name('appeal.form');
Route::post('/appeal', [AppealWebController::class, 'send'])->name('appeal.send');

Route::get('/profile',[ProfileWebController::class, 'show'])->middleware('auth')->name('profile');

Route::get('/login', [AuthWebController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::get('/register', [AuthWebController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.post');

Route::get('/{slug}', PageWebController::class);
