<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Role;
use ILluminate\support\Facades\Gate;

Route::get('/test', function () {
  event(new \App\Events\TestEvent());
  return 'Event fired';
});

Route::get('/', function () {
  return 'what up my brother';
});

Route::get('/create', function (Request $request) {


  return view('create');
})->name('create');
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
