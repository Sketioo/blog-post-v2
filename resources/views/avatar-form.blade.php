<x-layout pagetitle="Manage Avatar">
    <div class="container py-md-5 container--narrow">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT') <div class="mb-3">
                <label for="avatar" class="form-label">Update Avatar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="avatar" name="avatar"
                        aria-describedby="avatarHelp">
                    <label class="custom-file-label" for="avatar">Choose file</label>
                    <small id="avatarHelp" class="form-text text-muted">Supported image formats: JPG, JPEG, PNG.</small>
                    @error('avatar')
                        <p class=" m-0 small alert alert-danger shadow-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Avatar</button>
        </form>
    </div>

</x-layout>
