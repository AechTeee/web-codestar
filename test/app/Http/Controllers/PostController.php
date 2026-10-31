<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facedes\DB;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Auth;
use Illuminate\Support\Gate;
use Illuminate\Support\Log;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        $user = Auth::user();
        Log::critical('daily check info: ' . $user?->name ?? 'truong' , ['user'=>$user]);
        return view('post_index', ['posts' => $posts]);
    }

    public function show($id)
    {
        $post = Post::select('id','title','content','created_at','updated_at')->where('id',$id)->first();
        return view('post_show',['post'=>$post]);
    }

    public function create()
    {
        return view('post_create');
    }

    public function store(Request $request)
    {
        $post = new Post();

        $file = $request->file('image_file');
        $file_name = date('Ymd') . random_int(10000, 10000000) . '.' . $file->getClientOriginalExtension();
        $file->move('upload', $file_name); // /upload/{{ filename }}
        $post->user_id = 2;
        $post->slug = Str::slug($request->title);
        $post->title = $request->title ?? 'default';
        $post->content = $request->content ?? 'default';
        $post->file_path = 'upload/' . $file_name;
        $post->save();
        return redirect()->route('post.index');
    }

    public function edit($id)
    {
        $post = Post::select('id','title','content','created_at','updated_at')->where('id',$id)->first();
        return view('post_edit',['post'=>$post]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        return redirect()->route('post.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('post.index');
    }
}
