<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::permanentRedirect('/procedimentos/botox', '/procedimentos/toxina-botulinica');
Route::permanentRedirect('/procedimentos/bichectomia', '/procedimentos/harmonizacao-facial');

Route::get('/procedimentos/{slug}', [ProcedureController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('procedures'))))
    ->name('procedure');

Route::get('/artigos', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/artigos/tema/{slug}', [ArticleController::class, 'topic'])
    ->where('slug', implode('|', array_keys(config('topics'))))
    ->name('articles.topic');

Route::get('/artigos/{slug}', [ArticleController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('articles'))))
    ->name('article');

Route::get('/dra-emily-beatriz', [ArticleController::class, 'author'])->name('author');

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
