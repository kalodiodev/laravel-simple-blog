@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>Edit {{ $user->name }} Profile</h1>
        <hr>

        <form action="{{ route('profile.update', ['user' => $user->id ]) }}"
              method="post" enctype="multipart/form-data">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            {{-- User name --}}
            <div class="form-group">
                <label for="name" class="label">Name</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       name="name" id="name"
                       value="@if(isset($user)){{ old('name',$user->name) }}@else{{ old('name') }}@endif">

                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                    <small class="form-text text-muted">Please check your name.</small>
                @endif
            </div>

            {{-- About user --}}
            <div class="form-group">
                <label for="about" class="label">About (Optional)</label>
            <textarea class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}" name="about" id="about"
            >@if(isset($user)){{ old('about',$user->about) }}@else{{ old('about') }}@endif</textarea>

                @if ($errors->has('about'))
                    <div class="invalid-feedback">
                        {{ $errors->first('about') }}
                    </div>
                    <small class="form-text text-muted">Please check about field.</small>
                @endif
            </div>

            {{-- User profession --}}
            <div class="form-group">
                <label for="profession" class="label">Profession (Optional)</label>
                <input type="text" class="form-control{{ $errors->has('profession') ? ' is-invalid' : '' }}"
                       name="profession" id="profession"
                       value="@if(isset($user)){{ old('profession',$user->profession) }}@else{{ old('profession') }}@endif">

                @if ($errors->has('profession'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profession') }}
                    </div>
                    <small class="form-text text-muted">Please check your profession.</small>
                @endif
            </div>

            {{-- User country --}}
            <div class="form-group">
                <label for="country" class="label">Country (Optional)</label>
                <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                       name="country" id="country"
                       value="@if(isset($user)){{ old('country',$user->country) }}@else{{ old('country') }}@endif">

                @if ($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                    <small class="form-text text-muted">Please check your country.</small>
                @endif
            </div>

            {{-- User avatar image --}}
            <div class="form-group">
                <label for="avatar" class="label">Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar">
            </div>

            <button class="btn btn-primary">Update profile</button>
        </form>
    </div>

@endsection