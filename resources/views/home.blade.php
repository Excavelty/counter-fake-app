@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        <div id="addPostForm">
          <add-post-form></add-post-form>
        </div>
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="{{ mix('js/app.js') }}"></script>
@endsection
