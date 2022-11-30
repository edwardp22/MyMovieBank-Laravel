<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'App\Http\Controllers\Movies@showingNow')->name('movies.shownow');
Route::get('/coming', 'App\Http\Controllers\Movies@comingSoon')->name('movies.coming');
Route::get('/top', 'App\Http\Controllers\Movies@top')->name('movies.top');
Route::get('/popular', 'App\Http\Controllers\Movies@popular')->name('movies.popular');
Route::get('/favorites', 'App\Http\Controllers\Movies@favorites')->name('favorite.show');
Route::get('/wishlist', 'App\Http\Controllers\Movies@wishList')->name('wishlist.show');
Route::get('/about', 'App\Http\Controllers\Movies@about')->name('movies.about');
Route::get('/contact', 'App\Http\Controllers\Movies@contact')->name('movies.contact');
Route::get('/favorite/{id}/toggle', 'App\Http\Controllers\Movies@toggleFavorite')->name('favorite.toggle');
Route::get('/wishlist/{id}/toggle', 'App\Http\Controllers\Movies@toggleWishList')->name('wishlist.toggle');

Route::get('/movie/{id}/show', 'App\Http\Controllers\Movies@showMovie')->name('movie.show');

Route::post('/comment/{id}/add', 'App\Http\Controllers\Movies@addComment')->name('comment.add');
Route::post('/comment/{id}/edit', 'App\Http\Controllers\Movies@editComment')->name('comment.edit');
Route::get('/comment/{id}/delete', 'App\Http\Controllers\Movies@deleteComment')->name('comment.delete');
Route::get('/comment/{id}/editor', 'App\Http\Controllers\Movies@editor')->name('comment.editor');

Route::get('/profile', 'App\Http\Controllers\Movies@profile')->name('user.profile');
Route::post('/profile/update', 'App\Http\Controllers\Movies@profileUpdate')->name('user.update');

Auth::routes();