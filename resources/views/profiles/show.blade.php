@extends('layouts.master')

@section('content')

    <div class="col-md-8">
    <h1>Profile of user {{ $user->name }}</h1>
    <p>{{ $user->about }}</p>
    @can('view', $user)
        <table class="table">
            <tbody>
                <tr>
                    <td>Email:</td><td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Registration date:</td><td>{{ $user->created_at->toFormattedDateString() }}</td>
                </tr>
            </tbody>
        </table>
    @endcan
    @can('update', $user)
        <div style="text-align: right">
            <a class="btn btn-primary" href="">Edit Profile</a>
        </div>
    @endcan
    <hr>

    <h2>Latest activity</h2>

        {{-- Articles --}}
        <div class="card bottom-space top-space">
            <div class="card-header">
                <h3>Articles</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Tags</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if($articles->count())
                    <tbody>

                        @foreach($articles as $article)
                            <tr>
                                <td>{{ $article->created_at->toFormattedDateString() }}</td>
                                <td>{{ $article->title }}</td>
                                <td>
                                    @foreach($article->tags as $tag)
                                        <div class="badge badge-info">{{ $tag->name }}</div>
                                    @endforeach
                                </td>
                                <td><a class="btn btn-primary" href="{{ route('article', ['slug' => $article->slug]) }}">Visit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>

                @if($user->articles->count() == 0)
                    <div class="row justify-content-center">No articles</div>
                @endif

            </div>
        </div>

        {{-- Comments --}}
        <div class="card bottom-space">
            <div class="card-header">
                <h3>Comments</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>Date</th>
                        <th>on Article</th>
                        <th>Comment</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($comments->count())
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->created_at->toFormattedDateString() }}</td>
                                <td><a href="{{ route('article', ['slug' => $comment->article->slug]) }}">
                                        {{ $comment->article->title }}
                                    </a>
                                </td>
                                <td>{{ $comment->body }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                @if($comments->count() == 0)
                    <div class="row justify-content-center">No comments</div>
                @endif
            </div>
        </div>


    </div>
@endsection

@section('sidebar')

    @include('layouts.sidebar')

@endsection
