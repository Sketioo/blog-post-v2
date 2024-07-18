<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Followers">
    @include('profile.profile-followers-only')
</x-profile>
