<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

//dashboard
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fetch user id from the authentication (session)
        $user_id = Auth::id();
        //SELECT * from user where id = $id
        //1 record is returned. 
        $user = User::find($user_id);
        //returns to view with data using with helper function
        //this makes the user's posts available to the view 
        return view('home')->with('posts', $user->posts);
    }
}
