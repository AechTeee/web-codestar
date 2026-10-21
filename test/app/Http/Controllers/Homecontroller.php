<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Homecontroller extends Controller
{
    public function index()
    {
        $title = 'Home';
        return view('Home', compact('title'));
    }

    public function dashboard()
    {
        $title = 'Dashboard';
        return view('dashboard', compact('title'));
    }
}
