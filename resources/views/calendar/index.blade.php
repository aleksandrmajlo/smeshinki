@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">Календар</h1>
    <div class="row justify-content-between mb-5">
        <div class="col-lg-4  ">
            @include('calendar.sort')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-1">
            <h3 class="text-center">Анекдот</h3>
            <anecdote></anecdote>
        </div>
        <div class="col-lg-6 col-md-12 mb-1">
            <posts-all></posts-all>
        </div>
        <div class="col-lg-3 col-md-12 mb-1">
            <calendar-all datatype="{{$data_type}}"></calendar-all>
        </div>
    </div>
@endsection
