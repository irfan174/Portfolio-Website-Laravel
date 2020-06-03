<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@HomeIndex');

Route::get('/visitor', 'VisitorController@VisitorIndex');


//Service section routes
Route::get('/service', 'ServiceController@ServiceIndex');
Route::get('/servicedata', 'ServiceController@getServiceData');
Route::post('/servicedelete', 'ServiceController@ServiceDelete');
Route::post('/servicedetails', 'ServiceController@getServiceDetailsData');
Route::post('/serviceupdate', 'ServiceController@ServiceUpdate');
Route::post('/serviceinsert', 'ServiceController@ServiceInsert');


//Course section routes
Route::get('/courses', 'CoursesController@CoursesIndex');
Route::get('/coursesdata', 'CoursesController@getCoursesData');
Route::post('/coursesdelete', 'CoursesController@CoursesDelete');
Route::post('/coursesdetails', 'CoursesController@getCoursesDetailsData');
Route::post('/coursesupdate', 'CoursesController@CoursesUpdate');
Route::post('/coursesinsert', 'CoursesController@CoursesInsert');