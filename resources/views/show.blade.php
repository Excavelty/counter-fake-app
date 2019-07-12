@extends('layouts.app')

@section('content')
    <div class="container">
          <div class="card">
          <div class="card-header">
              <h3>{{$post->title}}</h3>
          </div>
          <div class="card-body">
              {{$post->content}}
          </div>
          <div class="card-footer">
          Utworzono dnia: {{$post->created_at}}, ostatnia edycja: {{$post->updated_at}}
          </div>
          </br></br>
          <div id="showComments">
              <show-comments :post-id="{{$post->id}}"></show-comments>
          </div>
    </div>
@endsection
