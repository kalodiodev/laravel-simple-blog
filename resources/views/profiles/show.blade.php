@extends('layouts.master')

@section('content')

    <div class="col-md-8">
    <h1>{{ __('profile.title.show', ['name' => $user->name]) }}</h1>

    <div class="row">
        <div class="col-md-3">
            {{-- Avatar --}}
            @if($user->hasAvatar())
                <img class="avatar normal" src="{{ route('images.avatar', ['image' => $user->avatar ]) }}"/>
            @else
                <img class="avatar normal" src="{{ asset('images/person.png') }}"/>
            @endif
        </div>

        <div class="col-md-9">
            {{-- Profession --}}
            @if(isset($user->profession))
                <p>{{ $user->profession }}</p>
            @endif
            {{-- Country --}}
            @if(isset($user->country))
                <p>{{ $user->country }}</p>
            @endif
            {{-- About --}}
            @if(isset($user->about))
                <p>{{ $user->about }}</p>
            @endif

            {{-- Details --}}
            @can('view_profile', $user)
                <table class="table">
                    <tbody>
                    <tr>
                        <td>{{ __('profile.details.email') }}</td><td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('profile.details.registration_date') }}</td><td>{{ $user->created_at->toFormattedDateString() }}</td>
                    </tr>
                    </tbody>
                </table>
            @endcan

            {{-- Update profile --}}
            @can('update_profile', $user)
                <div style="text-align: right">
                    <a class="btn btn-primary"
                       href="{{ route('profile.edit', ['user' => $user->id]) }}"
                    >
                        {{ __('profile.button.edit') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <hr>

    <h2>{{ __('profile.title.latest_activity') }}</h2>

        {{-- Articles --}}
        <div class="card bottom-space top-space">
            <div class="card-header">
                <h3>{{ __('profile.articles.title') }}</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead class="thead-default">
                        <tr>
                            <th>{{ __('profile.articles.index.date') }}</th>
                            <th>{{ __('profile.articles.index.title') }}</th>
                            <th>{{ __('profile.articles.index.tags') }}</th>
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
                                <td><a class="btn btn-primary"
                                       href="{{ route('article', ['slug' => $article->slug]) }}"
                                    >
                                        {{ __('profile.articles.visit') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>

                @if($user->articles->count() == 0)
                    <div class="row justify-content-center">{{ __('profile.articles.no_articles') }}</div>
                @endif

            </div>
        </div>

        {{-- Comments --}}
        <div class="card bottom-space">
            <div class="card-header">
                <h3>{{ __('profile.comments.title') }}</h3>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>{{ __('profile.comments.index.date') }}</th>
                        <th>{{ __('profile.comments.index.on_article') }}</th>
                        <th>{{ __('profile.comments.index.comment') }}</th>
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
                    <div class="row justify-content-center">{{ __('profile.comments.no_comments') }}</div>
                @endif
            </div>
        </div>


    </div>
@endsection

@section('sidebar')

    @include('layouts.sidebar')

@endsection
