<x-layout>
    <div class="container py-md-5 container--narrow">
        <h2>
            <img class="avatar-small" src="{{ $avatar }}" />
            {{ $user->username }}
            @if ($user->id !== auth()->id() && !$isAlreadyFollowed)
            <form class="ml-2 d-inline" action="{{ route('follow.create', $user) }}" method="POST">
                @csrf
                <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
            </form>
        @elseif ($user->id !== auth()->id())
            <form class="ml-2 d-inline" action="{{ route('follow.remove', $user)}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
            </form>
        @endif
        
            @if (auth()->user()->id === $user->id)
                <a href="{{ route('users.avatar.edit') }}" class="btn btn-secondary btn-sm">Manage Avatar</a>
            @endif
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            <a href="#" class="profile-nav-link nav-item nav-link active">Posts: {{ $user->posts_count }}</a>
            <a href="#" class="profile-nav-link nav-item nav-link">Followers: 3</a>
            <a href="#" class="profile-nav-link nav-item nav-link">Following: 2</a>
        </div>

        <div class="list-group">
            @foreach ($user->posts as $post)
                <a href="{{ route('posts.show', ['post' => $post->id]) }}"
                    class="list-group-item list-group-item-action"> <img class="avatar-tiny"
                        src="{{ $avatar }}" />
                    <strong>
                        {{ $post->title }}
                    </strong>
                    on {{ $post->created_at->format('d/m/Y') }}
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
