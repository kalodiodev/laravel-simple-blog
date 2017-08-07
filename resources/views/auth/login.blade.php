@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-8 col-md-6 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Login</h4>
                <h6 class="card-subtitle mb-2 text-muted">Welcome to login,</h6>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    {{-- Email --}}
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="form-control-label">E-Mail Address</label>
                        <input id="email" type="email" name="email"
                               class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}" required autofocus>

                        @if ($errors->has('email'))
                            <div class="form-control-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            <small class="form-text text-muted">Please check your email.</small>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="form-control-label">Password</label>
                        <input id="password" type="password" name="password"
                               class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}" required>

                        @if ($errors->has('password'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            <small class="form-text text-muted">Please check your password.</small>
                        @endif
                    </div>

                    {{-- Remember Me --}}
                    <div class="form-check">
                        <div class="form-check-label">
                            <input type="checkbox" class="form-check-input"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
