{{-- Delete Image --}}
@can('delete', $image)
    <div style="display: flex; flex-direction: row-reverse;">
        <button class="btn btn-danger deleteBtn"
                data-toggle="modal"
                data-target="#deleteConfirmModal"
                data-message="{{ __('images.show.delete_confirm') }}"
                data-action="{{ $delete_route }}">
            {{ __('images.show.button.delete') }}
        </button>
    </div>
@endcan

@can('delete', $image)
    {{-- Delete confirmation modal --}}
    @include('partials.delete-confirm-modal')
@endcan