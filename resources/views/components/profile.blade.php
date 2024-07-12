<x-layout>
    <div class="container py-md-5 container--narrow">
        <h2>
            <img class="avatar-small" src="{{ $sharedData['avatar'] }}" />
            {{ $sharedData['username'] }}
            @if (auth()->user()->username != $sharedData['username'] && !$isAlreadyFollowed)
                <form class="ml-2 d-inline" action="{{ route('follow.create', $sharedData['username']) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
                </form>
            @endif
            @if ($sharedData['isAlreadyFollowed'])
                <form class="ml-2 d-inline" action="{{ route('follow.remove', $sharedData['username']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
                </form>
            @endif

            @if (auth()->user()->username === $sharedData['username'])
                <a href="{{ route('users.avatar.edit') }}" class="btn btn-secondary btn-sm">Manage Avatar</a>
            @endif
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            <a href="{{ route('users.profile', $sharedData['username']) }}"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == '' ? 'active' : '' }}">Posts:
                {{ $sharedData['posts_count'] }}</a>
            <a href="{{ route('users.followers', $sharedData['username']) }}"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == 'followers' ? 'active' : '' }}">Followers:
                3</a>
            <a href="{{ route('users.following', $sharedData['username']) }}"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == 'following' ? 'active' : '' }}">Following:
                2</a>
        </div>

        <div class="profile-slot-content">
            {{ $slot }}
        </div>
    </div>
</x-layout>
