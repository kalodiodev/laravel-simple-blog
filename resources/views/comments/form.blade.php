<div class="card top-space">
    <div class="card-header">
        Post Comment
    </div>
    <div class="card-body">
        <form method="post" action="/article/{{ $article->slug }}/comment">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="comment" class="label">Your Comment:</label>
                <textarea id="comment" class="form-control" name="body"></textarea>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Submit Comment</button>
            </div>
        </form>
    </div>
</div>
