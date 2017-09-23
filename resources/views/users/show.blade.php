@extends('layouts.master')

@section('content')


    <div class="col-md-8">
        <h1>{{ __('users.title.show', ['user' => $user->name]) }}</h1>

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
                            <th>{{ __('users.table.name') }}</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('users.table.email') }}</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('users.table.about') }}</th>
                            <td>{{ $user->about }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('users.table.profession') }}</th>
                            <td>{{ $user->profession }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('users.table.country') }}</th>
                            <td>{{ $user->country }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('users.table.role') }}</th>
                            <td>{{ $user->role->name }}</td>
                        </tr>
                    </tbody>
                </table>

                <a class="btn btn-primary"
                   href="{{ route('users.edit', ['user' => $user->id]) }}"
                >
                    {{ __('users.button.edit') }}
                </a>
            </div>
        </div>
    </div>
@endsection