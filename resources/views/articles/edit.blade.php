@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Edit article</h1>
        <hr>

        <form method="POST" action="/article/{{ $article->slug }}" enctype=multipart/form-data>
            {{ method_field('PATCH') }}
            @include('articles.form')
        </form>
    </div>

    @include('partials.summernote-script')

@endsection