<div class="blog-post">

    @if($article->hasImage())
        <img src="{{ asset(\App\Http\Controllers\ArticlesController::FEATURED_IMAGES_FOLDER . $article->image) }}"
             alt="" class="img-fluid" width="800">
    @endif

    <h2 class="blog-post-title"><a href="/article/{{ $article->slug }}">{{ $article->title }}</a></h2>
    <p class="blog-post-meta">{{ $article->created_at->toFormattedDateString() }} by <a href="#">{{ $article->user->name }}</a></p>
    @foreach($article->tags as $tag)
        <span class="badge badge-info">{{ $tag->name }}</span>
    @endforeach
    <hr>
    <p>{{ $article->description }}</p>

    <a  href="/article/{{ $article->slug }}">Read more...</a>

</div>