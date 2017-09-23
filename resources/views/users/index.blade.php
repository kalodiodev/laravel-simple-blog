@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>{{ __('users.title.index') }}</h1>
        <hr>

        @include('partials.search-input')

        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('users.table.id') }}</th>
                    <th>{{ __('users.table.name') }}</th>
                    <th>{{ __('users.table.email') }}</th>
                    <th>{{ __('users.table.role') }}</th>
                    <th>{{ __('users.table.action') }}</th>
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
                                    <a class="btn btn-primary"
                                       href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    >
                                        {{ __('users.button.edit') }}
                                    </a>
                                @endcan
                                @can('delete', \App\User::class)
                                    <a class="btn btn-danger btn-sm deleteBtn" data-toggle="modal"
                                       data-target="#deleteConfirmModal"
                                       data-message="{{ __('users.delete_confirm', ['user' => $user->name]) }}"
                                       data-action="{{ route('users.delete', ['user' => $user->id]) }}"
                                       href="#"
                                    >
                                        {{ __('users.button.delete') }}
                                    </a>
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

        <a class="btn btn-primary" href="{{ route('users.create') }}">{{ __('users.button.create') }}</a>
    </div>

@endsection