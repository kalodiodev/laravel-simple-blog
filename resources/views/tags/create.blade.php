@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Create Tag</h1>
        <hr>

        <form method="POST" action="{{ route('tag.store') }}">
            @include('tags.form')
        </form>
    </div>

@endsection