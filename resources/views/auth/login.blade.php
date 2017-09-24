@extends('layouts.master')

@section('content')

    <div class="col-8 col-md-6 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('auth.login.title') }}</h4>
                <h6 class="card-subtitle mb-2 text-muted">{{ __('auth.login.subtitle') }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-control-label">{{ __('auth.form.email') }}</label>
                        <input id="email" type="email" name="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus>

                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            <small class="form-text text-muted">{{ __('auth.error.check_email') }}</small>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-control-label">{{ __('auth.form.password') }}</label>
                        <input id="password" type="password" name="password"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required>

                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            <small class="form-text text-muted">{{ __('auth.error.check_password') }}</small>
                        @endif
                    </div>

                    {{-- Remember Me --}}
                    <div class="form-check">
                        <div class="form-check-label">
                            <input type="checkbox" class="form-check-input"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{__('auth.form.remember_me')}}
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('auth.button.login') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('auth.login.forgot') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
