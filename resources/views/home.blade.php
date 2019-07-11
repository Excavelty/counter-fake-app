@extends('layouts.app')

@section('styles')
<link href="{{asset('css/fontello-753e3726/css/fontello.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="">
        <div id="addPostForm">
            <add-post-form></add-post-form>
        </div>
        </br>
        </br>
        @if($posts)
        <div>
          {{$posts->links()}}
          <div id="getVotes">
          @foreach($posts as $post)
              <div class="card">
                  <div class="card-header">
                      <h3>{{$post->title}}</h3>
                  </div>
                  <div class="card-body">
                      {{str_limit($post->content, 500, $end = '...')}}
                      <a href="/show/{{$post->id}}" target="_blank">Zobacz więcej</a>
                          <get-votes :post-id="{{$post->id}}">
                          </get-votes>
                  </div>
                  <div class="card-footer">
                      {{$post->created_at}}
                      {{$post->updated_at}}
                      @if(Auth::user()->id === $post->authorId)
                          <a href="/update/{{$post->id}}" target="_blank"><button class="btn btn-warning">Edytuj</button></a>
                      @endif
                  </div>
              </div>
              </br>
              </br>
          @endforeach
        </div>
        </div>
        @else

        @endif
    </div>
</div>
@endsection
