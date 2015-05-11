<?php
class Larangan_Kasus_Helper extends Root_Helper{
    const table_name = 'larangan_kasus_' ;
	//! we will use user model 
	public static function get_create_model() { return new Larangan_Kasus_Model(); }
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
		$id_admind = self::get_id_admind( Input::get("id_santri_name") ); 		
		$id_larangan = Input::get( "id_pelanggaran_name" );
		$tanggal = Input::get( "date_name" );

        $obj->id            =   $id	    			;
		$obj->idlarangan	=	$id_larangan			;
		$obj->idadmind   	= 	$id_admind ;
		$obj->tanggal		=	$tanggal ; 	
		return $obj;
	}
	public static function get_id_admind( $id_santri){
		$santri = Santri_Model::find($id_santri);
		return $santri->user->id;
	}
	public static function get_santri_model( $id_admind ){
		return Santri_Model::where("idadmind" ,"=" , $id_admind)->first();
	}
	public static function get_all_values($obj){
		$santriModel   = self::get_santri_model ( $obj->idadmind );
		$laranganModel = Larangan_Meta_Model::find( $obj->idlarangan );
		
		$array 		= array();
		$array	['id_santri_name']		=	$santriModel->id;
		$array	['santri_name']			=	$santriModel->user->first_name . "" . $santriModel->user->second_name;
		$array	['alamat_name']			=	$santriModel->user->desa->kecamatan->nama ."-" . $santriModel->user->desa->nama;;
		$array	['date_name']			=	$obj->tanggal;
		$array	['id_pelanggaran_name']	=	$obj->idlarangan;
		$array  ['pelanggaran_name']	=	$laranganModel->namaObj->nama;
		$array  ['session_name']		=	$laranganModel->sessionObj->nama;
		
		return $array;
	}
}
