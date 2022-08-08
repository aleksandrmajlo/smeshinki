@extends('layouts.app')
@section('content')
    <h1 class="mb-3 text-center">Анекдоти</h1>
    <div class="row">
        @foreach( $anecdotes as $anecdote)
            @include('anecdotes.item')
        @endforeach
    </div>
    <div class="row">
        <div class="d-flex justify-content-center NavWrap">
            {!! $anecdotes->links() !!}
        </div>
    </div>

@endsection
