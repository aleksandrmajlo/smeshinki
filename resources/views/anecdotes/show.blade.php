@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">{{$anecdote->title}}</h1>
    @include('all.breadcrumb')
    <div class="row">
        @include('anecdotes.item')
    </div>

@endsection
