<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Mangaka\AuthController as MangakaAuthController;
use App\Http\Controllers\Mangaka\MangaController;
use App\Http\Controllers\Mangaka\MangakaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

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
if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/**
 * Admin routes.
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', function () {
        return Inertia::render('Admin/Auth/Login');
    });
    Route::post('/login', [AdminAuthController::class, 'authenticate'])->name('login');

    Route::group(['middleware' => 'auth','role:Super-Admin'], function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        /**
         * Manage the users.
         */
        Route::resource('users', UserController::class);

        /**
         * Manage the tags.
         */
        Route::resource('tags', TagController::class);
    });

});

/**
 * Mangaka routes.
 */
Route::group(['prefix' => 'mangaka', 'as' => 'mangaka.'], function () {
    Route::get('/login', function () {
        return Inertia::render('Mangaka/Auth/Login');
    });
    Route::post('/login', [MangakaAuthController::class, 'authenticate'])->name('login');

    Route::group(['middleware' => 'auth','role:Mangaka'], function () {
        Route::get('/dashboard', [MangakaController::class, 'index'])->name('dashboard');

        /**
         * Manage the mangas.
         */
        Route::resource('mangas', MangaController::class);
    });

});
