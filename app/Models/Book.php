<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    /**
     * Filters the books by an specific word in the title
     *
     * @param Builder $query
     * @param string $title the word you want to find on the title
     * @return Builder the books with that word in the title
     */
    public function scopeTitle(Builder $query, string $title): Builder{
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    /**
     * Returns the average rating of a book during a certain time
     *
     * @param Builder $query
     * @param mixed $from
     * @param mixed $to
     * @return Builder
     */
    public function scopeWithAvgRating(Builder $query, mixed $from = null, mixed $to = null): Builder{
        return $query->withAvg(['reviews' => fn(Builder $q) => $this->applyDateFilters($q, $from, $to)], 'rating');
    }

    /**
     * Returns the number of reviews of a book during a certain time
     *
     * @param Builder $query
     * @param mixed $from
     * @param mixed $to
     * @return Builder
     */
    public function scopeWithReviewsCount(Builder $query, mixed $from = null, mixed $to = null): Builder{
        return $query->withCount(['reviews' => fn(Builder $q) => $this->applyDateFilters($q, $from, $to)]);
    }

     /**
      * Returns the best rated books ranked from best to worst. Includes only books with 10 on more reviews.
      *
      * @param Builder $query
      * @param mixed $from restricts the reviews to only reviews since that date
      * @param mixed $to restricts the reviews to only reviews previous to that date
      * @param int $minimum say the minimum number of reviews the book must have
      * @return Builder
      */
    public function scopeBestRated(Builder $query, mixed $from = null, mixed $to = null, int $minimum = 10): Builder{
        return $query->withReviewsCount($from, $to)->withAvgRating($from, $to)->having('reviews_count', '>=', $minimum)->orderBy('reviews_avg_rating', 'desc');
    }

    /**
     * Return the books with the highest number of reviews, no matter the ratings of the reviews
     *
     * @param Builder $query
     * @param mixed $from restricts the reviews to only reviews since that date
     * @param mixed $to restricts the reviews to only reviews previous to that date
     * @return Builder
     */
    public function scopeMostPopular(Builder $query, mixed $from = null, mixed $to = null): Builder{
        return $query->withReviewsCount($from, $to)->having('reviews_count', '>=', 2)->withAvgRating($from, $to)->orderBy('reviews_count', 'desc');
    }

    /**
     * filters the query to an specific period in time
     *
     * @param Builder $query
     * @param mixed $from
     * @param mixed $to
     * @return void
     */
    protected function applyDateFilters(Builder $query, mixed $from, mixed $to): void
    {
        match (true) {
            $from !== null && $to !== null => $query->whereBetween('created_at', [$from, $to]),
            $from !== null => $query->where('created_at', '>=', $from),
            $to !== null => $query->where('created_at', '<=', $to),
            default => null,
        };
    }

    protected static function booted(){
        static::updated(fn (Book $book) => cache()->forget("Book:{$book->id}"));
        static::deleted(fn (Book $book) => cache()->forget("Book:{$book->id}"));
        static::created(fn (Book $book) => cache()->forget("Book:{$book->id}"));
    }

}
