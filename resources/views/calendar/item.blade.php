<div class="col-lg-4 col-md-12 mb-4" id="id{{$post->id}}">
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
            @guest
                <my-favorites :user_id="false" post_id="{{$post->id}}"></my-favorites>
            @else
                <my-favorites user_id="{{Auth::user()->id}}"
                              post_id="{{$post->id}}"
                              :fav="@if(in_array($post->id,$isFav)) true @else false @endif"></my-favorites>
            @endguest
            <rating rating_avg="{{$post->rating_avg}}"
                    post_id="{{$post->id}}"
                    total_votes="{{$post->total_votes}}"
            ></rating>
            @if($post->video)
                <share url="{{$url}}/{{$post->video}}" title="{{$post->title}}" description="{{$post->text}}" post_id="{{$post->id}}"></share>
            @else
                <share url="{{$url}}/{{$post->photo}}" title="{{$post->title}}" description="{{$post->text}}" post_id="{{$post->id}}"></share>
            @endif

            @if(isset($linkCatalog))
                <div class="mt-3 w-100">
                    <a href="/calendar/{{$post->calendar->slug}}#{{$post->id}}"
                       class="btn  btn-outline-primary w-100">Перейти до дати {{$post->calendar->date_write}}</a>
                </div>
            @endif

        </div>
    </div>
</div>
