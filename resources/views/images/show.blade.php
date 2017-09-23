@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <div style="display: flex; justify-content: space-between;">
            <h1 style="align-self: flex-start;">{{ __('images.show.title') }}</h1>
            <a class="btn btn-primary" style="align-self: flex-end" href="{{ route('images.index') }}">
                {{ __('images.show.button.to_gallery') }}
            </a>
        </div>

        <hr>

        <table>
            <tr><th>{{ __('images.show.details.filename') }}</th> <td>{{ $image->filename }}</td></tr>
            <tr><th>{{ __('images.show.details.folder') }}</th> <td>{{ $image->path }}</td></tr>
            <tr><th>{{ __('images.show.details.thumbnail') }}</th> <td>{{ $image->thumbnail }}</td></tr>
        </table>

        @include('images._delete-button', [
            'delete_route' => route('images.delete', ['image' => $image->filename])
        ])

        <img src="/{{ $image->path . $image->filename }}" class="img-fluid top-space bottom-space">

    </div>

@endsection