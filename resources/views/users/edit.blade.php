@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Edit User</h1>

        <form action="" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            {{-- User name --}}
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input id="name" name="name"
                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       value="@if(isset($user)){{ old('name',$user->name) }}@else{{ old('name') }}@endif">

                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                    <small class="form-text text-muted">Please check user name.</small>
                @endif
            </div>

            {{-- User email --}}
            <div class="form-group">
                <label class="label" for="email">Email</label>
                <input id="email" name="email" type="email"
                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       value="@if(isset($user)){{ old('email', $user->email) }}@else{{ old('email') }}@endif">

                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    <small class="form-text text-muted">Please check user email.</small>
                @endif
            </div>

            {{-- User Role --}}
            <div class="form-group">
                <label class="label" for="role">Role</label>
                <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                                @if($role->id === $user->role->id) selected @endif>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('role'))
                    <div class="invalid-feedback">
                        {{ $errors->first('role') }}
                    </div>
                    <small class="form-text text-muted">Please check user role.</small>
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
                    <small class="form-text text-muted">Please check user about.</small>
                @endif
            </div>

            <div class="form-group">
                <label class="label" for="profession">Profession (Optional)</label>
                <input id="profession" name="profession"
                       class="form-control{{ $errors->has('profession') ? ' is-invalid' : '' }}"
                       value="@if(isset($user)){{ old('profession', $user->profession) }}@else{{ old('profession') }}@endif">

                @if ($errors->has('profession'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profession') }}
                    </div>
                    <small class="form-text text-muted">Please check user profession.</small>
                @endif
            </div>

            {{-- User country --}}
            <div class="form-group">
                <label class="label" for="country">Country (Optional)</label>
                <input id="country" name="country"
                       class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                       value="@if(isset($user)){{ old('country', $user->country) }}@else{{ old('country') }}@endif">

                @if ($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                    <small class="form-text text-muted">Please check user country.</small>
                @endif
            </div>

            {{-- User profession --}}
            <div class="form-group">
                <label class="label" for="profession">Profession (Optional)</label>
                <input id="profession" name="profession"
                       class="form-control{{ $errors->has('profession') ? ' is-invalid' : '' }}"
                       value="@if(isset($user)){{ old('profession', $user->profession) }}@else{{ old('profession') }}@endif">

                @if ($errors->has('profession'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profession') }}
                    </div>
                    <small class="form-text text-muted">Please check user profession.</small>
                @endif
            </div>

            {{-- User avatar image --}}
            <div class="form-group">
                <label for="avatar" class="label">Avatar</label>
                <input type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                       name="avatar" id="avatar">

                @if ($errors->has('avatar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avatar') }}
                    </div>
                    <small class="form-text text-muted">Please check your avatar file.</small>
                @endif
            </div>

            {{-- Remove image --}}
            @if($user->hasAvatar())
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="removeavatar" id="removeavatar"> Remove Avatar
                        </label>
                    </div>
                </div>
            @endif

            {{-- Update user button --}}
            <button class="btn btn-primary">Update User</button>
        </form>

    </div>

@endsection