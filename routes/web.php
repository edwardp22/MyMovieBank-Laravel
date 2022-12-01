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

// Pages
Route::get('/', 'App\Http\Controllers\PagesController@showingNow')->name('movies.shownow');
Route::get('/coming', 'App\Http\Controllers\PagesController@comingSoon')->name('movies.coming');
Route::get('/top', 'App\Http\Controllers\PagesController@top')->name('movies.top');
Route::get('/popular', 'App\Http\Controllers\PagesController@popular')->name('movies.popular');
Route::get('/about', 'App\Http\Controllers\PagesController@about')->name('movies.about');
Route::get('/contact', 'App\Http\Controllers\PagesController@contact')->name('movies.contact');
Route::get('/movie/{id}/show', 'App\Http\Controllers\PagesController@showMovie')->name('movie.show');

// Favorite: CRUD
Route::get('/favorites', 'App\Http\Controllers\FavoritesController@show')->name('favorite.show');
Route::get('/favorite/{id}/toggle', 'App\Http\Controllers\FavoritesController@toggleFavorite')->name('favorite.toggle');
Route::post('/favorite/{id}/edit', 'App\Http\Controllers\FavoritesController@editFavorite')->name('favorite.edit');

// Favorite: Read, Create, and delete
Route::get('/wishlist', 'App\Http\Controllers\WishesController@show')->name('wishlist.show');
Route::get('/wishlist/{id}/toggle', 'App\Http\Controllers\WishesController@toggleWishList')->name('wishlist.toggle');

// Comments: CRUD, Read in movie.show
Route::get('/comment/{id}/editor', 'App\Http\Controllers\CommentsController@editor')->name('comment.editor');
Route::post('/comment/{id}/add', 'App\Http\Controllers\CommentsController@addComment')->name('comment.add');
Route::post('/comment/{id}/edit', 'App\Http\Controllers\CommentsController@editComment')->name('comment.edit');
Route::get('/comment/{id}/delete', 'App\Http\Controllers\CommentsController@deleteComment')->name('comment.delete');

// User: Read and Update
Route::get('/profile', 'App\Http\Controllers\UsersController@profile')->name('user.profile');
Route::post('/profile/update', 'App\Http\Controllers\UsersController@profileUpdate')->name('user.update');

// Notes: Create and Update, Read in movie.show
Route::post('/note/{id}/add', 'App\Http\Controllers\NotesController@addNote')->name('note.add');

Auth::routes();