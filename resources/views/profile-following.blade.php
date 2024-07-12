<x-profile :sharedData="$sharedData">
  <div class="list-group">
      @foreach ($following as $follow)
          <a href="{{ route('users.profile', $follow->userBeingFollowed->username) }}" class="list-group-item list-group-item-action">
              <img class="avatar-tiny" src="{{ $follow->userBeingFollowed->avatar }}" />
              <span class="username">{{ $follow->userBeingFollowed->username }}</span>
          </a>
      @endforeach
  </div>
</x-profile>
