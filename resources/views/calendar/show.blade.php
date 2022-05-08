@extends('layouts.app')
@section('content')
    <h1 class="mb-5 text-center">{{$calendar->date_write}} - {{$calendar->title}}</h1>
    <div class="row mb-5">
        <div class="col-lg-4 ">
            <a target="_blank" class="btn btn-outline-primary" href="https://t.me/smeshinki_feedback_bot">Прислати привітання</a>
        </div>

    </div>
    <div class="row">
        @foreach( $posts as $post)
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card">
                    @if($post->photo)
                        <div class="bg-image hover-overlay ripple mb-3" data-mdb-ripple-color="light">
                            <img src="{{$url}}/{{$post->photo}}" class="img-fluid"/>
                            <a data-fancybox href="{{$url}}/{{$post->photo}}">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </a>
                        </div>
                    @endif
                    @if($post->video)
                        <div class="player-container mb-3">
                            <vue-core-video-player
                                :autoplay="false"
                                src="{{$url}}/{{$post->video}}"
                            ></vue-core-video-player>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text mb-3">
                            {!! $post->text !!}
                        </p>
                        {{--                            <a href="#!" class="btn btn-primary">Read</a>--}}
                        @if($post->video)
                            <share url="{{$url}}/{{$post->video}}" title="{{$post->title}}" description="{{$post->text}}"/>
                        @else
                            <share url="{{$url}}/{{$post->photo}}" title="{{$post->title}}" description="{{$post->text}}"/>
                        @endif
                    </div>


                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="d-flex justify-content-center NavWrap">
            {!! $posts->links() !!}
        </div>
    </div>
@endsection
