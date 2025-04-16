<?php

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


Route::get('/login', function (Request $request) {

  return view('login.blade.php');
})->name('login');
