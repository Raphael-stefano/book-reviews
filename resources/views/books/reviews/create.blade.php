@extends('layout')

@section('title', 'Home')

@section('content')

    <h2 class='center'>New Review</h2>

    <div class="row container">
        <form class="col s12" method="post" action="{{ route('books.reviews.store', $book) }}">
        @csrf
            <div class="row">

                <div class="input-field col s12">
                    <textarea id="review" name="review" class="materialize-textarea">{{ old('review') }}</textarea>
                    <label for="review">Type your review</label>
                    @error('review')
                        <div class="row">
                            <div class="col l6">
                                <x-flash-message :message="$message" color="red darken-4" />
                            </div>
                        </div>
                    @enderror
                </div>

                <div style="margin-bottom: 40px" class="input-field col s12">
                    <select name="rating">
                        <option value="" disabled selected>Rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                    <label>Give Your Rating</label>
                    @error('rating')
                        <div class="row">
                            <div class="col l6">
                                <x-flash-message :message="$message" color="red darken-4" />
                            </div>
                        </div>
                    @enderror
                </div>

                <div style="margin-left: 10px" class="input-field">
                    <button class="btn waves-effect waves-light col l4 light-blue darken-4" type="submit">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </div>

            </div>
        </form>
    </div>

@endsection