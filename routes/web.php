<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
})->name('home');*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/article', [ArticleController::class, 'index']);

//Route::get('/newdashboard', [DashboardController::class, 'index'])->name('newdashboard');

Route::get('/register', [RegisterController::class, 'index']);

Route::get('/explore', [ExploreController::class, 'index']);

Route::get('/posts/{id}/image', [PostController::class, 'showImage'])->name('posts.image');

Route::get('/newdashboard', [DashboardController::class, 'index'])->middleware('auth')->name('newdashboard');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/login', function () {
    return redirect('/')
    ->with('access_denied', true);
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/create-post', [PostController::class, 'store'])->name('posts.store');

Route::delete('/destroy-post/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/api/check-user/{id}', [UserController::class, 'checkUser']);

Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article.show');

//Route::get('/article/{id}', [PostController::class, 'show'])->name('article.show');

Route::post('/create-comment', [CommentController::class, 'store'])->middleware('auth')->name('comment.store');

Route::get('/explore', [ArticleController::class, 'explore'])->name('explore');

Route::get('/newdashboard/sort', [DashboardController::class, 'sortPosts'])->middleware('auth')->name('dashboard.sort');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/newdashboard/edit-draft/{id}', [PostController::class, 'editDraft'])->name('posts.editDraft');

Route::put('/newdashboard/update-post/{id}', [PostController::class, 'update'])->name('posts.update');

Route::put('/posts/{post}/status', [PostController::class, 'updateStatus'])->name('posts.updateStatus');