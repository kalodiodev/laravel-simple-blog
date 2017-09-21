@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>{{ __('articles.title.create') }}</h1>
        <hr>

        <form method="POST" action="/articles" enctype=multipart/form-data>
            @include('articles.form')
        </form>
    </div>

    @include('partials.summernote-script')

@endsection