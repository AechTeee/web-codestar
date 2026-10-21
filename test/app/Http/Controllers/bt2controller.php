<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class bt2controller extends Controller
{
    public function index()
    {
        return view('bt2');
    }

    public function create(Request $request){
        $title = $request->input('title');
        $slug = $request->input('slug');
        $description = $request->input('description');

        if(is_null($title) && is_null($slug) || is_null($description)){
            return back()->withInput();
        }

        return view('bt2_view',[
            'title' => $title,
            'slug' => $slug,
            'description' => $description
        ]);
    }
}
