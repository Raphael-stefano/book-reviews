@php
    $star = round($rating * 2) / 2;
@endphp
@for ($i = 0; $i < floor($star); $i++)
    <i class="{{ $size }} material-icons {{ $color }}">star</i>
@endfor
@if (floor($star) != $star)
    <i class="{{ $size }} material-icons {{ $color }}">star_half</i>
    @for ($i = ceil($star); $i < 5; $i++)
        <i class="{{ $size }} material-icons {{ $color }}">star_border</i>
    @endfor
@else
    @for ($i = $star; $i < 5; $i++)
        <i class="{{ $size }} material-icons {{ $color }}">star_border</i>
    @endfor
@endif