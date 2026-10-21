<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
        $posts = DB::table('posts') -> where('title', 'like', '%Lavarel%') -> get() ;
        return view('post_index', ['posts' = $posts]);

    public function show($id){
        $post = DB::table('posts') -> where('id', $id) -> get();

        return view('post_show', ['post' => $post]);
        
    }
    
}
