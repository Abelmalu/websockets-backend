<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
  event(new \App\Events\TestEvent());
  return 'Event fired';
});

Route::get('',function(){
    return 'what up my brother';

});