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
/*
$user = new User;
$user->id = 5;
$user->email = 'ema';
$user->password = Hash::make('example');
$user->idgroup = 1;
$user->save();
*/
//Route::get('home', 'HomeController');
//Route::controller('home', 'HomeController');
Route::get('logout', function()
{
    Auth::logout();
    return Redirect::to('login');
});

Route::post('login', 'login@index');
Route::get('login', 'login@index');

Route::get('admin_uang'     , 'Admin_uang@index');
Route::get('admin_uang/outcome'     , 'Admin_outcome@index');
//! uang
Route::controller('uang'      , 'uang');

//! admin_uang
//Route::controller('admin_uang/income_cud'      , 'Admin_uang_controller');
//! admind_income
Route::get('admin_uang/income'          , 'Admin_income@index');
Route::controller('admin_uang/income_cud'      , 'Admin_income_cud');
Route::controller('admin_uang/outcome_cud'      , 'Admin_outcome_cud');
Route::controller('admin_uang/subdivisi_crud'      , 'Admin_subdivisi_crud');
Route::controller('admin_uang/divisi_crud'      , 'Admin_divisi_crud');
//! all sarung admin controller
Route::controller('sarung_admin/event'                 , 'Admin_sarung_event');
Route::controller('sarung_admin/pelajaran'              , 'Admin_sarung_pelajaran');
Route::controller('sarung_admin/session'               , 'Admin_sarung_session');
Route::controller('sarung_admin/kalender'              , 'Admin_sarung_kalender');
Route::controller('sarung_admin/jurusan'              , 'Admin_sarung_jurusan');

//Route::controller('/'                 , 'sarung_controller');
Route::controller('sarung_admin'      , 'Sarung_admin_controller');


/*
Route::get('outcome', 'outcome@index');
Route::get('income', 'income@index');
Route::get('subdivisi', 'divisisub@index');
Route::get('', 'login@index');
*/

