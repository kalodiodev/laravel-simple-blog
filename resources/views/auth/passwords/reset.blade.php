@extends('layouts.master')

@section('content')

<div class="col-8 col-md-6 offset-md-2">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('auth.reset_password.title') }}</h4>
            <h6 class="card-subtitle mb-2 text-muted">{{ __('auth.reset_password.change_password') }}</h6>
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
                    <label for="email" class="form-control-label">{{ __('auth.form.email') }}</label>
                    <input id="email" type="email" name="email"
                           class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}"
                           value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <div class="form-control-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        <small class="form-text text-muted">{{ __('auth.error.check_email') }}</small>
                    @endif
                </div>

                {{-- Password --}}
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password" class="form-control-label">{{ __('auth.form.password') }}</label>
                    <input id="password" type="password" name="password"
                           class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}" required>

                    @if ($errors->has('password'))
                        <div class="form-control-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        <small class="form-text text-muted">{{ __('auth.error.check_password') }}</small>
                    @endif
                </div>

                {{-- Password Confirmation --}}
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                    <label for="password-confirm" class="form-control-label">{{ __('auth.form.confirm_password') }}</label>
                    <input id="password-confirm" type="password" name="password_confirmation"
                           class="form-control{{ $errors->has('password_confirmation') ? ' form-control-danger' : '' }}" required>

                    @if ($errors->has('password_confirmation'))
                        <div class="form-control-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        <small class="form-text text-muted">{{ __('auth.error.check_password') }}</small>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">{{ __('auth.button.reset') }}</button>
            </form>
        </div>
    </div>
</div>


@endsection
