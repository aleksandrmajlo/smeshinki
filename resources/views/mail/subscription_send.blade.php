<h2>Нові зображення</h2>
@foreach($words as $word)
    <p style="text-align: center">
       <img src="{{$url}}/{{$word->photo}}" style="max-width:580px; margin:0 auto;" >
    </p>
@endforeach
<h2>Анекдоти</h2>
@foreach($anecdotes as $anecdote)
         <h4>{{$anecdote->title}}</h4>
         <div>
             {!! $anecdote->description  !!}
         </div>
@endforeach
