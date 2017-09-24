@extends('layouts.master')

@section('content')

    <div class="col-8 col-md-6 offset-md-2">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">{{ __('auth.register.title') }}</h4>
                <h6 class="card-subtitle mb-2 text-muted">{{ __('auth.register.subtitle') }}</h6>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">

                    {{ csrf_field() }}

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-control-label">{{ __('auth.form.name') }}</label>
                        <input id="name" type="text" name="name"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               value="{{ old('name') }}"  autofocus required>

                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            <small class="form-text text-muted">{{ __('auth.error.check_name') }}</small>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-control-label">{{ __('auth.form.email') }}</label>
                        <input id="email" type="email" name="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               value="{{ old('email') }}" required>

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
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>

                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            <small class="form-text text-muted">{{ __('auth.error.check_password') }}</small>
                        @endif
                    </div>


                    {{-- Password Confirmation --}}
                    <div class="form-group">
                        <label for="password-confirm" class="form-control-label">{{ __('auth.form.confirm_password') }}</label>
                        <input id="password-confirm" type="password"
                               name="password_confirmation" class="form-control" required>
                    </div>

                    {{-- Submit--}}
                    <button type="submit" class="btn btn-primary">{{ __('auth.button.register') }}</button>
                </form>
            </div>
        </div>
    </div>

@endsection
