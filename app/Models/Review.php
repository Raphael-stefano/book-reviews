<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function book(){
        return $this->belongsTo(Book::class);
    }

    protected $fillable = [
        'review',
        'rating'
    ];

    protected static function booted(){
        static::updated(fn (Review $review) => cache()->forget("Book:{$review->book_id}"));
        static::deleted(fn (Review $review) => cache()->forget("Book:{$review->book_id}"));
        static::created(fn (Review $review) => cache()->forget("Book:{$review->book_id}"));
    }
}
