@extends('layouts.app')

@section('headers')

@endsection

@section('content')
    <div class="container">
    <div id="updatePost">
        <update-post :post="{{$post}}"></update-post>
    </div>
    </div>
@endsection
