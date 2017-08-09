<div class="col-3 col-md-3 offset-md-1">
    {{-- Tags --}}
    <div>
        <h3>Tags</h3>
        <ul class="tags">
            @foreach($tags as $tag)
                <li class="tag is-primary">
                    <a href="/tags/{{ $tag }}">{{ $tag }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>