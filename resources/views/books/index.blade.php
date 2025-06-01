@extends('layout')

@section('title', 'Testing')

@section('content')

    <h2 style="margin-bottom: 50px" class="center-align">Welcome!</h2>

    <div class="row">
        <form method="get" action="{{ route('books.index') }}">
            <div class="input-field col s5  offset-s1">
                <input value="{{ request('title') }}" id="search" type="text" class="validate" name="title">
                <label class="active" for="search">Search by Title</label>
            </div>
            <button style="margin-top: 15px;" class="btn waves-effect waves-light col s1" type="submit">Search
                <i class="material-icons right">send</i>
            </button>
            <input type="hidden" name="filter" value="{{ $filter }}">
        </form>
        <a style="margin-top: 15px;  margin-left: 15px" class="btn waves-effect waves-light col s2" href="{{ route('books.index') }}">
            <i class="material-icons left">clear</i>
            Clear Filters
        </a>
    </div>

    <div class="row">
        <ul class="collapsible col l10 offset-l1">
            <li>
                <div class="collapsible-header">Filters</div>
                <div style="padding: 0" class="collapsible-body collection ">
                        @php
                            $filters = [
                                '' => 'Latest',
                                'popular_last_month' => 'Popular Last Month',
                                'popular_last_6months' => 'Popular Last 6 Months',
                                'highest_rated_last_month' => 'Highest Rated Last Month',
                                'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
                            ];
                        @endphp
                        @foreach ($filters as $key => $label)
                            <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}" class="collection-item {{ $filter == $key ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                </div>
            </li>
        </ul>
    </div>

    

    @foreach ($books as $book)
        <div class="row">
            <div class="col l10 offset-l1">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">{{ $book->title }}</span>
                        <p>by {{ $book->author }}</p>
                    </div>
                    <div style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;" class="card-action">
                        <div class="valign-wrapper">
                            <span class="amber-text accent-4">{{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }} - </span>
                            <span class="amber-text accent-4">
                                @php
                                    $star = round($book->reviews_avg_rating * 2) / 2;
                                @endphp
                                @for ($i = 0; $i < floor($star); $i++)
                                    <i class="small material-icons amber-text accent-4">star</i>
                                @endfor
                                @if (floor($star) != $star)
                                    <i class="small material-icons amber-text accent-4">star_half</i>
                                    @for ($i = ceil($star); $i < 5; $i++)
                                        <i class="small material-icons amber-text accent-4">star_border</i>
                                    @endfor
                                @else
                                    @for ($i = $star; $i < 5; $i++)
                                        <i class="small material-icons amber-text accent-4">star_border</i>
                                    @endfor
                                @endif
                            </span>
                        </div>
                        <div>
                            <a href="#" style="text-transform: uppercase" class="amber-text accent-4">View Book</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection