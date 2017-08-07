@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-8 col-md-6 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Reset Password</h4>
                <h6 class="card-subtitle mb-2 text-muted">Change your password,</h6>
            </div>

            <div class="card-block">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email --}}
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="form-control-label">E-Mail Address</label>
                        <input id="email" type="email" name="email"
                               class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                               value="{{ $email or old('email') }}" required autofocus>

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
                               class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}" required>

                        @if ($errors->has('password'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            <small class="form-text text-muted">Please check your password.</small>
                        @endif
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                        <label for="password-confirm" class="form-control-label">Confirm Password</label>
                        <input id="password-confirm" type="password" name="password_confirmation"
                               class="form-control{{ $errors->has('password_confirmation') ? ' form-control-danger' : '' }}" required>

                        @if ($errors->has('password_confirmation'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                            <small class="form-text text-muted">Please check your password.</small>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
