@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        {{-- Title --}}
        <h1>{{ __('images.index.title') }}</h1>
        <hr>

        @foreach($images->chunk(3) as $chunk)
            <div class="row">
                @foreach($chunk as $image)
                    <div class="col-sm-4 bottom-space"
                         style="display: flex; flex-direction: column; justify-content: flex-start; height: 100%;">

                        {{-- Image thumbnmail --}}
                        <img src="/{{ $image->path . $image->thumbnail }}" class="img-thumbnail">

                        <div style="display: flex; flex-direction: column; justify-content: flex-end;">
                            {{-- Image link --}}
                            <a href="{{ route('images.show', ['image' => $image->id]) }}" {{ $image->filename }}>{{ $image->filename }}</a>
                            {{-- Delete Image --}}
                            @can('delete', $image)
                                <div style="display: flex; align-self: flex-end;">
                                    <button class="btn-xs btn-danger deleteBtn"
                                            data-toggle="modal"
                                            data-target="#deleteConfirmModal"
                                            data-message="{{ __('images.index.delete_confirm', ['filename' => $image->filename]) }}"
                                            data-action="{{ route('images.delete', ['image' => $image->filename]) }}"
                                    >
                                        {{ __('images.index.button.delete') }}
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="row justify-content-center">
            {{ $images->links('vendor.pagination.bootstrap-4') }}
        </div>

        {{-- Delete confirmation modal --}}
        @include('partials.delete-confirm-modal')

    </div>

@endsection