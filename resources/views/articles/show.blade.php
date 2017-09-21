@extends('layouts.master')

@section('head-meta')
    <meta name="description" content="{{ $article->description }}">
    <meta name="keywords" content="{{ $article->keywords }}">
@endsection


@section('content')

    <div class="col-md-8">
        <h1>{{ $article->title }}</h1>
        <p class="blog-post-meta">
            {{ __('articles.created_by') }} <a href="{{ route('profile.show', ['user' => $article->user->id]) }}">{{ $article->user->name }}</a>
            {{ __('articles.on_date', ['date' => $article->created_at->toFormattedDateString()]) }}</p>
        @foreach($article->tags as $tag)
            <span class="badge badge-info">{{ $tag->name }}</span>
        @endforeach

        <hr>

        <div class="row">
            <div class="col-md-12">
                {!! $article->body !!}
            </div>
        </div>

        @if(Gate::check('update', $article) || Gate::check('delete', $article))
            <hr>

            <div class="row justify-content-end">
                <div class="btn-group">
                    @can('update', $article)
                        <a href="{{ route('article.edit', ['slug' => $article->slug]) }}" class="btn btn-primary">
                            {{ __('articles.button.edit') }}
                        </a>
                    @endcan
                    @can('delete', $article)
                        <a class="btn btn-danger deleteBtn" data-toggle="modal"  data-target="#deleteConfirmModal"
                           data-message="Are you sure you want to delete this article ?"
                           data-action="{{ route('article.delete', ['slug' => $article->slug]) }}"
                           href="#">{{ __('articles.button.delete') }}</a>
                    @endcan
                </div>
            </div>
       @endif

        {{-- Comments --}}
        <div class="top-space bottom-space">
            <h3>{{ __('comments.title') }}</h3>
            <hr>

            @if(count($comments) == 0)
                <p style="text-align: center">{{ __('comments.first') }}</p>
            @else
                {{-- Comments list --}}
                @include('comments.list')

            @endif

            @if(auth()->user())
                {{-- Comment form --}}
                <div class="card top-space">
                    <div class="card-header">
                        {{ __('comments.post_comment') }}
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('comment.store', ['slug' => $article->slug]) }}">
                            @include('comments.form')
                        </form>
                    </div>
                </div>
            @else
                {{-- Prompt to login or register --}}
                <div class="card">
                    <div class="card-body">
                        <a href='/login'>{{ __('comments.login_prompt.login') }}</a>
                        {{ __('comments.login_prompt.or') }}
                        <a href='/register'>{{ __('comments.login_prompt.register') }}</a>
                        {{ __('comments.login_prompt.to_post_comment') }}
                    </div>
                </div>
            @endif

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
