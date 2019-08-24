<?php


Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('{path}','HomeController@index')->where( 'path', '[A-Za-z]+' );


