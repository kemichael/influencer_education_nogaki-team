<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('show.login');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('show.login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('show.register');
Route::get('/top', [App\Http\Controllers\TopController::class, 'showTop'])->name('show.top');
Route::get('/delivery', [App\Http\Controllers\DeliveryController::class, 'showDelivery'])->name('show.delivery');
Route::get('/curriculum_list', [App\Http\Controllers\TopController::class, 'showCurriculum_list'])->name('show.curriculum_list');
Route::get('/curriculum_progress', [App\Http\Controllers\TopController::class, 'showCurriculum_progress'])->name('show.curriculum_progress');
Route::post('/curriculum_progress_regist', [App\Http\Controllers\DeliveryController::class, 'registCurriculumProgress'])->name('curriculum_progress_regist');
// Route::prefix('user')->namespace('User')->name('user.')->group(function () {
//     Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('show.login');
//     Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('show.register');
// });

Auth::routes();
