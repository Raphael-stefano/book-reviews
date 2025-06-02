@extends('layout')

@section('title', $book->title)

@section('content')

    <div class="row">

        @if(session('success'))
            <div class="row">
                <div class="col l6 offset-l2">
                    <x-flash-message :message="session('success')" color="green darken-4" />
                </div>
            </div>
        @endif

        <a style="margin-top: 15px;" class="btn waves-effect waves-light col l2 offset-l2 black" href="{{ route('books.index') }}">Go Back Home
            <i class="material-icons left">chevron_left</i>
        </a>
        <h4 class="col l8 offset-l2">{{ $book->title }}</h4>
        <span class="col l8 offset-l2">by {{ $book->author }}</span>
        <span class="col l8 offset-l2">Published in {{ $book->created_at->format('d/m/Y') }}</span>
        <span class="col l8 offset-l2 valign-wrapper">
            <x-star-rating :rating="$book->reviews_avg_rating" size="tiny" color="text-black"/> - {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
        </span>

        <div class="col l8 offset-l2">

            <div style="display: flex; align-items: center">

                <h4 style="margin-right: 20px">Reviews</h4>

                <a style="margin-top: 15px;" class="btn waves-effect waves-light black" href="{{ route('books.reviews.create', $book) }}">New Review
                    <i class="material-icons right">edit</i>
                </a>

            </div>
            

            @forelse ($book->reviews as $review)
                <div class="card horizontal">
                    <div class="card-stacked">
                        <div style="padding-bottom: 0" class="card-action">
                            <x-star-rating :rating="$review->rating" size="small" color="amber-text accent-4"/>
                            <span class="right amber-text accent-4">{{ $review->created_at->format('M j, Y') }}</span>
                        </div>
                        <div style="padding-top: 0" class="card-content">
                            <p>{{ $review->review }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card horizontal">
                    <div class="card-stacked">
                        <div style="padding-bottom: 0" class="card-action">
                            <i class="small material-icons amber-text accent-4">star_border</i>
                            <i class="small material-icons amber-text accent-4">star_border</i>
                            <i class="small material-icons amber-text accent-4">star_border</i>
                            <i class="small material-icons amber-text accent-4">star_border</i>
                            <i class="small material-icons amber-text accent-4">star_border</i>
                            <span class="right amber-text accent-4">Mmm d, yyyy</span>
                        </div>
                        <div style="padding-top: 0" class="card-content">
                            <p>We coudn't find any review for this book. Sorry!</p>
                        </div>
                    </div>
                </div>
            @endforelse

        </div>

    </div>

@endsection