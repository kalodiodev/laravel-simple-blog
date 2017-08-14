@extends('layouts.master')

@section('head-meta')
    <meta name="description" content="My simple blog.">
    <meta name="keywords" content="laravel, blog, framework, php">
@endsection

@section('intro')
    <div class="row">
        <div class="col-md-12 jumbotron">
            <h1>This is Simple Blog homepage</h1>
            <p>Welcome to simple blog</p>
        </div>
    </div>
@endsection

@section('content')

    <div class="col-md-8">

        @can('create', \App\Article::class)
            <div class="row justify-content-end" style="margin-bottom: 30px;">
                <a href="{{ route('article.create') }}" class="btn btn-primary">Create article</a>
            </div>
        @endcan

        {{-- Articles --}}
        @foreach($articles as $article)

            @include('articles.index')

        @endforeach

        <div class="row justify-content-center">
            @if(request('year') && request('month'))
                {{ $articles->appends(['year' => request('year'), 'month' => request('month')])
                   ->links('vendor.pagination.simple-bootstrap-4') }}
            @else
                {{ $articles->links('vendor.pagination.simple-bootstrap-4') }}
            @endif
        </div>
    </div>

@endsection


@section('sidebar')

    @include('layouts.sidebar')

@endsection
