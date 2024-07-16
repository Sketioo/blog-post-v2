<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Followers">
    @include('profile-followers-only')
</x-profile>
