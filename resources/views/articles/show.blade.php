@extends('layouts.master')

@section('head-meta')
    <meta name="description" content="{{ $article->description }}">
    <meta name="keywords" content="{{ $article->keywords }}">
@endsection


@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="panel">
                <h2>{{ $article->title }}</h2>
                <p>Created by <a href="#">User</a> on {{ $article->created_at }}</p>
                <hr>

                <p>{{ $article->body }}</p>
            </div>
        </div>
    </div>

@endsection