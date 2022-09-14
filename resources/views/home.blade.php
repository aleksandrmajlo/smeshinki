@extends('layouts.app')
@section('content')

    <h1 class="mb-3 text-center">Мої вподобання</h1>

    <div class="row  mb-5">
        <div class="col-lg-12  ">
            <form method="post" action="{{route('user_subs')}}">
                @csrf
                @if($user_sub)
                    <button class="btn btn-primary" type="submit" name="sub" value="2">Відписатися від розсилки</button>
                @else
                 <button class="btn btn-primary" type="submit" name="sub" value="1">Підписатися на розсилку</button>
                @endif
            </form>
        </div>
    </div>



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
