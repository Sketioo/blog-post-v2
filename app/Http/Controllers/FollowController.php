<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{

    public function createFollow(User $user)
    {
        //* Check if user follow himself
        if (auth()->user()->id === $user->id) {
            return redirect()->back()->with('failure', 'You can not follow yourself!');
        }

        //* Check if user already followed the target user
        $isAlreadyFollowed = Follow::where('user_id', auth()->id())
            ->where('target_user_id', $user->id)
            ->exists();
        if ($isAlreadyFollowed) {
            return redirect()->back()->with('failure', 'You already followed this user!');
        }

        $followUser = new Follow();
        $followUser->user_id = auth()->user()->id;
        $followUser->target_user_id = $user->id;
        $followUser->save();

        return redirect()->back()->with('success', 'Follow successfully!');
    }

    public function removeFollow(User $user)
    {

        Follow::where('user_id', auth()->id())
            ->where('target_user_id', $user->id)
            ->delete();
            
        return redirect()->back()->with('success', 'Unfollow successfully!');
    }

}
