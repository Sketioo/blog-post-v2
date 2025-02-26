<x-layout pagetitle="Edit {{ $post->title }}">
    <div class="container py-md-5 container--narrow">
        <a href="{{ route('users.profile', Auth::user()) }}" class="text-muted mb-3 d-flex align-items-center">
            <i class="fas fa-user mr-2"></i> Back to Profile
        </a>
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
                <input value="{{ old('title', $post->title) }}" name="title" id="post-title"
                    class="form-control form-control-lg form-control-title" type="text" placeholder=""
                    autocomplete="off" />
                @error('title')
                    <p class=" m-0 small alert alert-danger shadow-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-group">
                <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
                <textarea name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class=" m-0 small alert alert-danger shadow-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button class="btn btn-primary">Save New Post</button>
        </form>
    </div>
</x-layout>
