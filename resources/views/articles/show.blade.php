@extends('layouts.master')

@section('head-meta')
    <meta name="description" content="{{ $article->description }}">
    <meta name="keywords" content="{{ $article->keywords }}">
@endsection


@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>{{ $article->title }}</h1>
            <p class="blog-post-meta">Created by <a href="#">{{ $article->user->name }}</a> on
                {{ $article->created_at->toFormattedDateString() }}</p>
            <hr>

            <p>{{ $article->body }}</p>
        </div>
    </div>

@endsection