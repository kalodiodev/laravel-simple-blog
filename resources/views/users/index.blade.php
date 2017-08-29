@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>Users</h1>
        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><a href="{{ route('users.show', ['user' => $user->id]) }}" >{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center">
            {{ $users->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

@endsection