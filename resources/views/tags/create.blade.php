@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>{{ __('tags.title.create') }}</h1>
        <hr>

        <form method="POST" action="{{ route('tag.store') }}">
            @include('tags.form')
        </form>
    </div>

@endsection