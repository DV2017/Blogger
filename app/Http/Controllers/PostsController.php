<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post; 

//use DB;  -- use this structure if you want to use sql commands; 
//see comment on 'DB::' as below

class PostsController extends Controller
{
    /**
     * Create a new controller middleware authentication instance.
     * to user-control all posts
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show'] ] );
        //create exceptions so that guests can view all posts and individual posts
        //excepts index and show methods below 
        //this takes care of guests not accessing edit and delete functions
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Eloquent ORM(object relational mapper)
        //to use model methods
        //replaces SQL to fetch all data in assoc array
        //$posts = Post::all();
        //$post = Post::where('id', 1)->get();
        //$posts = DB::select('SELECT * FROM posts');
        //limit posts
        //$posts = Post::orderBy('title', 'desc')->take(1)->get();
        //paginate
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        //$posts = Post::orderBy('title', 'desc')->get();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        //return request()->all(); //if you want to see data submitted for storage prior to insert
        //size of image set to 1999: apache file upload size limit 2gb (2000)
        $this->validate($request, [
            'title' =>  'required|unique:posts|max:255',
            'body'  =>  'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')){
            //make a unique file name for image
            //get image file with extension: laravel commands
            $filenameWithExtension = $request->file('cover_image')->getClientOriginalName();
            //extract file name without extension: php
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            //get extension: laravel
            $fileExtension = $request->file('cover_image')->getClientOriginalExtension();
            //re-patch with time() to give unique name
            $filenameToStore = $filename.'_'.time().'.'.$fileExtension; 
            //upload image to storage/app/public
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
            //the above path is not visible to public
            //therefore, run a php artisan command to create a symlink to a folder under /public
            //php artisan storage:link 
            //this makes the images visible publicly
        } else {
            $filenameToStore = 'no_image.jpg';
        }
        
        
        //insert the post by calling the App\Post object
        //just like using it in tinker from terminal
        $post = new Post;
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $filenameToStore;
        $post->save();

        return redirect('posts')->with('success', 'Post submitted');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show data for that id from url
        //$post = DB::table('posts')->find($id);
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //copied from show(id) above
        $post = Post::find($id);

        //with additional checks so that registered users cannot edit another's posts
        if(auth()->user()->id !== $post->user_id)
            return redirect('posts')->with('error', 'Unauthorised action.');

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //updates received request
        $this->validate($request, [
            'title' =>  'required',
            'body'  =>  'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')){
            //make a unique file name for image
            //get image file with extension: laravel commands
            $filenameWithExtension = $request->file('cover_image')->getClientOriginalName();
            //extract file name without extension: php
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            //get extension: laravel
            $fileExtension = $request->file('cover_image')->getClientOriginalExtension();
            //re-patch with time() to give unique name
            $filenameToStore = $filename.'_'.time().'.'.$fileExtension; 
            //upload image to storage/app/public
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
            //the above path is not visible to public
            //therefore, run a php artisan command to create a symlink to a folder under /public
            //php artisan storage:link 
            //this makes the images visible publicly
        }


        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        //edit only if file image has changed
        if($request->hasFile('cover_image')){
            $post->cover_image = $filenameToStore;
        }
        $post->save();

        return redirect('posts')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete single post
        $post = Post::find($id);

        //with additional checks so that registered users cannot delete another's posts
        if(auth()->user()->id !== $post->user_id)
            return redirect('posts')->with('error', 'Unauthorised action.');

        //delete image - only user uploaded ones; not the default no_image.jpg
        if($post->cover_image != 'no_image.jpg') {
            //delete image
            //use the storage library
            Storage::delete('public/cover_images/'.$post->cover_image);
        }


        $post->delete();
        return redirect('posts')->with('success','Post Deleted');
        
    }
}
