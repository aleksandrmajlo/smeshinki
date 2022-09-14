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
            <calendar-all datatype="{{$data_type}}"></calendar-all>
        </div>
        <div class="col-lg-6 col-md-12 mb-1">
            <posts-all></posts-all>
        </div>
        <div class="col-lg-3 col-md-12 mb-1">
            <a href="{{route('anecdotes.index')}}" class="h3 text-center d-block link_default">
                Анекдот
            </a>
            {{--            @guest--}}
            <anecdote auth="1"></anecdote>
            {{--            @else--}}
            {{--                <anecdote auth="2"></anecdote>--}}
            {{--            @endguest--}}
            @guest
                <div class="card mb-5 ">
                    <div class="card-body">
                        <div class="text-center mb-2">
                            <a href="#" data-fancybox="dialog"
                               data-src="#form_subscription" class="btn btn-outline-primary">Підписатися на розсилання</a>
                        </div>
                    </div>
                </div>
            @endguest
        </div>

    </div>
@endsection
