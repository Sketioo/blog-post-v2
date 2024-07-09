<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'min:4', 'max:8', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);
        auth()->login($user);
        return redirect('/')->with('success', 'User created successfully!');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required',
        ]);

        if (auth()->attempt(
            [
                'username' => $validatedData['loginusername'],
                'password' => $validatedData['loginpassword'],
            ]
        )) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in!');
        } else {
            return redirect('/')->with('failure', 'Login failed!');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You have succesfully logout!');
    }

    public function showCorrectPage()
    {
        if (auth()->check()) {
            $username = auth()->user()->username;
            return view('homepage-feed', ['username' => $username]);
        } else {
            return view('homepage');
        }
    }

    public function showUserProfile(User $user)
    {
        // $userPosts = User::withCount('posts')->get();
        $user['posts'] = $user->posts()->latest()->get();
        $user['posts_count'] = $user->posts()->orderby('created_at')->count();
        // return view('profile-user', [
        //     'user' => $user,
        // ]);
        return view('profile-user', [
            'user' => $user,
        ]);
    }
}
