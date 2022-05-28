@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">Мої вподобання</h1>
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
@endsection
