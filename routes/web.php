<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $book = Book::find(62);
    //$book = Book::MostPopular(1)->first();
    $reviews = $book->reviews;

    return view('test_page', [
        'reviews' => $reviews,
    ]);
});

Route::prefix('books')->as('books.')->group(function () {
    Route::get('/popular', [BookController::class, 'popular'])->name('popular');
    Route::get('/best-rated', [BookController::class, 'bestRated'])->name('best-rated');
});

// CRUD basic routes united
Route::resource('books', BookController::class)->only(['index', 'show']);
Route::resource('books.reviews', ReviewController::class)->scoped(['review' => 'book'])->only(['create', 'store']);
