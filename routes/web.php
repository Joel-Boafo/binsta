<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [PostController::class, 'feed'])
    ->name('home');

Route::get('/login', [AuthController::class, 'login'])
    ->name('users.login');

Route::post('/login', [AuthController::class, 'loginPost'])
    ->name('users.login.post');

Route::get('/register', [AuthController::class, 'register'])
    ->name('users.register');

Route::post('/register', [AuthController::class, 'registerPost'])
    ->name('users.register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('users.logout');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profiles.edit');

    Route::put('/profile/lorenz', [ProfileController::class, 'update'])
        ->name('profiles.lorenz');

    Route::get('/profile/{username}', [ProfileController::class, 'show'])
        ->name('profiles.show');

    Route::delete('/profile/delete', [ProfileController::class, 'deleteProfile'])
        ->name('profiles.delete');

    Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])
        ->name('profiles.update-profile-picture');

    Route::get('/profile/edit/password', [ProfileController::class, 'editPassword'])
        ->name('profiles.edit-password');

    Route::put('/profile/update/password', [ProfileController::class, 'updatePassword'])
        ->name('profiles.update-password');

    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts/create', [PostController::class, 'createPost'])
        ->name('posts.create.post');

    Route::post('/posts/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/update', [PostController::class, 'updatePost'])
        ->name('posts.update');

    Route::post('/posts/like', [PostController::class, 'likePost'])
        ->name('posts.like');

    Route::post('/posts/comment', [PostController::class, 'placeComment'])
        ->name('posts.comment');

    Route::delete('/posts/comment/delete/{comment}', [PostController::class, 'deleteComment'])
        ->name('posts.comment.delete');

    Route::delete('/posts/delete/{post}', [PostController::class, 'deletePost'])
        ->name('posts.delete');

    Route::get('/posts/{post}', [PostController::class, 'show'])
        ->name('posts.show');

    Route::get('/profiles/search', [ProfileController::class, 'search'])
        ->name('profiles.search');
});
