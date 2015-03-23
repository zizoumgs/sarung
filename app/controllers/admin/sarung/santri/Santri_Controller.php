<?php
/*
*/
class Santri_Controller extends admin{
    public function __construct(){
		parent::__construct(1);
		admin::init_helper(new Santri_Helper);
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	
    public function getIndex(){
        $datas = array();
        $datas ['wheres']  	=	admin::get_helper()->get_values_for_pagenation();
        $datas ["items"] 	= 	admin::get_helper()->get_obj_find()->orderBy('id' , 'DESC')->paginate(15);
		$datas ["info"]     = 	admin::get_helper()->get_table_info( $datas ["items"] );
		$datas ['helper'] 	= 	admin::get_helper();
        return View::make( "sarung.admin.santri.index" , $datas);
    }
	/**
	*/
    public function getEdit($id){
        $obj = Santri_Model::find($id);
        if($obj){
			$datas = admin::get_helper()->get_values( $obj );
			$datas ['helper']	=	admin::get_helper();
			$datas ['id']		=	$id;
            return View::make('sarung.admin.santri.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_santri() );
        }
    }
	/**
	*/
    public function postAdd(){
	    if($this->insert_to_db()){
	        return Redirect::to( root::get_url_admin_santri() )
				->with('message',  "Berhasil memasukkan ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_santri() )
				->with('message',  admin::get_error_message() );
		}
    }
	/**
	*/
    public function postEdit(){
	    if($this->edit_to_db( Input::get('id') )){
	        return Redirect::to( root::get_url_admin_santri() )
				->with('message',  "Berhasil merubah ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_santri() )
				->with('message',  admin::get_error_message() );
		}
    }
	/**
	*/
    public function getDelete( $id ){
        $obj = Santri_Model::find($id);
		if( ! Santri_Model::can_be_deleted($id)  ){
			return Redirect::to( root::get_url_admin_santri() )
				->with('message',  'Anak ini sudah memiliki kelas , oleh karenanya tidak bisa di hapus.' );
		}
        elseif($obj){
			$datas = admin::get_helper()->get_values( $obj );
			$datas ['helper']	=	admin::get_helper();
			$datas ['id']		=	$id;
            return View::make('sarung.admin.santri.delete' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_santri() );
        }
    }
	/**
	*/
    public function postDelete(){
        $url  = root::get_url_admin_santri();
        if($this->delete_to_db( Input::get('id') )){
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  admin::get_error_message() );
        }
    }
	
    private function delete_to_db($id){
		//@ find examination that have relation with that class as well as santri id
		$session_id = Input::get('session_name');
		$session_name = Session_Model::find($session_id)->nama;
		$the_santri_obj = Santri_Model::find($id);
		$del_objects  = array() ;
		//! prepare nis for save
		$save_objects [] = $this->get_old_nis_obj_for_save( $the_santri_obj ) ;
		//! prepare santri for delete
		$del_objects []  = $the_santri_obj;
		//! prepare old id for save 
		$save_objects [] = admin::get_saveid_obj( 'santri' , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
	private function get_old_nis_obj_for_save( $the_santri_obj ){		
		$nis_obj = new Save_Nis_Model();
		$nis_obj->nis           =   $the_santri_obj->nis ;
        $nis_obj->idsession     =   $the_santri_obj->idsession;
		return $nis_obj;
	}
	/**
	 *	becareful.I am sorri , (~_~)
	*/
	private static function get_nis_number_and_( $session_name, & $operated_obj){
		$nis = new Nis_Helper( $session_name ) ;
		if( $nis->check_obj_nis() ){
			$operated_obj  [] = $nis->get_nis_obj();
		}
		return $nis->get_nis_number();
	}
	private function edit_to_db( $id ){
		$session_id = Input::get('session_name');
		$session_name = Session_Model::find($session_id)->nama;
		$the_santri_obj = Santri_Model::find($id);
		$del_objects  = array() ;
		if( Santri_Model::find($id)->idsession != $session_id ){
			//! change 
			$save_objects [] = $this->get_old_nis_obj_for_save( $the_santri_obj ) ;
			$nis_number = $this->get_nis_number_and_( $session_name ,  $del_objects ) ;
		}
		else{
			$nis_number =  $the_santri_obj->nis;
		}
		$save_objects [] = admin::get_helper()->get_the_obj_non_add( $the_santri_obj , $id , $nis_number);
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects);		
	}
    private function insert_to_db(){
        $id 				= 	admin::get_id( 'santri' , Santri_Model::max('id') );
		$del_objects  [] 	= 	SaveId::nameNid( 'santri' , $id );
		$nis_number = $this->get_nis_number_and_( Input::get('dialog_session_name')  ,  $del_objects ) ;
			
		$save_objects = array(
			admin::get_helper()->get_the_obj(
			new Santri_Model ,
			$id ,
			$nis_number )
		);
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}