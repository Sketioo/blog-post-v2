<?php

namespace App\Http\Controllers;

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

        User::create($validatedData);
        return "<h1>This is register page!</h1>";
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
            return view('homepage-feed');
        } else {
            return 'sorry';
        }
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
}
