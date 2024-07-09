<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;

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

 //* User Related Route
Route::get('/', [UserController::class, 'showCorrectPage'])->name('home.feed');
Route::post('/register', [UserController::class, 'register'])->name('users.register');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');

//* Post Related Route
Route::get('/create-post', [PostController::class, 'createPost'])->name('posts.create');
Route::post('/create-post', [PostController::class, 'storePost'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'showPost'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'showEditForm'])->name('posts.edit');
Route::put('/posts/{post}/update', [PostController::class, 'updatePost'])
->middleware('can:update,post')->name('posts.update');
Route::delete('/posts/{post}/delete', [PostController::class, 'deletePost'])
->middleware('can:delete,post')->name('posts.destroy');

//* Profile Related Route
Route::get('/users/{user:username}', [UserController::class, 'showUserProfile'])->name('users.profile');