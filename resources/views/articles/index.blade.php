<div class="blog-post">

    @if($article->hasImage())
        <img src="{{ asset(\App\Services\ArticleImageService::folder() . $article->image) }}"
             alt="" class="img-fluid" width="800">
    @endif

    <h2 class="blog-post-title"><a href="/article/{{ $article->slug }}">{{ $article->title }}</a></h2>
    <p class="blog-post-meta">{{ $article->created_at->toFormattedDateString() }} {{ __('articles.by') }}
        <a href="{{ route('profile.show', ['user' => $article->user->id])  }}">{{ $article->user->name }}</a>
    </p>
    @foreach($article->tags as $tag)
        <span class="badge badge-info">{{ $tag->name }}</span>
    @endforeach
    <hr>
    <p>{{ $article->description }}</p>

    <a  href="/article/{{ $article->slug }}">{{ __('articles.read_more') }}</a>

</div>