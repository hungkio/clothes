<?php

use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\SitemapGenerator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('sitemap', function () {
//    SitemapGenerator::create(config('app.url'))->writeToFile(public_path('sitemap.xml'));
//    return "Sitemap generated";
//});
Route::get('/', function () {
    return redirect('/admin');
})->name('home');

Auth::routes();
