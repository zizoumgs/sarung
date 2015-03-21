<?php
class Helper_File {
	private static function get_upload_path($additional) { return root::get_path_base()."/foto/".$additional ; }
	private static function mkdir($path , $mode = 0777 , $recursive = true ){
		if (!file_exists( $path  )){
			return mkdir( $path , $mode , $recursive);
		}
		return false;
	}
	private static function copy( $source , $destination   ){
		if ( file_exists( $source  )){
            return copy( $source , $destination);
		}
		return false;
	}
	public static function delete( $source){
		if ( file_exists( $source  )){
            return File::delete( $source );
		}
		return false;
	}

	private static function get_path_base_date(){
		$path = self::get_upload_path( date("Y") );
		self::mkdir( $path );
		//! make folder base of month
		$path .= "/".date("m");
		self::mkdir( $path );
		return $path ;
	}
    public static function convert_path_to_url( $file_path ){
        return str_replace( root::get_path_base() , root::get_url_base() , $file_path );
    }
    public static function convert_url_to_path( $file_url ){
        return str_replace( root::get_url_base() , root::get_path_base() ,  $file_url );
    }
    
	public static function get_tmp_path($additional = "" ){ return root::get_path_base()."/tmp/".$additional ;}
	public static function get_tmp_url ($additional = "" ){ return root::get_url_base()."/tmp/".$additional ; }
	public static function get_url_file_from_tmp($file_name = 'bolivia.jpg' ){
		$file_name 		= 	$file_name;
		$full_file_name = 	self::get_tmp_path( $file_name ) ;
        $new_file       =   sprintf('%1$s/%2$s.%3$s'            ,
                                    self::get_path_base_date()  ,
                                    uniqid()                    ,
                                    pathinfo( $file_name , PATHINFO_EXTENSION) );
        if( self::copy( $full_file_name , $new_file ) ){
            return self::convert_path_to_url($new_file) ;
        }
        return 'Error';
	}
    public static function delete_old_tmp_file(){
        $files = File::files( self::get_tmp_path() );
        foreach( $files as $file){
            $timestamp = File::lastModified($file);
            if( self::is_it_old_enough( $timestamp) )
                self::delete( $file );
		}
    }
    private static function is_it_old_enough( $timestamp ){
        return ($timestamp !== false) && ( (time()-$timestamp)  > 24*3600 );
    }
}