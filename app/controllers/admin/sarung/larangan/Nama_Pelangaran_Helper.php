<?php
class Nama_Pelanggaran_Helper extends Root_Helper{
    const table_name = 'larangan_nama' ;
	//! we will use user model 
	public static function get_create_model() { return new Larangan_Nama_Model(); }
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
		$main   	= 	self::get_create_model();
		$santri_name	= 	Input::get('find_santri_name');
		if( $santri_name != "" ){
			$main = $main->where("nama","LIKE", "%".$santri_name."%");
		}
		return $main;
	}
	public static function get_the_obj($santri_obj , $id){
		$santri_name	= 	Input::get('nama_pelanggaran_name');
        $santri_obj->id             =   $id	    			;
        $santri_obj->nama	        =   $santri_name     	;
		return $santri_obj;
	}
}
