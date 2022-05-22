@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-1">
            <h3 class="text-center">Анекдот</h3>
            <anecdote></anecdote>
        </div>
        <div class="col-lg-6 col-md-12 mb-1">
          <word></word>
        </div>
        <div class="col-lg-3 col-md-12 mb-1">
            <h3  class="text-center">Календар</h3>
            <calendar-event  datatype="{{$data_type}}"></calendar-event>
        </div>
    </div>
@endsection
