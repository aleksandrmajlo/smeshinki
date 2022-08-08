<div class="col-lg-3 col-md-12 mb-4 " id="{{$anecdote->id}}_anectode" >

    <div class="card anectodeCard pt-4" style="@php
        $colorLink='';
        foreach ($colors[$loop->index ] as $pr=>$v){
              if($pr=='color'){
                 $colorLink=$v;
              }
              echo $pr.':'.$v.' !important;';
        }
         @endphp">
        <h5 class="card-title text-center">{{$anecdote->title}}</h5>
        <p class="card-text mb-3 p-3">
            {!! $anecdote->description !!}
        </p>
        <div class="p-3  text-center">
            <div class=" mb-2">
                <share url="{{$url}}/anecdote/{{$anecdote->slug}}"
                       title="{{$anecdote->title}}"
                       color="{{$colorLink}}"
                       description="{{$anecdote->description}}"></share>
            </div>
            <div class="">
                    <rating-like    post_type="anecdote"
                                    color="{{$colorLink}}"
                                    :likes="{{json_encode($anecdote->likes) }}"
                                    total_votes ="{{$anecdote->total_votes}}"
                                    post_id="{{$anecdote->id}}"></rating-like>
            </div>
        </div>
    </div>
</div>
