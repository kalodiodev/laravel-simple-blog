@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Create User</h1>

        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            @include('users.form')

            {{-- Password confirmation --}}
            <div class="form-group">
                <label class="label" for="password">Password</label>
                <input type="password" id="password" name="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">

                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    <small class="form-text text-muted">Please check password.</small>
                @endif
            </div>

            {{-- Password confirmation --}}
            <div class="form-group">
                <label class="label" for="password-confirm">Confirm Password</label>
                <input type="password" id="password-confirm" name="password_confirmation"
                       class="form-control">
            </div>

            {{-- Store user button --}}
            <button class="btn btn-primary">Save User</button>
        </form>

    </div>

@endsection