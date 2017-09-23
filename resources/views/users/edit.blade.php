@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>{{ __('users.title.edit') }}</h1>

        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post"
              enctype="multipart/form-data">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            @include('users.form')

            {{-- Update user button --}}
            <button class="btn btn-primary">{{ __('users.button.update') }}</button>
        </form>

    </div>

@endsection