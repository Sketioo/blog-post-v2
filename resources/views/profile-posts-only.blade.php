<div class="list-group">
  @foreach ($posts as $post)
      <x-post :post="$post" showAuthor="{{ $value = false }}">
      </x-post>
  @endforeach
</div>