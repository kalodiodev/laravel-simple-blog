{{-- Delete confirmation modal --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1"
     role="dialog" aria-labelledby="deleteConfirmModal" aria-hidden="true">

    {{-- Dialog --}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">{{ __('partials.delete_confirm.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body"></div>

            {{-- Footer --}}
            <div class="modal-footer">
                <form id="delete-form" action="" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('partials.delete_confirm.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('partials.delete_confirm.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
