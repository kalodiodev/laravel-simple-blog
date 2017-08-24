@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>Edit {{ $user->name }} Profile</h1>
        <hr>

        <form action="" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            {{-- About user --}}
            <div class="form-group">
                <label for="name" class="label">Name</label>
                <input type="text" class="form-control" name="name" id="about"
                       value="@if(isset($user)){{ old('name',$user->name) }}@else{{ old('name') }}@endif">
            </div>

            {{-- About user --}}
            <div class="form-group">
                <label for="about" class="label">About</label>
            <textarea class="form-control" name="about" id="about"
            >@if(isset($user)){{ old('about',$user->about) }}@else{{ old('about') }}@endif</textarea>
            </div>

            {{-- User profession --}}
            <div class="form-group">
                <label for="profession" class="label">Profession</label>
                <input type="text" class="form-control" name="profession" id="profession"
                       value="@if(isset($user)){{ old('profession',$user->profession) }}@else{{ old('profession') }}@endif">
            </div>

            {{-- User country --}}
            <div class="form-group">
                <label for="country" class="label">Country</label>
                <input type="text" class="form-control" name="country" id="country"
                       value="@if(isset($user)){{ old('country',$user->country) }}@else{{ old('country') }}@endif">
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