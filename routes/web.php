<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testerController;
use App\Http\Controllers\authController;

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

Route::get('/', [testerController::class, 'index']) -> name('home');

Route::get('/create', [testerController::class, 'testCreateGet']) -> name('create') -> middleware('auth');
Route::post('/create', [testerController::class, 'testCreatePost']) -> name('createPost') -> middleware('auth');

Route::get('/FAQ', [testerController::class, 'faqView']) -> name('faq.view');

Route::get('/test', [testerController::class, 'testSearchGet']) -> name('test.search');

Route::get('/test/{id}', [testerController::class, 'testViewGet']) -> name('test.view') -> middleware('auth');
Route::post('/test/{id}', [testerController::class, 'testViewPost']) -> name('test.check') -> middleware('auth');

Route::get('/result/{id}', [testerController::class, 'resultView']) -> name('results') -> middleware('auth');

Route::get('/test/{id}/info', [testerController::class, 'testInfoView']) -> name('test.info');

/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); 
*/


Route::get('/login', [authController::class, 'loginView']) -> name('login.view');
Route::post('/login', [authController::class, 'login']) -> name('login');

Route::get('/signin', [authController::class, 'registerView']) -> name('register.view');
Route::post('/signin', [authController::class, 'register']) -> name('register');

Route::get('/logout', [authController::class, 'logout']) -> name('logout');

Route::get('/profile', [authController::class, 'profile']) -> name('profile') -> middleware('auth');