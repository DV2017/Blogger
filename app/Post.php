<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Table name
    protected $table = 'posts';
    //primary key: this is used by find() to track data
    protected $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    //creating a 1:many relationship for this post object to a user
    //this post 'belongs to' a user
    //see also the user table for relationship
    public function user() {
        return $this->belongsTo('App\User');
    }  
}
