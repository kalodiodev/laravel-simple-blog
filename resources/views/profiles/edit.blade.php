@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>{{ __('profile.title.edit', ['name' => $user->name]) }}</h1>
        <hr>

        <form action="{{ route('profile.update', ['user' => $user->id ]) }}"
              method="post" enctype="multipart/form-data">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            {{-- User name --}}
            <div class="form-group">
                <label for="name" class="label">{{ __('profile.form.name') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       name="name" id="name"
                       value="@if(isset($user)){{ old('name',$user->name) }}@else{{ old('name') }}@endif">

                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                    <small class="form-text text-muted">{{ __('profile.error.check_name') }}</small>
                @endif
            </div>

            {{-- About user --}}
            <div class="form-group">
                <label for="about" class="label">{{ __('profile.form.about') }}</label>
            <textarea class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}" name="about" id="about"
            >@if(isset($user)){{ old('about',$user->about) }}@else{{ old('about') }}@endif</textarea>

                @if ($errors->has('about'))
                    <div class="invalid-feedback">
                        {{ $errors->first('about') }}
                    </div>
                    <small class="form-text text-muted">{{ __('profile.error.check_about') }}</small>
                @endif
            </div>

            {{-- User profession --}}
            <div class="form-group">
                <label for="profession" class="label">{{ __('profile.form.profession') }}</label>
                <input type="text" class="form-control{{ $errors->has('profession') ? ' is-invalid' : '' }}"
                       name="profession" id="profession"
                       value="@if(isset($user)){{ old('profession',$user->profession) }}@else{{ old('profession') }}@endif">

                @if ($errors->has('profession'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profession') }}
                    </div>
                    <small class="form-text text-muted">{{ __('profile.error.check_profession') }}</small>
                @endif
            </div>

            {{-- User country --}}
            <div class="form-group">
                <label for="country" class="label">{{ __('profile.form.country') }}</label>
                <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                       name="country" id="country"
                       value="@if(isset($user)){{ old('country',$user->country) }}@else{{ old('country') }}@endif">

                @if ($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                    <small class="form-text text-muted">{{ __('profile.error.check_country') }}</small>
                @endif
            </div>

            {{-- User avatar image --}}
            <div class="form-group">
                <label for="avatar" class="label">{{ __('profile.form.avatar') }}Avatar</label>
                <input type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                       name="avatar" id="avatar">

                @if ($errors->has('avatar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avatar') }}
                    </div>
                    <small class="form-text text-muted">{{ __('profile.error.check_avatar') }}</small>
                @endif
            </div>

            {{-- Remove image --}}
            @if($user->hasAvatar())
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="removeavatar" id="removeavatar"
                            > {{ __('profile.form.remove_avatar') }}
                        </label>
                    </div>
                </div>
            @endif

            <button class="btn btn-primary">{{ __('profile.button.update') }}</button>
        </form>
    </div>

@endsection