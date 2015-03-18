<?php
/*
 *		This class will suport add and delete , no edit option for this class instead , .
 *		you just delete that item and begin to edit
 *		database table name: kelasisi
*/
class Kelas_Isi_Controller extends admin{
    public function __construct(){
		parent::__construct(1);
		$this->helper = new Kelas_Isi_Helper;
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	
    public function getIndex(){
        $datas = array();
        $datas ['wheres']  =  $this->helper->get_values_for_pagenation();
        $datas ["items"] = $this->helper->get_obj_find()->orderBy('santri.id' , 'DESC')->paginate(15);
		$datas ["info"]     = $this->helper->get_table_info( $datas ["items"] );
		$datas ['helper'] = $this->helper;
        return View::make( "sarung.admin.kelas_isi.index" , $datas);
    }	

    public function postAdd(){
	    if($this->insert_to_db()){
	        return Redirect::to( root::get_url_admin_kelas_isi() )
				->with('message',  "Berhasil memasukkan ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_kelas_isi() )
				->with('message',  admin::get_error_message() );
		}
    }
    public function postDelete(){
        $url  = root::get_url_admin_kelas_isi();
        if($this->delete_to_db( Input::get('dialog_del_id_name') )){
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  admin::get_error_message() );
        }
    }
	
	/**
	 *	return null or obj
	*/
	private function get_needed_values_delete(){
		$idkelas		= 	Input::get('dialog_del_id_kelas_name'	) 	;
		$idsantri 		= 	Input::get('dialog_del_id_santri_name'	) 	;
		$nama_session  	= 	Input::get('dialog_del_session_name'	)	;
		if( empty($idkelas)){
			$this->set_error_message("Id Kelas Kosong");
			return null ;
		}
		if( empty($idsantri)){
			$this->set_error_message("Id Santri Kosong");
			return null;
		}
		if( empty($nama_session)){
			$this->set_error_message("Nama Session Kosong");
			return null;		
		}		
		return (object) array('idkelas' => $idkelas , 'idsantri' => $idsantri , 'nama_session' => $nama_session) ; 
	}
	private function should_be_deleted(){
		$values = $this->get_needed_values_delete();
		if( is_null ($values) ){
			
			return false;
		}
		$total = 0 ;
		$objs = Class_Model::getidujiansantri( $values->idkelas , $values->idsantri ,$values->nama_session);
		foreach($objs as $obj){
			$total = $obj->total;
		}
		if( $total <= 0 ){
			return true;
		}
		$this->set_error_message("You can`t delete this , because this person has score in examination");
		return false;
	}
    private function delete_to_db($id){
		//@ find examination that have relation with that class as well as santri id
		if( $this->should_be_deleted() ){
			$del_objects  [] = $this->helper->get_create_model()->find( $id );
			$save_objects [] = admin::get_saveid_obj( $this->helper->get_table_name() , $id ) ;
			return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
		}
		return false;
    }
	
    private function insert_to_db(){
        $id 				= 	admin::get_id( $this->helper->get_table_name() , $this->helper->get_max_id() );
		$save_objects = array($this->helper->get_the_obj( true , $id ));
		$del_objects  = array(SaveId::nameNid( $this->helper->get_table_name() , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}