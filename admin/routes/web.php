<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@HomeIndex');
Route::get('/visitor', 'VisitorController@VisitorIndex');