<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function searchPost($term)
    {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
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

    public function showEditForm(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }

    public function updatePost(Post $post, Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->update($validatedData);
        $username = auth()->user()->username;
        return back()->with('success', 'Post successfully updated!');
    }

    public function deletePost(Post $post)
    {
        // if (auth()->user()->can('delete', $post)) {
        //     $post->delete();
        //     return redirect()->route('users.profile', ['user' => $username])
        //         ->with('success', 'Post successfully deleted!');
        // }

        $username = auth()->user()->username;
        $post->delete();
        return redirect()->route('users.profile', auth()->user())
            ->with('success', 'Post successfully deleted!');
    }
}
