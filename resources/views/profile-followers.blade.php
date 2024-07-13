<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Followers">
    <div class="list-group">
        @foreach ($followers as $follow)
            <a href="{{ route('users.followers', $follow->userDoingTheFollowing->username) }}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{ $follow->userDoingTheFollowing->avatar }}" />
                <span>{{ $follow->userDoingTheFollowing->username }}</span>
            </a>
        @endforeach
    </div>
</x-profile>
