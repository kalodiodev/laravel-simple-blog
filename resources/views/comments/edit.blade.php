@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>{{ $comment->article->title }}</h1>
        <p class="blog-post-meta">Created by <a href="#">{{ $comment->article->user->name }}</a> on
            {{ $comment->article->created_at->toFormattedDateString() }}</p>
        @foreach($comment->article->tags as $tag)
            <span class="badge badge-info">{{ $tag->name }}</span>
        @endforeach

        <hr>

        <p>{{ $comment->article->description }}</p>

        <div class="top-space">
            <h3>Your comment</h3>
            <p class="blog-post-meta">Submitted at {{ $comment->created_at->toFormattedDateString() }}</p>
            <hr>

            <p>{{ $comment->body }}</p>

            {{-- Comment form --}}
            <div class="card top-space">
                <div class="card-header">
                    Update Comment
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('comment.update', ['comment' => $comment->id]) }}">
                        {{ method_field('PATCH') }}
                        @include('comments.form')
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('sidebar')

    @include('layouts.sidebar')

@endsection