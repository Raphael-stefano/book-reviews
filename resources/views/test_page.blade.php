@extends('layout')

@section('title', 'Testing')

@section('content')

    <h2>Testing</h2>

    <table class="striped">
        <thead>
            <tr>
                <th style="width: 10%;">Id</th>
                <th style="width: 20%;">Book</th>
                <th style="width: 30%">Review</th>
                <th style="width: 20%;">Rating</th>
                <th style="width: 10%;">Created</th>
                <th style="width: 10%;">Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->book->title }}</td>
                    <td>{{ $review->review }}</td>
                    <td>
                        @for ($i = 0; $i < $review->rating; $i++)
                            <i class="small material-icons yellow-text">star</i>
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++)
                            <i class="small material-icons yellow-text">star_border</i>
                        @endfor
                    </td>
                    <td>{{ $review->created_at->format('m/y') }}</td>
                    <td>{{ $review->updated_at->format('m/y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection