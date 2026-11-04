<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Jobs\SendMailJob;

Route::get('/post',[PostController::class,'index'])->name('post.index');
Route::get('/post/create',[PostController::class,'create'])->name('post.create');
Route::post('/post',[PostController::class,'store'])->name('post.store');
Route::get('/post/{id}',[PostController::class,'show'])->name('post.show');
Route::get('/post/{id}/edit',[PostController::class,'edit'])->name('post.edit');
Route::put('/post/{id}',[PostController::class,'update'])->name('post.update');
Route::delete('/post/{id}',[PostController::class,'destroy'])->name('post.destroy');

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/role', function() {
    User::find(4)->roles()->toggle([1,2,3]);});

Route::get('/mail', function(){
    SendMailJob::dispatchAfterResponse();
    return 'Email sent after 1 minute';
    });

Route::get('/404', function() {
    abort(404);
});
