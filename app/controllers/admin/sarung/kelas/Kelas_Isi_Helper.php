<?php
class Kelas_Isi_Helper {
    const table_name = 'kelasisi' ;

	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return self::get_create_model()->max('id') ;   }	
	public static function get_create_model() { return new Class_Model(); }
		

	private static function get_proper_the_obj($add  , $id ){
        $obj = self::get_create_model();
        if( $add )
            $obj->id = $id;
        else
            return $obj->find( $id );
		return $obj;
	}
	/**
	 *	return particular object
	*/	
    public static function get_the_obj( $add , $id ){
		$obj = self::get_proper_the_obj( $add , $id );
        //! get idsession
		$session_obj = new Session_Model();
		$id_session = $session_obj->getfirst( Input::get('dialog_session_name') )->id;
		//! get id class
		$kelas_obj = new Kelas_Model();
		$id_kelas = $kelas_obj->getFirst( Input::get('dialog_kelas_name') )->id;
		//!
        $obj->idsession		=   $id_session      	;
        $obj->idkelas		=   $id_kelas        	;
		$obj->idsantri		=   Input::get('dialog_santri_id')	;
        $obj->catatan		=   Input::get('dialog_catatan_name')	;
        return $obj;
    }
	public static function should_be_keep($text){
		if( $text  !== "All" && $text != "" )
			return true;
		return false;
	}
	
	public static function get_obj_find(){
		$model   	= 	Santri_Model::get_santri_raw() ;
		$session 	= 	Input::get('find_session_name');
		$santri_name	  	=	Input::get('find_santri_name');
		if( self::should_be_keep($session) ){
			$model = $model->where('session.nama','=',$session);
		}
		if( self::should_be_keep( $santri_name ) ){
	        $model = $model->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".$santri_name."%" ,
                                              "%".$santri_name."%" )
                                        );				
		}
		return $model;
	}
	public static function get_values_for_pagenation(){
		$where = array () ;
		if( self::should_be_keep( Input::get('find_session_name') ) ) {
			$where ['find_session_name'] = Input::get('find_session_name');
		}
		if( self::should_be_keep( Input::get('find_santri_name') ) ) {
			$where ['find_santri_name'] = Input::get('find_santri_name');
		}
		return $where;
	}
	public static function get_table_info( $obj ){
		return sprintf('Show %1$s of %2$s', $obj->getFrom() , $obj->getTotal()) ;
	}

}
