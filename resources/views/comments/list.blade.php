<ul>
    @foreach($comments as $comment)
        <li>
            <div>
                <label class="text-info">{{ $comment->user->name }} </label>
                <span> - {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="comment-body">
                {{ $comment->body }}
            </div>
        </li>

    @endforeach
</ul>

<div class="row justify-content-center">
    {{ $comments->links('vendor.pagination.simple-bootstrap-4') }}
</div>