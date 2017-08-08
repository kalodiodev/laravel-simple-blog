<div class="blog-post">
    <h2 class="blog-post-title"><a href="/article/{{ $article->slug }}">{{ $article->title }}</a></h2>
    <p class="blog-post-meta">{{ $article->created_at->toFormattedDateString() }} by <a href="#">{{ $article->user->name }}</a></p>
    <hr>
    <p>{{ $article->description }}</p>

    <a href="/article/{{ $article->slug }}">Read more...</a>

</div>