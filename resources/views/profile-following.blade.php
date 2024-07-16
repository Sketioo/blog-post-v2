<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Following">
  @include('profile-following-only')
</x-profile>
