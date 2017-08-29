@extends('layouts.master')

@section('content')


    <div class="col-md-8">
        <h1>User {{ $user->name }}</h1>

        <hr>

        <div class="row">
            <div class="col-md-3">
                {{-- Avatar --}}
                @if($user->hasAvatar())
                    <img class="avatar normal" src="{{ route('images.avatar', ['image' => $user->avatar ]) }}"/>
                @else
                    <img class="avatar normal" src="{{ asset('images/person.png') }}"/>
                @endif
            </div>

            <div class="col-md-9">

                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>About</th>
                            <td>{{ $user->about }}</td>
                        </tr>
                        <tr>
                            <th>Profession</th>
                            <td>{{ $user->profession }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $user->country }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ $user->role->name }}</td>
                        </tr>
                    </tbody>
                </table>

                <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user->id]) }}">Edit</a>
            </div>
        </div>
    </div>
@endsection