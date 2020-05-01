<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
// Model
use App\User;
use App\UserDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role === 'admin'){
            return view('adminhome');
        }
        $userdetail = User::find(auth()->user()->id)->userdetail;
        $skills = User::find(auth()->user()->id)->skills;
        $skills = $skills->implode('skill',',');
        return view('home', compact('userdetail','skills'));
    }
}
