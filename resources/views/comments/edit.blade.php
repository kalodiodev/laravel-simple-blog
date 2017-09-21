@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>{{ $comment->article->title }}</h1>

        <p class="blog-post-meta">
            {{ __('comments.info.created_by') }}
            <a href="{{ route('profile.show', ['user' => $comment->article->user->id]) }}">
                {{ $comment->article->user->name }}
            </a>
            {{ __('comments.info.on_date', ['date' => $comment->article->created_at->toFormattedDateString() ]) }}
        </p>

        {{-- Tags --}}
        @foreach($comment->article->tags as $tag)
            <span class="badge badge-info">{{ $tag->name }}</span>
        @endforeach

        <hr>

        <p>{{ $comment->article->description }}</p>

        <div class="top-space">
            <h3>{{ __('comments.form.title') }}</h3>

            <p class="blog-post-meta">
                {{ __('comments.form.update.submitted_at', ['date' => $comment->created_at->toFormattedDateString()]) }}
            </p>

            <hr>

            <p>{{ $comment->body }}</p>

            {{-- Comment form --}}
            <div class="card top-space">
                <div class="card-header">
                    {{ __('comments.form.update.title') }}
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