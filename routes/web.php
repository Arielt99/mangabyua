<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Mangaka\AuthController as MangakaAuthController;
use App\Http\Controllers\Mangaka\ChapterController;
use App\Http\Controllers\Mangaka\MangaController;
use App\Http\Controllers\Mangaka\MangakaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
        Route::get('/mangas', [MangaController::class, 'index'])->name('mangas.index');
        Route::get('/mangas/create', [MangaController::class, 'create'])->name('mangas.create');
        Route::post('/mangas', [MangaController::class, 'store'])->name('mangas.store');

        Route::get('/mangas/{manga}', [MangaController::class, 'show'])->name('mangas.show');
        Route::get('/mangas/{manga}/edit', [MangaController::class, 'edit'])->name('mangas.edit');
        Route::post('/mangas/{manga}', [MangaController::class, 'update'])->name('mangas.update');
        Route::delete('/mangas/{manga}', [MangaController::class, 'destroy'])->name('mangas.destroy');

        /**
         * Manage the chapters.
         */
        Route::get('/mangas/{manga}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
        Route::post('/mangas/{manga}/chapters', [ChapterController::class, 'store'])->name('chapters.store');

        Route::get('/mangas/{manga}/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');
        Route::delete('/mangas/{manga}/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    });

});
