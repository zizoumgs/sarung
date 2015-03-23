<?php
class Santri_Helper extends Root_Helper{
    const table_name = 'santri' ;
	//! we will use user model 
	public static function get_create_model() { return new User_Model(); }
	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return self::get_create_model()->max('id') ;   }		
	public static function get_values_for_pagenation(){
		$where = array () ;
		if( Root_Helper::should_be_keep( Input::get('find_session_name') ) ) {
			$where ['find_session_name'] = Input::get('find_session_name');
		}
		if( Root_Helper::should_be_keep( Input::get('find_santri_name') ) ) {
			$where ['find_santri_name'] = Input::get('find_santri_name');
		}
		if( Input::get('find_formal_name') == 1)
			$where ['find_formal_name'] = Input::get('find_formal_name');
		return $where;
	}
	public static function get_obj_find(){
		$main   	= 	self::get_create_model() ;
		$session 	= 	Input::get('find_session_name');
		$santriexistence = Input::get('find_formal_name');
		$santri_name	= 	Input::get('find_santri_name');
		if( Root_Helper::should_be_keep( $session ) ){
			$main 	= 	$main->sessionname($session);
		}
		if( $santriexistence != 1 ) { $santriexistence = 0 ;}

		if( Root_Helper::should_be_keep( $santri_name ) ){
	        $main = $main->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".trim($santri_name)."%" ,
                                              "%".trim($santri_name)."%" )
                                        );
		}
		
		$main = $main->santriexistence( $santriexistence );
		return $main;
	}
	public static function get_the_obj($santri_obj , $id , $nis_number ){
        $session = Input::get('dialog_session_name')  ;
        //! get idsession
		$session_obj = new Session_Model();
        //! main database
        $santri_obj->id             =   $id	    			;
        $santri_obj->nis            =   $nis_number     	;
        $santri_obj->idadmind       =   Input::get( 'dialog_user_id' )			;
        $santri_obj->idsession      =   $session_obj->getfirst($session)->id	;
        $santri_obj->catatan        =   Input::get('catatan_name')		;
		return $santri_obj;
	}
	public static function get_the_obj_non_add($santri_obj , $id , $nis_number ){
        $session = Input::get('session_name')  ;
        //! main database
        $santri_obj->id             =   $id	    			;
        $santri_obj->nis            =   $nis_number     	;
        $santri_obj->idsession      =   $session	;
		$santri_obj->keluar			=	Input::get('keluar_name');
        $santri_obj->catatan        =   Input::get('catatan_name')		;
		return $santri_obj;
	}

	public static function get_values($the_obj){
		$values = array();
		$values ['session_name'] 	= 	$the_obj->idsession;
		$values ['id_santri_name']	=	$the_obj->id;
		$values ['santri_name']		=	$the_obj->user->first_name . " " . $the_obj->user->second_name;
		$values ['keluar_name']		=	$the_obj->keluar;
		$values ['catatan']	= 	$the_obj->catatan;
		$values ['foto']	=	$the_obj->user->foto;
		return $values;
	}
}
