<?php

use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/llms.txt', [SeoController::class, 'llmsTxt'])->name('llms-txt');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::get('/accounts', [PageController::class, 'accounts'])->name('accounts');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');

Route::post('/forms/{form}/submit', [FormSubmissionController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('forms.submit');
