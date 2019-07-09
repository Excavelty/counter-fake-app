@extends('layouts.app')

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
          @foreach($posts as $post)
              <div class="card">
                  <div class="card-header">
                      {{$post->title}}
                  </div>
                  <div class="card-body">
                      {{$post->content}}
                  </div>
                  <div class="card-footer">
                      {{$post->created_at}}
                      {{$post->updated_at}}
                  </div>
              </div>
              </br>
              </br>
          @endforeach

          {{$posts->links()}}
        </div>
        @else

        @endif
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="{{ mix('js/app.js') }}"></script>
@endsection
