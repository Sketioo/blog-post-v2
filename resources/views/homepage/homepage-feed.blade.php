<x-layout>
    <div class="container py-md-5 container--narrow">
        <h3 class="text-center mb-4">
            Posts from Users You Follow
        </h3>
        @unless ($posts->isEmpty())
            <div class="list-group">
                @foreach ($posts as $post)
                    <x-post :post="$post" showAuthor>

                    </x-post>
                @endforeach
            </div>
            {{-- Create pagination --}}
            <div class="mt-3">
                {{ $posts->links('components.pagination') }}
            </div>
        @else
            <div class="text-center">
                <h2>Hello <strong>{{ $username }}</strong>, your feed is empty.</h2>
                <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don’t have
                    any friends to follow, that’s okay. You can use the “Search” feature in the top menu bar to find content
                    written by people with similar interests and then follow them.</p>
            </div>
        @endunless
    </div>
</x-layout>
