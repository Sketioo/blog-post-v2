<x-profile :sharedData="$sharedData" pagetitle="{{ $sharedData['username'] }}'s Profile">
    <div class="list-group">
        @foreach ($posts as $post)
            <x-post :post="$post" showAuthor="{{ $value = false }}">

            </x-post>
        @endforeach
    </div>
</x-profile>
