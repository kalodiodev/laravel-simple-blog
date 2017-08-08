<div class="col-3 col-md-3 offset-md-1">
    {{-- Tags --}}
    <div>
        <h3>Tags</h3>
        @foreach($tags as $tag)
            <a href="/?tag={{ $tag->name }}" style="font-size: 1.25rem">
                <span class="badge badge-primary">{{ $tag->name }}</span>
            </a>
        @endforeach
    </div>
</div>