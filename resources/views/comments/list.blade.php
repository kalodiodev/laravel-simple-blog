<ul>
    @foreach($comments as $comment)
        <li>
            <div>
                {{-- Comment owner --}}
                <label class="text-info">
                    <a href="{{ route('profile.show', ['user' => $comment->user->id]) }}">
                        <span>
                        {{-- Avatar --}}
                        @if($comment->user->hasAvatar())
                            <img class="avatar small"
                                 src="{{ route('images.avatar', ['image' => $comment->user->avatar ]) }}"/>
                        @else
                            <img class="avatar small" src="{{ asset('images/person.png') }}"/>
                        @endif
                        </span>
                        {{ $comment->user->name }}</a>
                </label>
                @if($comment->user->ownsArticle($comment->article))
                    <span class="badge badge-info">{{ __('comments.author') }}</span>
                @endif
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
                                <a class="btn btn-primary btn-sm"
                                   href="{{ route('comment.edit', ['comment' => $comment->id]) }}"
                                >
                                    {{ __('comments.button.edit') }}
                                </a>
                            @endcan

                            {{-- Delete comment button --}}
                            @can('delete', $comment)
                                <a class="btn btn-danger btn-sm deleteBtn" data-toggle="modal"
                                   data-target="#deleteConfirmModal"
                                   data-message="{{ __('comments.delete_confirm') }}"
                                   data-action="{{ route('comment.delete', ['comment' => $comment->id]) }}"
                                   href="#"
                                >
                                    {{ __('comments.button.delete') }}
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
    @endforeach
</ul>

{{-- Comments pagination links --}}
<div class="row justify-content-center">
    {{ $comments->links('vendor.pagination.simple-bootstrap-4') }}
</div>

