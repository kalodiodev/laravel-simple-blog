@extends('layouts.master')

@section('content')

    <div class="col-md-8">
        <h1>My images</h1>
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
                            <a href="/{{ $image->id }}/show" {{ $image->filename }}>{{ $image->filename }}</a>
                            {{-- Delete Image --}}
                            @can('delete', $image)
                                <div style="display: flex; align-self: flex-end;">
                                    <button class="btn-xs btn-danger deleteBtn"
                                            data-toggle="modal"
                                            data-target="#deleteConfirmModal"
                                            data-message="Are you sure you want to delete image with filename {{ $image->filename }} ?"
                                            data-action="{{ route('images.delete', ['image' => $image->filename]) }}">Delete</button>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- Delete confirmation modal --}}
        @include('partials.delete-confirm-modal')

    </div>

@endsection