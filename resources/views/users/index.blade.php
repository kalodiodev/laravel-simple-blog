@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>Users</h1>
        <hr>

        @include('partials.search-input')

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
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="User actions">
                                @can('update', \App\User::class)
                                    <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user->id]) }}">Edit</a>
                                @endcan
                                @can('delete', \App\User::class)
                                    <a class="btn btn-danger btn-sm deleteBtn" data-toggle="modal"
                                       data-target="#deleteConfirmModal"
                                       data-message="Are you sure you want to delete user {{ $user->name }} ?"
                                       data-action="{{ route('users.delete', ['user' => $user->id]) }}"
                                       href="#">Delete</a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @can('delete', \App\User::class)
            {{-- Delete confirmation modal --}}
            @include('partials.delete-confirm-modal')
        @endcan

        <div class="row justify-content-center">
            @if(isset($search))
                {{ $users->appends(['search' => $search])->links('vendor.pagination.bootstrap-4') }}
            @else
                {{ $users->links('vendor.pagination.bootstrap-4') }}
            @endif
        </div>

        <a class="btn btn-primary" href="{{ route('users.create') }}">Create User</a>
    </div>

@endsection