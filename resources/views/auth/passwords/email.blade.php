@extends('layouts.master')

@section('content')

    <div class="col-8 col-md-6 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('auth.reset_password.title') }}</h4>
                <h6 class="card-subtitle mb-2 text-muted">{{ __('auth.reset_password.insert_email') }}</h6>
            </div>

            <div class="card-block">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="form-control-label">{{ __('auth.form.email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}" required>

                        @if ($errors->has('email'))
                            <div class="form-control-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            <small class="form-text text-muted">{{ __('auth.error.check_email') }}</small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('auth.button.send_reset') }}</button>
                </form>
            </div>
        </div>
    </div>


@endsection
