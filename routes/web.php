<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [UserController::class, 'showCorrectPage']);
Route::get('/post', [ExampleController::class, 'getPost']);

Route::post('/register', [UserController::class, 'register'])->name('users.register');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');
