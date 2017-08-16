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
            <hr>

            <div class="row justify-content-end">
                <div class="btn-group">
                    @can('update', $article)
                        <a href="{{ route('article.edit', ['slug' => $article->slug]) }}" class="btn btn-primary">Edit</a>
                    @endcan
                    @can('delete', $article)
                        <a class="btn btn-danger deleteBtn" data-toggle="modal"  data-target="#deleteConfirmModal"
                           data-message="Are you sure you want to delete this article ?"
                           data-action="{{ route('article.delete', ['slug' => $article->slug]) }}"
                           href="#">Delete</a>
                    @endcan
                </div>
            </div>
       @endif

        <div class="top-space bottom-space">
            <h3>Comments</h3>
            <hr>

            @if(count($comments) == 0)
                <p style="text-align: center">Be the first to comment.</p>
            @else
                {{-- Comments list --}}
                @include('comments.list')

            @endif

            {{-- Comment form --}}
            @include('comments.form')

        </div>

    </div>

    @if(auth()->user())
        {{-- Delete confirmation modal --}}
        @include('partials.delete-confirm-modal')
    @endif

@endsection


@section('sidebar')

    @include('layouts.sidebar')

@endsection
