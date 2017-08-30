@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Create User</h1>

        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            @include('users.form')

            {{-- Store user button --}}
            <button class="btn btn-primary">Save User</button>
        </form>

    </div>

@endsection