<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bt2controller;

Route::get('/', function () {
    return view('bt2');
});
Route::post('/', [bt2controller::class, 'create']);