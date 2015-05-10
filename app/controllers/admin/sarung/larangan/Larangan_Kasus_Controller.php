<?php
/*
*/
class Larangan_Kasus_Controller extends admin{
    public function __construct(){
		parent::__construct(1);
		admin::init_helper(new Larangan_Kasus_Helper);
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	
    public function getIndex(){
        $datas = array();
        $datas ['wheres']  	=	admin::get_helper()->get_values_for_pagenation();
        $datas ["items"] 	= 	admin::get_helper()->get_obj_find()->orderBy('id' , 'DESC')->paginate(15);
		$datas ["info"]     = 	admin::get_helper()->get_table_info( $datas ["items"] );
		$datas ["types"]	=	array("B","M","R");
		$datas ['helper'] 	= 	admin::get_helper();
        return View::make( "sarung.admin.pelanggaran.larangan_kasus.index" , $datas);
    }
	public function anyChangesantriajax(){
		$idSantri = Input::get("id_santri_name");
		$santri   = Santri_Model::find( $idSantri);
		if($santri){
			$name = $santri->user->first_name ." " . $santri->user->second_name;
			$alamat = $santri->user->desa->kecamatan->nama ."-" . $santri->user->desa->nama;
		}
		else{
			$name = "There are no santri who has that id";
			$alamat = "There are no santri who has that id";
		}
		$result = array( "namaSantri" => $name , "alamatSantri" => $alamat );
		echo json_encode( $result); 
	}
	public function anyChangepelanggaranajax(){
		$id = Input::get("id_pelanggaran_name");
		$obj = Larangan_Meta_Model::find($id);		
		if(!$obj){
			$name    = "There are no pelanggaran who has that id";
			$session = "There are no pelanggaran who has that id";
		}
		else{
			$name    = $obj->namaObj->nama;
			$session = $obj->sessionObj->nama;
		}
		$result = array( "pelanggaran_name" => $name , "session_name" => $session);
		echo json_encode( $result); 
	}	
	public function getTypes(){
		return array("B","M","R");
	}
	/**
	*/
	public function getAdd(){
		$datas = array();
		$datas ["types"]	=	$this->getTypes();
		return View::make( "sarung.admin.pelanggaran.larangan_kasus.add" , $datas);
	}
    public function postAdd(){
	    if($this->insert_to_db()){
	        return Redirect::to( root::get_url_admin_larangan_meta() )
				->with('message',  "Berhasil memasukkan ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_larangan_meta('add/') )
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
			$datas ['id']		=	$id;
			$datas ["types"]	=	$this->getTypes();
			$datas = array_merge( $datas , admin::get_helper()->get_all_values( $obj ) );
            return View::make('sarung.admin.pelanggaran.larangan_meta.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_larangan_meta () );
        }
    }

	/**
	*/
    public function postEdit(){
		$id = Input::get('id');
	    if($this->edit_to_db( $id  )){
	        return Redirect::to( root::get_url_admin_larangan_meta() )
				->with('message',  "Berhasil merubah ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_larangan_meta('edit/'.$id) )
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
			$datas ['id']		=	$id;
			$datas ["types"]	=	$this->getTypes();
			$datas = array_merge( $datas , admin::get_helper()->get_all_values( $obj ) );
            return View::make('sarung.admin.pelanggaran.larangan_meta.delete' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_larangan_meta () );
        }
    }
	/**
	*/
    public function postDelete(){
		$id = Input::get('id');
	    if($this->delete_to_db( $id  )){
	        return Redirect::to( root::get_url_admin_larangan_meta() )
				->with('message',  "Berhasil menghapus ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_larangan_meta('delete/'.$id) )
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