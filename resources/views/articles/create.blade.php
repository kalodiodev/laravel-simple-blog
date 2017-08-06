@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8">

            <h1>Create article</h1>
            <hr>

            <form method="POST" action="/articles">
                @include('articles.form')
            </form>
        </div>
    </div>

@endsection