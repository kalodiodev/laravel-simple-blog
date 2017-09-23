@extends('layouts.master')

@section('content')
    <div class="col-md-8">
        <div style="display: flex; justify-content: space-between;">
            <h1 style="align-self: flex-start;">{{ __('images.admin.show.title') }}</h1>
            <a class="btn btn-primary"
               style="align-self: flex-end"
               href="{{ route('images.admin.index') }}">{{ __('images.show.button.to_index') }}
            </a>
        </div>

        <hr>

        <table>
            <tr>
                <th>{{ __('images.show.details.filename') }}</th>
                <td>{{ $image->filename }}</td>
            </tr>
            <tr>
                <th>{{ __('images.show.details.folder') }}</th>
                <td>{{ $image->path }}</td>
            </tr>
            <tr>
                <th>{{ __('images.show.details.thumbnail') }}</th>
                <td>{{ $image->thumbnail }}</td>
            </tr>
            <tr>
                <th>{{ __('images.show.details.user') }}</th>
                <td>
                    <a href="{{ route('users.show', ['user' => $image->user->id]) }}">{{ $image->user->name }}</a>
                </td>
            </tr>
            <tr>
                <th>{{ __('images.show.details.created_at') }}</th>
                <td>{{ $image->created_at }}</td>
            </tr>
        </table>

        @include('images._delete-button', [
            'delete_route' => route('images.admin.delete', ['image' => $image->id])
        ])

        <img src="/{{ $image->path . $image->filename }}" class="img-fluid top-space bottom-space">

    </div>
@endsection

