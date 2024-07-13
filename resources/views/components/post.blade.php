<a href="{{ route('posts.show', ['post' => $post->id]) }}"
    class="list-group-item list-group-item-action d-flex align-items-center">
    <img class="avatar-tiny mr-3 rounded-circle" src="{{ $post->user->avatar }}" />
    <div>
        <strong>
            {{ $post->title }}
        </strong>
        <small class="d-block text-muted">
            Posted on {{ $post->created_at->format('d/m/Y') }}
            @if ($showAuthor)
                by {{ $post->user->username }}
            @endif
        </small>
    </div>
</a>
