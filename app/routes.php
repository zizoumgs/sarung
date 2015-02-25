<?php
//! protect your forms in Laravel against CSRF
Route::when('*', 'csrf', array('post', 'put', 'delete'));

//! uang
Route::controller('uang'      , 'Uang_controller');
Route::get('admin_uang'     , 'Admin_uang@index');
Route::get('admin_uang/outcome'     , 'Admin_outcome@index');

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
Route::controller('sarung_admin/santri'                 , 'Admin_sarung_santri_cud');
Route::controller('sarung_admin/class'                  , 'Admin_sarung_class');
Route::controller('sarung_admin/ujis'                   , 'Admin_sarung_ujis');
//@larangan
Route::controller('sarung_admin/tindakan'               , 'Admin_sarung_larangan_nama');
Route::controller('sarung_admin/tindakan_meta'          , 'Admin_sarung_larangan_meta');
Route::controller('sarung_admin/tindakan_kasus'          , 'Admin_sarung_larangan_kasus');

//! i will remove this
Route::any('/delete_img',
				array('uses'=>'Admin_sarung_user_cud@getDelete_img','as' => 'delete_img')
			);

//! for updating
Route::controller('update'                 , 'first_update');

//Route::controller('/'                 , 'sarung_controller');
Route::controller('sarung_admin'      , 'Sarung_admin_controller');

Route::controller('/'     , 'login');

/* for uploading*/
//Route::put('eventupload', array('as' => 'admin.upload', 'uses' => 'App\Controllers\Admin\ImageController@postUpload'));

