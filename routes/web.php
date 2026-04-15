<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\CurriculumController as AdminCurriculumController;
use App\Http\Controllers\Admin\DeliveryController as AdminDeliveryController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\User\ArticleController as UserArticleController;
use App\Http\Controllers\User\CurriculumController as UserCurriculumController;
use App\Http\Controllers\User\DeliveryController as UserDeliveryController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TopController as UserTopController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\ProgressController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('guest')->prefix('user')->group(function () {
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('show.login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('user.login.submit');
    Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('show.register');
    Route::post('/register', [UserRegisterController::class, 'register'])->name('user.register.submit');
});

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/top', [UserTopController::class, 'showTop'])->name('show.top');
    Route::get('/article/{id}', [UserArticleController::class, 'showArticle'])->name('show.article');
    Route::get('/curriculum/{id}', [UserCurriculumController::class, 'showCurriculumList'])->name('show.curriculum');
    Route::get('/delivery/{id}', [UserDeliveryController::class, 'showDelivery'])->name('show.delivery');
    Route::get('/progress', [ProgressController::class, 'showProgress'])->name('show.progress');
    Route::get('/profile', [ProfileController::class, 'showProfileForm'])->name('show.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/password', [ProfileController::class, 'showPasswordForm'])->name('show.password.edit');
    Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');
});

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('show.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('show.register');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/top', [AdminTopController::class, 'showTop'])->name('show.top');
    Route::get('/curriculum_list', [AdminCurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');
    Route::get('/curriculum_create', [AdminCurriculumController::class, 'showCurriculumCreate'])->name('show.curriculum.create');
    Route::get('/curriculum_edit/{id}', [AdminCurriculumController::class, 'showCurriculumEdit'])->name('show.curriculum.edit');
    Route::get('/delivery_edit/{id}', [AdminDeliveryController::class, 'showDeliveryEdit'])->name('show.delivery.edit');
    Route::get('/article_list', [AdminArticleController::class, 'showArticleList'])->name('show.article.list');
    Route::get('/article_create', [AdminArticleController::class, 'showArticleCreate'])->name('show.article.create');
    Route::post('/article_create', [AdminArticleController::class, 'store'])->name('article.create.submit');
    Route::get('/article_edit/{id}', [AdminArticleController::class, 'showArticleEdit'])->name('show.article.edit');
    Route::put('/article_edit/{id}', [AdminArticleController::class, 'update'])->name('article.edit.submit');
    Route::delete('/article_edit/{id}', [AdminArticleController::class, 'destroy'])->name('article.delete');
    Route::get('/banner_edit', [AdminBannerController::class, 'showBannerEdit'])->name('show.banner.edit');
});

Route::redirect('/progress', '/user/progress');
Route::redirect('/profile', '/user/profile');
Route::redirect('/password', '/user/password');
