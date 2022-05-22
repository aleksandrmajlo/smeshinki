@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">{{$calendar->date_write}} </h1>
    <h2 class="mb-5 text-center">{{$calendar->title}}</h2>
    <div class="row justify-content-between mb-5">
{{--        <div class="col-lg-4 ">--}}
            {{--            <a target="_blank" class="btn btn-outline-primary" href="https://t.me/smeshinki_feedback_bot">Прислати привітання</a>--}}
{{--            <a class="btn btn-outline-primary" data-fancybox="dialog" data-src="#formsend">Прислати своє привітання</a>--}}
{{--        </div>--}}
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
{{--    @include('all.form')--}}

@endsection
