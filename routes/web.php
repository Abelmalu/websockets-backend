<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Role;
use Illuminate\support\Facades\Gate;
use App\Http\Controllers\PostController;
use Illuminate\support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


//email verification related route


//the link to verify the email
Route::get('/email/verify', function () {
  return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();

  return redirect('/create');
})->middleware(['auth', 'signed'])->name('verification.verify');




Route::post('/email/verification-notification', function (Request $request) {
  $request->user()->sendEmailVerificationNotification();

  return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/test', function () {
  event(new \App\Events\TestEvent());
  return 'Event fired';
});

Route::get('/', function () {
  return 'what up my brother';
});

Route::get('/create', function (Request $request) {


  return view('create');
})->name('create')->middleware('verified');



Route::get('/user_home', function (Request $request) {


  return view('home');
})->middleware('role:0')->name('user_home');
Route::get('/admin_home', function (Request $request) {

  if(Gate::allows('admin')){

    return view('admin');


  }

  return abort(403);


 
})->name('admin_home');


Route::get('/loginvieew', function (Request $request) {

  return view('login.blade.php');
})->name('loginview');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/register', function (Request $request) {

  return view('register');
})->name('registerview');


//post routes

Route::get('/posts',[PostController::class,'index'])->name('index.post');


