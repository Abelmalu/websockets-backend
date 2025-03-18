<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;



Route::get('/chatmessages',[MessageController::class,'messages']);
Route::post('/message',[MessageController::class,'createMessage']);