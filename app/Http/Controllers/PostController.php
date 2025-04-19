<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Post;

class PostController extends Controller
{
    public function index(){

       // $posts = Post::all();  // easy loading

        $posts = Post::all();

        return view('post',['posts'=> $posts]);



    }
}
