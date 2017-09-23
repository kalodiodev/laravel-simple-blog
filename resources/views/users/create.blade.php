@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>{{ __('users.title.create') }}</h1>

        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            @include('users.form')

            {{-- Store user button --}}
            <button class="btn btn-primary">{{ __('users.button.save') }}</button>
        </form>

    </div>

@endsection