<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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

        return view('profile-user', [
            'avatar' => $user->avatar,
            'user' => $user,
        ]);
    }

    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function updateAvatar(User $user, Request $request)
    {
        $validatedImg = $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $image = $validatedImg['avatar'];
        $imageName = hexdec(uniqid()) . '-' . auth()->user()->username . '.jpeg';

        $manager = new ImageManager(new Driver());

        $imageUrl = 'public/storage/avatars/' . $imageName;
        // dd($imageUrl);
        $image = $manager->read($image)->resize(300, 300)->toJpeg(80)
            ->save(base_path($imageUrl));

        $user = auth()->user();

        $oldAvatar = $user->avatar;
        if ($oldAvatar && $oldAvatar != 'fallback-avatar.jpg') {
            $oldAvatarPath = 'storage/avatars/' . basename($oldAvatar);
    
            if (file_exists(public_path($oldAvatarPath))) {
                unlink(public_path($oldAvatarPath));
            } else {
                return back()->with('failure', 'Avatar not found.');
            }
        }
        $user->avatar = $imageName;
        $user->save();
        return back()->with('success', 'Avatar updated successfully!');
    }
}
