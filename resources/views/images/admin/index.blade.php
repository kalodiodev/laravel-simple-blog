@extends('layouts.master')

@section('content')

    <div class="col-md-12">
        <h1>{{ __('images.index.all_title') }}</h1>
        <hr>

        @include('partials.search-input')

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Filename</th>
                    <th>Path</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Thumbnail</th>
                </tr>
            </thead>

            <tbody>
                @foreach($images as $image)
                    <tr>
                        <td>{{ $image->id }}</td>
                        <td><a href="{{ route('images.admin.show', ['image' => $image->id]) }}">{{ $image->filename }}</a></td>
                        <td>{{ $image->path }}</td>
                        <td>
                            <a href="{{ route('users.show', ['user' => $image->user->id]) }}" >
                                {{ $image->user->name }}
                            </a>
                        </td>
                        <td>{{ $image->created_at }}</td>
                        <td><img src="{{ '/' . $image->path . $image->thumbnail }}" height="100"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center">
            @if(isset($search))
                {{ $images->appends(['search' => $search])->links('vendor.pagination.bootstrap-4') }}
            @else
                {{ $images->links('vendor.pagination.bootstrap-4') }}
            @endif
        </div>
    </div>

@endsection