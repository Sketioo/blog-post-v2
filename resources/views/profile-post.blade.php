<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Profile">
    @include('profile-posts-only')
</x-profile>
