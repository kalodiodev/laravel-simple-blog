<div class="col-3 col-md-3 offset-md-1">
    {{-- Tags --}}
    <div class="sidebar-module">
        <h4>Archives</h4>
        <ol class="list-unstyled">
            @foreach($archives as $archive)
                <li>
                    <a href="{{ route('archives', ['year' => $archive['year'], 'month' => $archive['month_index']]) }}">
                        {{ $archive['year'] . ' ' . $archive['month'] }}
                    </a>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="sidebar-module">
        <h4>Tags</h4>
        <ol class="tags">
            @foreach($tags as $tag)
                <li class="tag is-primary">
                    <a href="/tags/{{ $tag }}">{{ $tag }}</a>
                </li>
            @endforeach
        </ol>
    </div>
</div>