<?php
class Santri_Helper {
    const table_name = 'ujian' ;
	
	public static function get_create_model() { return new Santri_Model(); }
	
	public static function get_foto_url( $id , $name ){
		$url = asset ( '/foto/'.$id.'/'.$name  ) ;
		$path = helper_get_path_from_abs_url( $url );
        if( ! File::exists($path) ){
			$url = asset ( '/foto/unknow-48.png');
        }
        return $url;		
	}
	
	public static function get_nis( $id_santri ){
		$obj = self::get_create_model()->find( $id_santri);
        $date = new DateTime( $obj->session->awal);
        $nis = $date->format("y").str_pad($obj->nis,$obj->session->perkiraansantri,"0", STR_PAD_LEFT);
		return $nis;
	}	

}
