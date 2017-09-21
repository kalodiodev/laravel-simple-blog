@extends('layouts.master')

@section('content')

    <div class="col-md-8">

        <h1>{{ __('tags.title.index') }}</h1>

        <table class="table table-responsive">
            <thead>
            <tr>
                <th>{{ __('tags.index.id') }}</th>
                <th>{{ __('tags.index.name') }}</th>
                <th>{{ __('tags.index.articles_number') }}</th>
                <th>{{ __('tags.index.created_at') }}</th>
                <th>{{ __('tags.index.updated_at') }}</th>
                <th>{{ __('tags.index.action') }}</th>
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
                            <a class="btn btn-primary" href="{{ route('tag.edit', ['tag' => $tag->name]) }}"
                            >
                                {{ __('tags.button.edit') }}
                            </a>
                        @endcan
                        @can('delete', \App\Tag::class)
                            <a class="btn btn-danger btn-sm deleteBtn" data-toggle="modal"
                               data-target="#deleteConfirmModal"
                               data-message="{{ __('tags.confirm.delete') }}"
                               data-action="{{ route('tag.delete', ['tag' => $tag->name]) }}"
                               href="#"
                            >
                                {{ __('tags.button.delete') }}
                            </a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        @can('delete', \App\Tag::class)
            {{-- Delete confirmation modal --}}
            @include('partials.delete-confirm-modal')
        @endcan

        <div class="row justify-content-center">
            {{ $tags->links('vendor.pagination.bootstrap-4') }}
        </div>

        <a class="btn btn-primary" href="{{ route('tag.create') }}">{{ __('tags.button.add') }}</a>

    </div>

@endsection