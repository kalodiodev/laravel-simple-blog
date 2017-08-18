@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Edit Tag</h1>
        <hr>

        <form method="POST" action="{{ route('tag.update', ['tag' => $tag->name]) }}">
            {{ method_field('PATCH') }}
            @include('tags.form')
        </form>
    </div>

@endsection