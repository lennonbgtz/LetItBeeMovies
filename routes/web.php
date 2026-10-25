<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
    ->middleware('auth')
    ->name('reviews.destroy');

Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])
    ->middleware('auth')
    ->name('reviews.edit');

Route::put('/reviews/{review}', [ReviewController::class, 'update'])
    ->middleware('auth')
    ->name('reviews.update');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminMovieController::class, 'index'])->name('admin.index');

        Route::get('/movies/create', [\App\Http\Controllers\Admin\AdminMovieController::class, 'create'])->name('admin.movies.create');
        Route::post('/movies', [\App\Http\Controllers\Admin\AdminMovieController::class, 'store'])->name('admin.movies.store');
        Route::get('/movies/{movie}/edit', [\App\Http\Controllers\Admin\AdminMovieController::class, 'edit'])->name('admin.movies.edit');
        Route::put('/movies/{movie}', [\App\Http\Controllers\Admin\AdminMovieController::class, 'update'])->name('admin.movies.update');
        Route::delete('/movies/{movie}', [\App\Http\Controllers\Admin\AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');
        Route::patch('/movies/{movie}/reviewed', [\App\Http\Controllers\Admin\AdminMovieController::class, 'toggleReviewed'])->name('admin.movies.reviewed');

        Route::get('/movies/{movie}/scenes', [\App\Http\Controllers\Admin\AdminSceneController::class, 'index'])->name('admin.scenes.index');
        Route::post('/movies/{movie}/scenes', [\App\Http\Controllers\Admin\AdminSceneController::class, 'store'])->name('admin.scenes.store');
        Route::delete('/movies/{movie}/scenes/{scene}', [\App\Http\Controllers\Admin\AdminSceneController::class, 'destroy'])->name('admin.scenes.destroy');
        Route::get('/movies/{movie}/scenes/{scene}/edit', [\App\Http\Controllers\Admin\AdminSceneController::class, 'edit'])->name('admin.scenes.edit');
        Route::put('/movies/{movie}/scenes/{scene}', [\App\Http\Controllers\Admin\AdminSceneController::class, 'update'])->name('admin.scenes.update');

    });

require __DIR__.'/auth.php';