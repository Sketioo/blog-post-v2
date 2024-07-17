<div class="list-group">
  @foreach ($posts as $post)
      <x-post :post="$post" showAuthor="{{ $value = false }}">
      </x-post>
  @endforeach
  <div class="mt-4">
    {{ $posts->links('components.pagination') }}
  </div>
</div>