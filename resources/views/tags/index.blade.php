@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>Tags</h1>

        <table class="table table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tag Name</th>
                <th># of Articles</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
            <tr>
                <th scope="row">{{ $tag->id }}</th>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->articles->count() }}</td>
                <td>{{ $tag->created_at }}</td>
                <td>{{ $tag->updated_at }}</td>
                <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Tag actions">
                        @can('update', \App\Tag::class)
                            <a class="btn btn-primary" href="{{ route('tag.edit', ['tag' => $tag->name]) }}">Edit</a>
                        @endcan
                        @can('delete', \App\Tag::class)
                            <button type="button" class="btn btn-danger">Delete</button>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center">
            {{ $tags->links('vendor.pagination.bootstrap-4') }}
        </div>

        <a class="btn btn-primary" href="{{ route('tag.create') }}">Add Tag</a>

    </div>

@endsection