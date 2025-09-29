<?php

use Illuminate\Support\Facades\Route;
use App\Models\Admin;

// 管理者コントローラー
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\ResetPasswordController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CurriculumController as AdminCurriculumController;
use App\Http\Controllers\Admin\ArticleController;

// ユーザーコントローラー
use App\Http\Controllers\User\TopController as UserTopController;
use App\Http\Controllers\User\DeliveryController;
use App\Http\Controllers\User\CurriculumController as UserCurriculumController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\ProfileController;

// ================================
// 公開ルート
// ================================
Route::get('/', function () {
    return view('welcome');
});

// ================================
// 管理者用ルート
// ================================
Route::prefix('admin')->name('admin.')->group(function () {

    // ログイン
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('show.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login');
    Route::post('/login/validate', [AdminLoginController::class, 'loginvalidate'])->name('login.validate');

    // ログアウト
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // 新規登録
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register/validate', [RegisterController::class, 'validateRegister'])->name('validate.register');

    // パスワードリセット
    Route::view('/password/reset', 'admin/passwords/email')->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // 管理者トップ
    Route::get('/top', [AdminTopController::class, 'showTop'])->name('show.top')->middleware('auth:admin');

    // バナー管理
    Route::get('/banner_edit', [BannerController::class, 'showBannerEdit'])->name('show.banner.edit')->middleware('auth:admin');
    Route::delete('/banner/{id}', [BannerController::class, 'destroy'])->name('banner.destroy')->middleware('auth:admin');
    Route::post('/banner/register', [BannerController::class, 'register'])->name('banner.register')->middleware('auth:admin');

    // 授業管理
    Route::get('/curriculum_list', [AdminCurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list')->middleware('auth:admin');

    // お知らせ管理
    Route::get('/article_list', [ArticleController::class, 'showArticleList'])->name('show.article.list')->middleware('auth:admin');
});

// ================================
// ユーザー用ルート
// ================================
Route::prefix('user')->name('user.')->group(function () {

    // ログイン
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('show.login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');

    // ログアウト
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

    // 時間割ページ
    Route::get('/curriculum_list', [UserCurriculumController::class, 'showCurriculumList'])->name('show.curriculum');

    // 月切り替え（AJAX）
    Route::get('/curriculums/month', [UserCurriculumController::class, 'getByMonth'])->name('curriculums.month');

    // 学年切り替え（AJAX）
    Route::get('/curriculums/grade', [UserCurriculumController::class, 'getByGrade'])->name('curriculums.grade');

    // 配信ページ
    Route::get('/delivery/{id}', [DeliveryController::class, 'showDelivery'])->name('show.delivery');

    // 授業進捗
    Route::get('/progress', [ProgressController::class, 'showProgress'])->name('show.progress');

    // プロフィール設定
    Route::get('/profile', [ProfileController::class, 'showProfileForm'])->name('show.profile');
});

