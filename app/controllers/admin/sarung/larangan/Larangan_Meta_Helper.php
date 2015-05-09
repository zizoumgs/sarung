<?php
class Larangan_Meta_Helper extends Root_Helper{
    const table_name = 'larangan_meta' ;
	//! we will use user model 
	public static function get_create_model() { return new Larangan_Meta_Model(); }
	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return self::get_create_model()->max('id') ;   }

	public static function get_values_for_pagenation(){
		$where = array () ;
		if( Root_Helper::should_be_keep( Input::get('find_session_name') ) ) {
			$where ['find_session_name'] = Input::get('find_session_name');
		}
		if( Root_Helper::should_be_keep( Input::get('find_pelanggaran_name') ) ) {
			$where ['find_pelanggaran_name'] = Input::get('find_pelanggaran_name');
		}
		if( Root_Helper::should_be_keep( Input::get('find_type_name') )  )
			$where ['find_type_name'] = Input::get('find_type_name');
		return $where;
	}
	public static function get_obj_find(){
		$main   	= 	self::get_create_model();
		$session	= 	Input::get('find_session_name');
		$type		=	Input::get('find_type_name');
		$nama		=	Input::get('find_pelanggaran_name');
		if( Root_Helper::should_be_keep( $session ) ){
			//$where [ $this->get_session_filter_name()] = $selected;
			$main = $main->wheresession($session);
		}
		if( Root_Helper::should_be_keep( $type ) ){
			//$where [ $this->get_session_filter_name()] = $selected;
			$main = $main->wherejenis( $type );
		}
		if( Root_Helper::should_be_keep( $nama ) ){
			//$where [ $this->get_session_filter_name()] = $selected;
			$main = $main->wherenama( $nama );
		}
		
		return $main;
	}
	public static function get_the_obj($obj , $id){
		$pelanggaran_name	= 	Input::get('pelanggaran_name');
		$session_name		= 	Input::get('session_name');
		
		$objTmp = new Larangan_Nama_Model();
		$idlarangan = $objTmp->get_id_by_name( $pelanggaran_name);
		
		//@ session`s id
		$objTmp = new Session_Model();
		$idsession = $objTmp->get_id_by_name(  $session_name );
		

        $obj->id            =   $id	    			;
        $obj->point	        =   Input::get("point_name")    ;
		$obj->idsession		=	$idsession			;
		$obj->idlarangan	=	$idlarangan			;
		$obj->jenis			=	Input::get("type_name");
		$obj->hukuman		=	Input::get("hukuman_name");
		
		return $obj;
	}
	public static function get_all_values($obj){
		$array = array();
        $array	['point_name'] 			=   $obj->point ;
		$array	['session_name']		=	$obj->sessionObj->nama;
		$array	['pelanggaran_name']	=	$obj->namaObj->nama			;
		$array	["type_name"]			=	$obj->jenis;
		$array	["hukuman_name"]		=	$obj->hukuman;
		return $array;
	}
}
