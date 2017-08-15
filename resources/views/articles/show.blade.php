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
                        <a class="btn btn-danger" data-toggle="modal"  data-target="#deleteConfirmModal" href="#">Delete</a>

                        {{-- Delete confirmation modal --}}
                        <div class="modal fade" id="deleteConfirmModal" tabindex="-1"
                             role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">

                            {{-- Dialog --}}
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    {{-- Header --}}
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Confirm Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    {{-- Body --}}
                                    <div class="modal-body">
                                        Are you sure you want to delete this article ?
                                    </div>

                                    {{-- Footer --}}
                                    <div class="modal-footer">
                                        <form action="{{ route('article.delete', ['slug' => $article->slug]) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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


@endsection


@section('sidebar')

    @include('layouts.sidebar')

@endsection
