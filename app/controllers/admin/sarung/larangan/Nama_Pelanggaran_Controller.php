<?php
/*
*/
class Nama_Pelanggaran_Controller extends admin{
    public function __construct(){
		parent::__construct(1);
		admin::init_helper(new Nama_Pelanggaran_Helper);
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	
    public function getIndex(){
        $datas = array();
        $datas ['wheres']  	=	admin::get_helper()->get_values_for_pagenation();
        $datas ["items"] 	= 	admin::get_helper()->get_obj_find()->orderBy('id' , 'DESC')->paginate(15);
		$datas ["info"]     = 	admin::get_helper()->get_table_info( $datas ["items"] );
		$datas ['helper'] 	= 	admin::get_helper();
        return View::make( "sarung.admin.pelanggaran.nama_pelanggaran.index" , $datas);
    }
	/**
	*/
	public function getAdd(){
		$datas = array();
		return View::make( "sarung.admin.pelanggaran.nama_pelanggaran.add" , $datas);
	}
    public function postAdd(){
	    if($this->insert_to_db()){
	        return Redirect::to( root::get_url_admin_nama_pelanggaran() )
				->with('message',  "Berhasil memasukkan ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_nama_pelanggaran() )
				->with('message',  admin::get_error_message() );
		}
    }
    private function insert_to_db(){
        $id 				= 	admin::get_id( admin::get_helper()->get_table_name() , admin::get_helper()->get_create_model()->max('id') );
        $event = admin::get_helper()->get_the_obj( self::get_helper()->get_create_model() , $id );
        $save_id = SaveId::nameNid( admin::get_helper()->get_table_name() , $id ) ; 
		return DB::transaction(function()use ($event , $save_id ){
            $event->save();
            if($save_id)
                $save_id->delete();		
			return true;
		});			
    }	
	/**
	*/
    public function getEdit($id){
        $obj = admin::get_helper()->get_create_model()->find($id);
        if($obj){
			$datas = array();
			$datas ['id_pelanggaran']		=	$id;
			$datas ["nama_pelanggaran_name"] = $obj->nama;
            return View::make('sarung.admin.pelanggaran.nama_pelanggaran.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_nama_pelanggaran () );
        }
    }

	/**
	*/
    public function postEdit(){
		$id = Input::get('id');
	    if($this->edit_to_db( $id  )){
	        return Redirect::to( root::get_url_admin_nama_pelanggaran() )
				->with('message',  "Berhasil merubah ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_nama_pelanggaran('edit/'.$id) )
				->with('message',  admin::get_error_message() );
		}
    }
	private function edit_to_db( $id ){
		$the_obj = admin::get_helper()->get_create_model()->find($id);
		$del_objects  = array() ;
		$save_objects [] = admin::get_helper()->get_the_obj( $the_obj , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects);		
	}
	
	/**
	*/
    public function getDelete( $id ){
        $obj = admin::get_helper()->get_create_model()->find($id);
        if($obj){
			$datas = array();
			$datas ['id_pelanggaran']		=	$id;
			$datas ["nama_pelanggaran_name"] = $obj->nama;
            return View::make('sarung.admin.pelanggaran.nama_pelanggaran.delete' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_nama_pelanggaran () );
        }
    }
	/**
	*/
    public function postDelete(){
		$id = Input::get('id');
	    if($this->delete_to_db( $id  )){
	        return Redirect::to( root::get_url_admin_nama_pelanggaran() )
				->with('message',  "Berhasil menghapus ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_nama_pelanggaran('delete/'.$id) )
				->with('message',  admin::get_error_message() );
		}
    }
	private function delete_to_db($id){
		$the_obj = admin::get_helper()->get_create_model()->find($id);
		$del_objects  [] = $the_obj;
		$save_objects [] = admin::get_saveid_obj( admin::get_helper()->get_table_name() , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
}