<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('users', function()
{
	Route::get('user/{id}', 'UserController@showProfile');
});
*/
/*if there are no additionale url (just host and public), web will go to ShowWelcome function in class homeController */
//Route::get('/', 'HomeController@showWelcome');
//Route::get('outcome', 'outcome@index');
//Route::get('/{id}', '{id}@index') ;
//Route::controller('/', 'UserController');
Route::get('/outcome', 'outcome@index');
Route::get('/income', 'income@index');
Route::get('/subdivisi', 'divisisub_control@index');


