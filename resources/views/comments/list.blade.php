<ul>
    @foreach($comments as $comment)
        <li>
            <div>
                {{-- Comment owner --}}
                <label class="text-info">{{ $comment->user->name }} </label>
                <span> - {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="comment-body">
                <div class="row">

                    {{-- Comment Body --}}
                    <div class="col-md-9">
                        {{ $comment->body }}
                    </div>

                    {{-- Comment action buttons --}}
                    @if(Gate::check('update', $comment) || Gate::check('delete', $comment))
                        <div class="col-md-3">

                            {{-- Edit comment button --}}
                            @can('update', $comment)
                                <a class="btn btn-primary btn-sm" href="#">Edit</a>
                            @endcan

                            {{-- Delete comment button --}}
                            @can('delete', $comment)
                                <a class="btn btn-danger btn-sm deleteBtn" data-toggle="modal"
                                   data-target="#deleteConfirmModal"
                                   data-message="Are you sure you want to delete this comment ?"
                                   data-action="{{ route('comment.delete', ['comment' => $comment->id]) }}"
                                   href="#">Delete</a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>

{{-- Comments pagination links --}}
<div class="row justify-content-center">
    {{ $comments->links('vendor.pagination.simple-bootstrap-4') }}
</div>

