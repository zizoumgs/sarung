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
/**
 * this route is prepared to give a developer an information about something that should be wrong
 * @ params is an array
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
//                  url name                                class  name
Route::controller('sarung_admin/event'                  , 'Admin_sarung_event');
Route::controller('sarung_admin/pelajaran'              , 'Admin_sarung_pelajaran');
Route::controller('sarung_admin/session'                , 'Admin_sarung_session');
Route::controller('sarung_admin/kalender'               , 'Admin_sarung_kalender');
Route::controller('sarung_admin/jurusan'                , 'Admin_sarung_jurusan');
Route::controller('sarung_admin/kelas_root'             , 'Admin_sarung_kelas_root');
Route::controller('sarung_admin/kelas'                  , 'Admin_sarung_kelas');
Route::controller('sarung_admin/wali'                   , 'Admin_sarung_wali');
Route::controller('sarung_admin/ujian'                  , 'Admin_sarung_ujian');
Route::controller('sarung_admin/negara'                 , 'Admin_sarung_negara');
Route::controller('sarung_admin/propinsi'               , 'Admin_sarung_propinsi');
Route::controller('sarung_admin/kabupaten'              , 'Admin_sarung_kabupaten');
Route::controller('sarung_admin/kecamatan'              , 'Admin_sarung_kecamatan');
Route::controller('sarung_admin/desa'                   , 'Admin_sarung_desa');
Route::controller('sarung_admin/user'                   , 'Admin_sarung_user_cud');
Route::controller('sarung_admin/santri'                   , 'Admin_sarung_santri_cud');
// for uploading
Route::any('/upload_santri',
				array('uses'=>'Admin_sarung_user_cud@set_upload','as' => 'set_upload')
			);
// for uploading
Route::any('/upload_santri__succeded',
				array('uses'=>'Admin_sarung_user_cud@set_upload__succeded','as' => 'set_upload__succeded')
			);

Route::any('/delete_img',
				array('uses'=>'Admin_sarung_user_cud@getDelete_img','as' => 'delete_img')
			);

//! for updating
Route::controller('update'                 , 'first_update');

//Route::controller('/'                 , 'sarung_controller');
Route::controller('sarung_admin'      , 'Sarung_admin_controller');


/* for uploading*/
//Route::put('eventupload', array('as' => 'admin.upload', 'uses' => 'App\Controllers\Admin\ImageController@postUpload'));

/*
Route::get('outcome', 'outcome@index');
Route::get('income', 'income@index');
Route::get('subdivisi', 'divisisub@index');
Route::get('', 'login@index');
*/

