<div class="col-3 col-md-3 offset-md-1">
    {{-- Archives --}}
    <div class="sidebar-module">
        <h4>{{ __('partials.sidebar.archives') }}</h4>
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

    {{-- Tags --}}
    <div class="sidebar-module">
        <h4>{{ __('partials.sidebar.tags') }}</h4>
        <ol class="tags">
            @foreach($tags as $tag)
                <li class="tag is-primary">
                    <a href="{{ route('tag.articles', ['tag' => $tag]) }}">{{ $tag }}</a>
                </li>
            @endforeach
        </ol>
    </div>
</div>