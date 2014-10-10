<?php
/**
 *	Helper for this application
 *  write require app_path().'/libs/helpers.php'; inside of -
 *  app\start\global.php
*/
function helper_get_url_admin_uang	   	()	{ 		return sprintf('%1$s/admin_uang' 	, helper_get_base_url());}
function helper_get_url_admin_sarung	()	{ 		return sprintf('%1$s/sarung_admin' 	, helper_get_base_url());}	

function helper_get_base_url(){
    return URL::to('/');
}
/**
 *	return path
*/
function helper_get_base_path(){
	return public_path();
}

/**
 *	return url string
*/
function helper_get_url_foto(){
	return helper_get_base_url()."/foto";
}
/**
 *	folder in which folder foto exist
 *	each folder is unique , since the name has followed user id
 *	return path string 
*/	
function helper_get_path_foto(){	return helper_get_base_path()."/foto";	}
/**
 *	folder in which i use blufish to upload easily
 *	return string 
*/	
function helper_get_url_blueimp(){		return helper_get_base_url()."/asset/blueimp";	}
/**
 *	sign which i used to make name from path
 *	" " = _empty , "-" = "_sub" , "(" = _kur_op , ")" = "_kur_cl"
*/

function helper_get_my_rules(){
	return array( "." => "_empty" ,
				   " " => "_sub" ,
				   "(" => "_kur_op" ,
				   ")" => "_kur_cl"
	);
}
/**
 *	change certain character in a text
 *	input name
 *	return nice name
*/
function helper_get_correct_name($name){
	$array = helper_get_my_rules();
	$result = $name;
	foreach($array as $key => $val){
		//$result = str_replace($term, $sign ,$result);
		$result = str_replace($key, $val ,$result);
	}
	return $result;
}
/**
 *	change certain character in a text
 *	input name
 *	return nice name
*/
function helper_get_anti_correct_name($name){
	$array = helper_get_my_rules();
	$result = $name;
	foreach($array as $key => $val){
		//$result = str_replace($term, $sign ,$result);
		$result = str_replace($val, $key ,$result);
	}
	return $result;
}

/**
 *	convert name of file to name which is accepted by html/js
 *	@ param : path
 *	return name
*/
function helper_make_name_from_path($path){
	//! get extention
	$ext  = pathinfo($path,PATHINFO_EXTENSION);
	//! get base name
	$name = pathinfo($path,PATHINFO_BASENAME);
	//! remove ext from name
	$name = str_replace($ext,"",$name);
	//! convert any dot and space from name
	$result = helper_get_correct_name($name);
	//! convert dot in extention with -
	$ext_mod = "_limitnya_".$ext;
	//! combine ext mod with its name
	return $result . $ext_mod ; 
}
/**
 *	anti @ helper_make_name_from_path
 *	@ param : name
 *	return name of file 
*/
function helper_anti_make_name( $name ){
	//! explode string
	$exp_name = explode( "_limitnya_" , $name );
	$total = count($exp_name) ; 
	//! get extention
	$ext = $exp_name[$total-1];
	//! combine all exploding name
	$result = "";
	for( $x = 0 ; $x < $total - 1  ; $x++ ){
		$result .= $exp_name [$x] ;
	}
	//! back to original name
	$result = helper_get_anti_correct_name($result);
	//! combine result with ext
	return $result . $ext ;
}
/**
 *	get name from url  , /testweb/test.txt to test.txt
 *	@ param : path of string ; not url
 *	return name 
*/
function helper_get_name_from_path($file){
	return pathinfo($file,PATHINFO_BASENAME);
}
/**
 *	get name from url  , /testweb/test.txt to test.txt
 *	@ param : string
 *	return extendtion of path
*/
function helper_get_ext_from_path($file){
	return pathinfo($file,PATHINFO_EXTENSION);
}
/**
 *	convert absolute url to full path
 *	return extendtion of path
*/
function helper_get_path_from_abs_url($file){
    $nama_file = parse_url( $file );
    return $_SERVER['DOCUMENT_ROOT']. $nama_file ['path'];
}
/**
*  @ parameter is string of path not url
*  return array files
*/
function helper_get_all_file_in_dir($path){
	$files_ = scandir($path , 1);
    $files = array();
    foreach($files_ as $file){
	    if( !is_dir ($path ."/".$file ) ){
	        $files [] = $file;
	    }
	}
    return array_diff($files, array('.', '..'));
}


