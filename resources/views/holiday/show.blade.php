@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">{{$holiday->title}} </h1>
    @if($holiday->calendars)
        @foreach($holiday->calendars as $calendar)
            <h4 class="mb-3 text-center">{{$calendar->date_write}}</h4>
        @endforeach
    @endif
    @if($holiday->description)
        <p>
            {!! $holiday->description !!}
        </p>
    @endif
    <div class="row justify-content-between mb-5">
        <div class="col-lg-4  ">
            @include('calendar.sort')
        </div>
    </div>

    <div class="row">
        @foreach( $posts as $post)
            @include('calendar.item')
        @endforeach
    </div>
    <div class="row">
        <div class="d-flex justify-content-center NavWrap">
            {!! $posts->links() !!}
        </div>
    </div>

@endsection
