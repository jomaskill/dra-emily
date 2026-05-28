<?php

use App\Http\Controllers\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/procedimentos/{slug}', [ProcedureController::class, 'show'])
    ->where('slug', implode('|', array_keys(config('procedures'))))
    ->name('procedure');

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
