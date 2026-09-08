<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/procedimentos/{slug}', [ProcedureController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('procedures'))))
    ->name('procedure');

Route::get('/artigos', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/artigos/{slug}', [ArticleController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('articles'))))
    ->name('article');

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
