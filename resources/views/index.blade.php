@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-1">
            <h3 class="text-center">Календар</h3>
            <calendar-event datatype="{{$data_type}}"></calendar-event>
        </div>
        <div class="col-lg-6 col-md-12 mb-1">
            <word></word>
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
