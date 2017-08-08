@extends('layouts.master')

@section('content')

    <div class="col-8 col-md-6 offset-md-2">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">Register</h4>
                <h6 class="card-subtitle mb-2 text-muted">Welcome to registration,</h6>
            </div>

            <div class="card-block">
                <form method="POST" action="{{ route('register') }}">

                    {{ csrf_field() }}

                    {{-- Name --}}
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name" class="form-control-label">Name</label>
                        <input id="name" type="text" name="name"
                               class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}"
                               value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <div class="form-control-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            <small class="form-text text-muted">Please check your name.</small>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="form-control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email"
                               class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                               value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <div class="form-control-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            <small class="form-text text-muted">Please check your e-mail.</small>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="form-control-label">Password</label>
                        <input id="password" type="password" name="password"
                               class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}" required>

                        @if ($errors->has('password'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            <small class="form-text text-muted">Please check your password.</small>
                        @endif
                    </div>


                    {{-- Password Confirmation --}}
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password-confirm" class="form-control-label">Confirm Password</label>
                        <input id="password-confirm" type="password"
                               name="password_confirmation" class="form-control" required>
                    </div>

                    {{-- Submit--}}
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

@endsection
