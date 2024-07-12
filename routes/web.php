<?php

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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

Route::get('admin-only', function () {
    return 'This is page for admin';
})->middleware('can:visitAdmin,user');

//* User Related Route
Route::get('/', [UserController::class, 'showCorrectPage'])->name('home.feed');
Route::post('/register', [UserController::class, 'register'])->name('users.register');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');

//* Follow Related Route
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow'])->middleware('mustBeLoggedIn')
->name('follow.create');
Route::delete('/remove-follow/{user:username}', [FollowController::class, 'removeFollow'])->middleware('mustBeLoggedIn')
->name('follow.remove');

//* Post Related Route
Route::get('/create-post', [PostController::class, 'createPost'])->name('posts.create')->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storePost'])->name('posts.store')->middleware('mustBeLoggedIn');
Route::get('/posts/{post}', [PostController::class, 'showPost'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'showEditForm'])->name('posts.edit');
Route::put('/posts/{post}/update', [PostController::class, 'updatePost'])
    ->middleware('can:update,post')->name('posts.update');
Route::delete('/posts/{post}/delete', [PostController::class, 'deletePost'])
    ->middleware('can:delete,post')->name('posts.destroy');

//* Profile Related Route
Route::get('/profile/{user:username}', [UserController::class, 'showUserProfile'])->name('users.profile');
Route::get('/profile/{user:username}/followers', [UserController::class, 'showUserFollowers'])->name('users.followers');
Route::get('/profile/{user:username}/following', [UserController::class, 'showUserFollowing'])->name('users.following');
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm'])->middleware('mustBeLoggedIn')->name('users.avatar.edit');
Route::put('/manage-avatar', [UserController::class, 'updateAvatar'])->middleware('mustBeLoggedIn')->name('users.avatar.update');
