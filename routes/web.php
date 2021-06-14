<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', function () {
        return Inertia::render('Admin/Auth/Login');
    });
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

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
