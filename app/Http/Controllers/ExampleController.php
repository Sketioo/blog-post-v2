<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage() {
        return view('homepage');
    }

    public function getPost() {
        return view('single-post');
    }
}
