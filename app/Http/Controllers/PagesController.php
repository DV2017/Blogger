<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // public function index(){
    //     return 'INDEX';
    // }
    public function index(){
        //example on how to set a title dynamically
        $title = "Welcome to MyLaravel";
        //load view - simple and dynamic where the variable is passed
        //return view('pages.index');
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }
    
    public function about(){
        $title = "About";
        return view('pages.about')->with('title', $title);
    }

    public function services(){
        //loading into an assoc array
        $data = array(
            'title' => 'Services',
            'services' => ['Tellen', 'Quality', 'Habitat']
        );
        return view('pages.services')->with($data);
    }
}
