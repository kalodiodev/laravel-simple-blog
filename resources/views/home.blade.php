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
        {{-- Articles --}}
        @foreach($articles as $article)

            @include('articles.index')

        @endforeach
    </div>

@endsection


@section('sidebar')

    @include('layouts.sidebar')

@endsection
