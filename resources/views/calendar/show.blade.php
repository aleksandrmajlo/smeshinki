@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">{{$calendar->date_write}} </h1>
    @if($calendar->holidays->isNotEmpty())
        <h2 class="mb-3 text-center">Свята:</h2>
        <div class="row mb-5">
            <div class="col-4">
                <div class="list-group" id="myList" role="tablist">
                    @foreach($calendar->holidays as $item)
                      <a class="list-group-item list-group-item-action @if( $loop->index ===0) active @endif" data-toggle="list" href="#{{$item->slug}}" role="tab">{{$item->title}}</a>
                    @endforeach
                </div>

            </div>
            <div class="col-8">
                <div class="tab-content">
                    @foreach($calendar->holidays as $item)
                       <div class="tab-pane  @if( $loop->index ===0) active @endif" id="{{$item->slug}}" role="tabpanel">{{$item->description}}</div>
                    @endforeach
                </div>
            </div>

        </div>
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
