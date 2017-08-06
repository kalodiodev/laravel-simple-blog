<div class="blog-post" style="margin-bottom: 2.5em">
    <h2 class="blog-post-title">{{ $article->title }}</h2>
    <p class="blog-post-meta">{{ $article->created_at }} by <a href="#">User</a></p>
    <hr>
    <p>{{ $article->description }}</p>

    <a href="/articles/{{ $article->slug }}">Read more...</a>

</div>