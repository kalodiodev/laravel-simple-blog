@extends('layouts.master')

@section('head-meta')
    <meta name="description" content="{{ $article->description }}">
    <meta name="keywords" content="{{ $article->keywords }}">
@endsection


@section('content')

    <div class="col-md-8">
        <h1>{{ $article->title }}</h1>
        <p class="blog-post-meta">Created by <a href="#">{{ $article->user->name }}</a> on
            {{ $article->created_at->toFormattedDateString() }}</p>
        @foreach($article->tags as $tag)
            <span class="badge badge-info">{{ $tag->name }}</span>
        @endforeach

        <hr>

        <p>{{ $article->body }}</p>

        @if(Gate::check('update', $article) || Gate::check('delete', $article))
            <div class="row justify-content-end">
                <div class="btn-group">
                    @can('update', $article)
                        <a href="{{ route('article.edit', ['slug' => $article->slug]) }}" class="btn btn-primary">Edit</a>
                    @endcan
                    @can('delete', $article)
                        <a href="" class="btn btn-danger">Delete</a>
                    @endcan
                </div>
            </div>
       @endif
    </div>

@endsection


@section('sidebar')

    @include('layouts.sidebar')

@endsection
