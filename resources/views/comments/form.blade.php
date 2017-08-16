<div class="card top-space">
    <div class="card-header">
        Post Comment
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('comment.store', ['slug' => $article->slug]) }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="comment" class="label">Your Comment:</label>
                <textarea id="comment" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body"
                >@if(isset($comment)){{ old('body',$comment->body) }}@else{{ old('body') }}@endif</textarea>

                @if ($errors->has('body'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body') }}
                    </div>
                    <small class="form-text text-muted">Please check your comment.</small>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Submit Comment</button>
            </div>
        </form>
    </div>
</div>
