<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
  event(new \App\Events\TestEvent());
  return 'Event fired';
});

Route::get('/', function () {
  return 'what up my brother';
});

Route::get('/create', function (Request $request) {


  return view('create');
});
Route::get('/home', function (Request $request) {


  return view('home');
})->name('home');


Route::get('/loginvieew', function (Request $request) {

  return view('login.blade.php');
})->name('loginview');

Route::post('/login',[LoginController::class,'login'] )->name('login');

