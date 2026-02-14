<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GamesController;

Route::get('/', [GamesController::class, 'index'])->name('index');

Route::get('/games', [GamesController::class, 'gamesIndex'])->name('games.index');
Route::get('/reviews', [GamesController::class, 'reviewsIndex'])->name('reviews.index');
Route::get('/coming-soon', [GamesController::class, 'comingSoonIndex'])->name('coming-soon.index');

Route::get('/games/{slug}', [GamesController::class, 'show'])
    ->name('games.show')
    ->where('slug', '[a-zA-Z0-9-]+');

require __DIR__.'/auth.php';
