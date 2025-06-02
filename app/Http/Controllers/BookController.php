<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $title = $request->input('title');
        $filter = $request->input('filter');

        $cacheKey = "books:{$filter}:{$title}";
        
        $books = cache()->remember($cacheKey, now()->addHour(), function() use ($title, $filter){
            return Book::when(
                $title,
                fn($query, $title) => $query->title($title)
            )->when(
                $filter,
                function($query) use ($filter) {
                    return $this->applyFilter($query, $filter);
                }
            )->when($filter === null || $filter === '', function($query) {
                return $query->latest()->withReviewsCount()->withAvgRating();
            })->get();
        });

        return view('books/index', [
            'books' => $books,
            'filter' => $filter,
        ]);
    }

    private function applyFilter($query, $filter){
        switch($filter){
            case 'popular_last_month': 
                return $query->mostPopular(Carbon::now()->subMonth());
            case 'popular_last_6months': 
                return $query->mostPopular(Carbon::now()->subMonths(6))->orderBy('reviews_avg_rating', 'desc');
            case 'highest_rated_last_month': 
                return $query->bestRated(Carbon::now()->subMonth(), null, 2);
            case 'highest_rated_last_6months': 
                return $query->bestRated(Carbon::now()->subMonths(6), null, 4);
            default:
                return $query;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {

        $cacheKey = "Book:{$book->id}";
        $book = cache()->remember($cacheKey, now()->addHour(), function() use($book){
            return $book->load([
                'reviews' => function($query) {
                    $query->latest();
                }
            ])->loadAvg('reviews', 'rating')
            ->loadCount('reviews');
        });

        return view('books/show', [
            'book' => $book
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
