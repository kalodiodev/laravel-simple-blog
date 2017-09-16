@extends('layouts.master')

@section('content')
    <div class="col-md-8">
        <div style="display: flex; justify-content: space-between;">
            <h1 style="align-self: flex-start;">Image show</h1>
            <a class="btn btn-primary"
               style="align-self: flex-end"
               href="{{ route('images.admin.index') }}">Go to Images index
            </a>
        </div>

        <hr>

        <table>
            <tr>
                <th>Filename: </th>
                <td>{{ $image->filename }}</td>
            </tr>
            <tr>
                <th>Folder:</th>
                <td>{{ $image->path }}</td>
            </tr>
            <tr>
                <th>Thumbnail:</th>
                <td>{{ $image->thumbnail }}</td>
            </tr>
            <tr>
                <th>User:</th>
                <td>
                    <a href="{{ route('users.show', ['user' => $image->user->id]) }}">{{ $image->user->name }}</a>
                </td>
            </tr>
            <tr>
                <th>Created At:</th>
                <td>{{ $image->created_at }}</td>
            </tr>
        </table>

        @include('images._delete-button', [
            'delete_route' => ''
        ])

        <img src="/{{ $image->path . $image->filename }}" class="img-fluid top-space bottom-space">

    </div>
@endsection

