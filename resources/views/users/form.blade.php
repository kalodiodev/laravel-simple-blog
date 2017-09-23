{{-- User name --}}
<div class="form-group">
    <label class="label" for="name">{{ __('users.form.name') }}</label>
    <input id="name" name="name"
           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
           value="@if(isset($user)){{ old('name',$user->name) }}@else{{ old('name') }}@endif">

    @if ($errors->has('name'))
        <div class="invalid-feedback">
            {{ $errors->first('name') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_name') }}</small>
    @endif
</div>

{{-- User email --}}
<div class="form-group">
    <label class="label" for="email">{{ __('users.form.email') }}</label>
    <input id="email" name="email" type="email"
           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
           value="@if(isset($user)){{ old('email', $user->email) }}@else{{ old('email') }}@endif">

    @if ($errors->has('email'))
        <div class="invalid-feedback">
            {{ $errors->first('email') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_email') }}</small>
    @endif
</div>

{{-- User Role --}}
<div class="form-group">
    <label class="label" for="role">{{ __('users.form.role') }}</label>
    <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role">
        @foreach($roles as $role)
            <option value="{{ $role->id }}"
                    @if(isset($user) && ($role->id === $user->role->id)) selected @endif>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    @if ($errors->has('role'))
        <div class="invalid-feedback">
            {{ $errors->first('role') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_role') }}</small>
    @endif
</div>

{{-- About user --}}
<div class="form-group">
    <label for="about" class="label">{{ __('users.form.about') }}</label>
                <textarea class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}" name="about" id="about"
                >@if(isset($user)){{ old('about',$user->about) }}@else{{ old('about') }}@endif</textarea>

    @if ($errors->has('about'))
        <div class="invalid-feedback">
            {{ $errors->first('about') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_about') }}</small>
    @endif
</div>

{{-- User country --}}
<div class="form-group">
    <label class="label" for="country">{{ __('users.form.country') }}</label>
    <input id="country" name="country"
           class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
           value="@if(isset($user)){{ old('country', $user->country) }}@else{{ old('country') }}@endif">

    @if ($errors->has('country'))
        <div class="invalid-feedback">
            {{ $errors->first('country') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_country') }}</small>
    @endif
</div>

{{-- User profession --}}
<div class="form-group">
    <label class="label" for="profession">{{ __('users.form.profession') }}</label>
    <input id="profession" name="profession"
           class="form-control{{ $errors->has('profession') ? ' is-invalid' : '' }}"
           value="@if(isset($user)){{ old('profession', $user->profession) }}@else{{ old('profession') }}@endif">

    @if ($errors->has('profession'))
        <div class="invalid-feedback">
            {{ $errors->first('profession') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_profession') }}</small>
    @endif
</div>

{{-- User avatar image --}}
<div class="form-group">
    <label for="avatar" class="label">{{ __('users.form.avatar') }}</label>
    <input type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
           name="avatar" id="avatar">

    @if ($errors->has('avatar'))
        <div class="invalid-feedback">
            {{ $errors->first('avatar') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_avatar') }}</small>
    @endif
</div>

{{-- Remove image --}}
@if(isset($user) && $user->hasAvatar())
    <div class="form-group">
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox"
                       class="form-check-input"
                       name="removeavatar"
                       id="removeavatar"
                > {{ __('users.form.remove_avatar') }}
            </label>
        </div>
    </div>
@endif

{{-- Password confirmation --}}
<div class="form-group">
    <label class="label" for="password">{{ __('users.form.password') }}</label>
    <input type="password" id="password" name="password"
           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">

    @if ($errors->has('password'))
        <div class="invalid-feedback">
            {{ $errors->first('password') }}
        </div>
        <small class="form-text text-muted">{{ __('users.error.check_password') }}</small>
    @endif
</div>

{{-- Password confirmation --}}
<div class="form-group">
    <label class="label" for="password-confirm">{{ __('users.form.confirm_password') }}</label>
    <input type="password" id="password-confirm" name="password_confirmation"
           class="form-control">
</div>
