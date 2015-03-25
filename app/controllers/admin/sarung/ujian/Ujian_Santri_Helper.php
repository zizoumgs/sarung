<?php
class Ujian_Santri_Helper extends Root_Helper{
    const table_name = 'ujiansantri' ;

	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return self::get_create_model()->max('id') ;   }	
	public static function get_create_model() { return new Ujis_Model(); }
	
	private static function get_correct_obj( $mode , $id ){
		if( $mode){
			$obj = self::get_create_model();
			$obj->id = $id ;
			return $obj;
		}
		else{
			return self::get_create_model()->find( $id ) ;
		}
		
	}
	private static function get_prefix_name( $add ){
		if( $add ){
			return "dialog_add_";			
		}
		return "dialog_edit_";
	}
	/**
	 *	return particular object
	*/	
    public static function get_the_obj( $add , $id ){
        $obj = self::get_create_model();
        $prefix = self::get_prefix_name( $add ); 
		$idujian    	=   Input::get( $prefix.'id_ujian_name'		)  ;
        $idsantri   	=   Input::get( $prefix.'id_santri_name'	) ;
        $nilai      	=   Input::get( $prefix.'nilai_name'		) ;

		$ujian_obj = Ujian_Model::find(  $idujian );
		
		$obj = self::get_correct_obj($add , $id ); 
        $obj->idsession		=   $ujian_obj->kalender->idsession   	;
        $obj->idpelajaran	=   $ujian_obj->idpelajaran;
		$obj->idsantri		=   $idsantri	;
		$obj->idujian		=   $idujian	;
		$obj->nilai			=	Input::get($prefix.'nilai_name');
        $obj->catatan		=   '' ;
        return $obj;
    }
	public static function get_the_obj_find( & $wheres_content , $limit_query){
		$session 		= 	Input::get('find_session_name');
		$pelajaran  	=	Input::get('find_pelajaran_name');
		$kelas		  	=	Input::get('find_kelas_name');
		$santri		  	=	Input::get('find_santri_name');
		$wheres = "";
		$wheres_content_two = array();
		if( Root_Helper::should_be_keep($session) ){
			$wheres .= " and ses.nama =  ? "; 
			$wheres_content ['find_session_name'] = $session ;
			$wheres_content_two []= $session;
		}
		if( Root_Helper::should_be_keep( $pelajaran) ){
			$wheres .= " and pel.nama =  ? "; 
			$wheres_content ['find_pelajaran_name'] = $pelajaran ; 
			$wheres_content_two []= $pelajaran;
		}
		if( Root_Helper::should_be_keep( $kelas) ){
			$wheres .= " and kel.nama =  ? "; 
			$wheres_content ['find_kelas_name'] = $kelas ;
			$wheres_content_two []= $kelas;
		}
		if( Root_Helper::should_be_keep( $santri ) ){
			$wheres .= " and (first_name LIKE ? or second_name LIKE ?) ";
			$wheres_content ['find_santri_name'] = $santri;
			for ($x = 0 ; $x < 2 ; $x++){
				$wheres_content_two []= "%".$santri."%";
			}
		}
		$model   	= 	self::get_create_model()->get_raw_query(
							$wheres_content_two 	 ,
							$wheres			,
							$limit_query ) ;
		return $model;
	}
	public static function get_the_obj_find_add( & $wheres_content , $limit_query){
		$id_ujian		  	=	Input::get('find_id_ujian_name');
		$santri		  	=	Input::get('find_santri_name');
		$ujian_obj = "";
		$wheres = "";
		if( Root_Helper::should_be_keep( $id_ujian ) ){
	        $ujian_obj = Ujian_Model::find($id_ujian) ;
		}
		
		$model   	= 	self::get_create_model()->get_raw_query_add(
							$ujian_obj	,
							$santri		,
							$limit_query ) ;
		return $model;
	}	
	public static function get_limit_text( $limit ){
		$from = 0 ; 
		if( Input::get('page') ){
			$from = Input::get('page');
		}
		return sprintf(' limit %1$s , %2$s ', $from  , $limit );
	}
	public static function get_pagination( $obj_query , $limit){
		return Paginator::make( $obj_query, count( $obj_query),  $limit );;
	}
	public function get_info( $pagination ){
		return sprintf('Show %1$s of %2$s' , $pagination->getFrom() , $pagination->count());
	}
}
