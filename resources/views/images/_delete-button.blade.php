{{-- Delete Image --}}
@can('delete', $image)
    <div style="display: flex; flex-direction: row-reverse;">
        <button class="btn btn-danger deleteBtn"
                data-toggle="modal"
                data-target="#deleteConfirmModal"
                data-message="Are you sure you want to delete this image ?"
                data-action="{{ $delete_route }}">
            Delete Image
        </button>
    </div>
@endcan

@can('delete', $image)
    {{-- Delete confirmation modal --}}
    @include('partials.delete-confirm-modal')
@endcan