<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Profile">
    @include('profile.profile-posts-only')
</x-profile>
