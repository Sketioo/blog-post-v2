<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->only('storePost', 'createPost');
    }

    public function showPost(Post $post)
    {
        $post['body'] = Str::markdown($post->body);
        return view('single-post', [
            'post' => $post,
        ]);
    }

    public function createPost()
    {
        return view('create-post');
    }

    public function storePost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['body'] = strip_tags($validatedData['body']);
        $validatedData['user_id'] = auth()->id();

        $post = Post::create($validatedData);

        return redirect()->route('posts.show', ['post' => $post->id])
            ->with('success', 'Post created successfully!');
    }
}
