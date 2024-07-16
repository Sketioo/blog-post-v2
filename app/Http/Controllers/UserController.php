<?php

namespace App\Http\Controllers;

use App\Events\OurExampleEvent;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
            event(new OurExampleEvent(['username' => auth()->user()->username, 'action' => 'login']));
            return redirect('/')->with('success', 'You have successfully logged in!');
        } else {
            return redirect('/')->with('failure', 'Login failed!');
        }
    }

    public function logout()
    {
        event(new OurExampleEvent(['username' => auth()->user()->username, 'action' => 'logout']));
        auth()->logout();
        return redirect('/')->with('success', 'You have succesfully logout!');
    }

    public function showCorrectPage()
    {
        if (auth()->check()) {
            $username = auth()->user()->username;
            $posts = auth()->user()->feedPosts()->latest()->paginate(4);
            return view('homepage-feed', [
                'username' => $username,
                'posts' => $posts,
            ]);
        } else {
            return view('homepage');
        }
    }

    private function getSharedData($user)
    {
        $isAlreadyFollowed = Follow::where('user_id', auth()->id())
            ->where('target_user_id', $user->id)
            ->exists();
        $user['posts'] = $user->posts()->latest()->get();
        $user['posts_count'] = $user->posts()->orderby('created_at')->count();

        View::share('sharedData', [
            'avatar' => $user->avatar,
            'username' => $user->username,
            'posts_count' => $user->posts()->count(),
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
            'isAlreadyFollowed' => $isAlreadyFollowed,
        ]);
    }

    public function showUserProfile(User $user)
    {
        $this->getSharedData($user);

        return view('profile-post', [
            'posts' => $user->posts()->latest()->get(),
        ]);
    }

    public function showUserProfileRaw(User $user)
    {
        return response()->json(['theHTML' => view('profile-posts-only', ['posts' => $user->posts()->latest()->get()])->render(), 'docTitle' => $user->username . "'s Profile"]);
    }

    public function showUserFollowers(User $user)
    {
        $this->getSharedData($user);
        return view('profile-followers', [
            'followers' => $user->followers()->latest()->get(),
        ]);
    }

    public function showUserFollowersRaw(User $user)
    {
        return response()->json(['theHTML' => view('profile-followers-only', ['followers' => $user->followers()->latest()->get()])->render(), 'docTitle' => $user->username . "'s Followers"]);
    }

    public function showUserFollowing(User $user)
    {
        $this->getSharedData($user);
        return view('profile-following', [
            'following' => $user->following()->latest()->get(),
        ]);
    }

    public function showUserFollowingRaw(User $user)
    {
        return response()->json(['theHTML' => view('profile-following-only', ['following' => $user->following()->latest()->get()])->render(), 'docTitle' => 'Who ' . $user->username . " Follows"]);
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
        if ($oldAvatar && basename($oldAvatar) != 'fallback-avatar.jpg') {
            $oldAvatarPath = 'storage/avatars/' . basename($oldAvatar);

            if (file_exists(public_path($oldAvatarPath))) {
                unlink(public_path($oldAvatarPath));
            } else {
                return back()->with('failure', 'Old avatar not found.');
            }
        }
        $user->avatar = $imageName;
        $user->save();
        return back()->with('success', 'Avatar updated successfully!');
    }
}
