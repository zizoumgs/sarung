<?php
class User_Helper extends Root_Helper {
	//! i am sorry table name didnt same with class name 
    const table_name = 'admin' ;
	
	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return self::get_create_model()->max('id') ;   }
	
	public static function get_create_model() { return new User_Model; }

	public static function get_status_values(){
        /*
   		0 : banned studend 
   		1 : non_aktif -> cannot edit , just view 
   		2 : aktif 	 -> can edit
        */
        return array(
						0 => 'Banned'     ,
						1 => "Non Aktif"				,
						2 => "Aktif"
                       );		
	}
	
    public static function get_status( $number){
		$array = self::get_status_values() ;
		return $array [ $number ] ; 
    }
	
	public static function get_rules(){
        return array(
			'first_name'				=> 	"required" 	,
			'second_name'				=> 	"required" 	,
			'tanggal_lahir_name'		=>	'required'	,
			'tempat_lahir_name'			=>	'required'	,
			'group_name'				=>	'required'	,
			'result_alamat_name'		=>	'required'
        );
	}
	/**
	 *	return array
	**/
    public static function get_validator(){
        return Validator::make(  Input::all() , self::get_rules() );
    }
	/**
	 *
	**/
	public static function is_password_match(){
		return ( Input::get(	'first_password_name' ) === Input::get(	'second_password_name'	) ) ;
	}
	/*
	*/
	private static function get_jenis(){
		if( Input::get('gender_name') == 1 ){
			return 'L';
		}
		return 'W' ;
	}
	/**
	 */
	private static function get_proper_the_obj( $add , $id ){
        $obj = self::get_create_model();
        if( self::is_additional( $add ) )
            $obj->id = $id;
        else
            $obj = $obj->find( $id );
		return $obj ;
	}
	/**
	*/
	private static function want_change_pass($mode){
		if ( self::is_additional( $mode ) ){
			return true;
		}
		return ( Input::get('change_password_name') == 1 ) && (self::is_password_match()) ; 
	}
	/**
	*/
	private static function is_additional( $mode ){		return ( $mode == "add" );	}
	/**
	*/
	private static function should_take_image_url_from_tmp( $mode ){
		return ( self::is_additional( $mode ) ) || ( Input::get('sign_name') == 1 );
	}
	/**
	*/
	private static function get_foto_url( $mode ){
		if ( self::should_take_image_url_from_tmp($mode) ){
			return Helper_File::get_url_file_from_tmp( Input::get('file_name') );
		}
		return Input::get('url_name');		
	}
	/**
	 *	return particular object
	*/	
    public static function get_the_obj( $mode   , $id ){
		$obj = self::get_proper_the_obj( $mode , $id ) ;
       	$obj->first_name	= 	Input::get(   	'first_name' 				)	;
   		$obj->second_name	= 	Input::get(		'second_name'				)	;
		if ( self::want_change_pass( $mode ) ){
			$obj->password		= 	Hash::make( Input::get(		'first_password_name'		) )	;
		}
		$obj->email			=	Input::get(		'email_name'				)	;
		$obj->lahir			= 	Input::get(		'tanggal_lahir_name'		)	;
		$obj->idtempat		= 	Input::get(		'tempat_lahir_name'			)	;
		$obj->idgroup		= 	Input::get(		'group_name'		)			;
		$obj->iddesa		= 	Input::get(		'result_alamat_name'		)	;
		$obj->status		=	Input::get(     'status_name') ;
		$obj->jenis			=	self::get_jenis();
		$obj->foto			=	self::get_foto_url($mode); 
        return $obj;
    }
	/**
	 *	You will need this to get data from db and display it to form
	 *	return array
	*/
    public static function get_values( $obj){
        $datas  [ 'email_name' ]	=   $obj->email;
		$datas  [ 'first_name' ]	=   $obj->first_name;
		$datas  [ 'second_name']	=	$obj->second_name;
		$datas	[ 'status_name']	=	$obj->status;
		$datas  [ 'group_name' ]  	=   $obj->idgroup;
		$datas	[ 'tempat_lahir_name']		=	$obj->idtempat;
		$datas	[ 'tanggal_lahir_name' ]	= 	$obj->lahir;
		$datas  [ 'url_name']				=	$obj->foto;
		$datas	[ 'path_name']				=	Helper_File::convert_url_to_path( $obj->foto );
		$datas  [ 'file_name']				=	pathinfo($obj->foto)['filename'];
		$datas  [ 'desa_name']				=	$obj->iddesa;
		$datas	[ 'gender_name']			=	$obj->jenis;
        return $datas;
    }
	
	/**
	 *	return object
	*/
	public static function get_obj_find(){
		$main   	= 	self::get_create_model() ;
		$email 		= 	Input::get('find_email_name');
		$status 	= 	Input::get('find_status_name');
		if( Root_Helper::should_be_keep( $email ) ){
	        $main = $main->whereRaw(" (email LIKE ? ) " ,array( "%".trim($email)."%" )  );
		}
		if( Root_Helper::should_be_keep( $status ) ){
			$main 	= 	$main->statusLimitation( $status );
		}
		return $main;
	}
	public static function get_values_for_pagenation(){
		$where = array () ;
		$email 		= 	Input::get('find_email_name');
		$status 	= 	Input::get('find_status_name');
		if( Root_Helper::should_be_keep( $email ) ){
			$where ['find_email_name'] = $email;
		}
		if( Root_Helper::should_be_keep( $status ) ){
			$where ['find_status_name'] = $status ;
		}
		return $where;
	}
	public static function get_table_info( $obj ){
		return sprintf('Show %1$s of %2$s', $obj->getFrom() , $obj->getTotal()) ;
	}
}
