<?php
class User_Controller extends Admin{
	private $upload_handler ;
    public function __construct(){
		parent::__construct(1);
		admin::init_helper(new User_Helper);
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	/**
	 *Ajax
	***/
	public function anyStartupload(){
        $option = array(
	        'upload_dir' => Helper_File::get_tmp_path() , 
            'upload_url' => Helper_File::get_tmp_url() 	,
			'image_versions' => array()
        );
        $this->upload_handler = new UploadHandler($option , false);
        $this->upload_handler->set_filter( $this , "uploading_succeded" , array() );
        $this->upload_handler->initialize();	
	}
    public function uploading_succeded(){
		return array("fileName" => $this->upload_handler->the_file_name() );
    }
	
	
	private static function get_alamat_val( $current_id ){
		if($current_id > -1 ){
			return Desa_Model::find( $current_id )->kecamatan->nama;
		}
		elseif( Input::get('find_alamat_name') != "" ){
			$val = Input::get('find_alamat_name');
			Session::put('find_alamat_session_name', $val  , 5);
			return $val ; 
		}
		else{
			return Session::get('find_alamat_session_name');
		}

	}
	private static function get_alamat_combo($current_id = -1 ){
		$val = trim( self::get_alamat_val( $current_id ) ); 
		$desa = new Desa_Model();
		$objs = $desa->kecamatanname($val )->get();
		$array ['desas'] 				= 	$objs;
		$array ['current_desa'] 		= 	$current_id;
		return  View::make("sarung.admin.user.alamat" , $array );
	}
	/**
	 *	Ajax 
	*/
	public function anyFindalamat(){
		return self::get_alamat_combo() ;
	}
	
    public function getIndex(){
        $datas = array();
        $datas ['wheres']  	= 	admin::get_helper()->get_values_for_pagenation();
        $datas ["items"] 	= 	admin::get_helper()->get_obj_find()->orderBy('updated_at' , 'DESC')->paginate(15);
		$datas ["info"]     = 	admin::get_helper()->get_table_info( $datas ["items"] );
		$datas ['helper']	=	admin::get_helper();
        return View::make( "sarung.admin.user.index" , $datas);
    }
    public function getAdd(){
		//Helper_File::move_file_from_tmp();
		$datas = array();
		$datas ['alamat_desa'] = $this->get_alamat_combo();
		$datas ['helper']	=	admin::get_helper();
        return View::make( "sarung.admin.user.add" , $datas) ;
    }
    public function postAdd(){
        $validator = admin::get_helper()->get_validator();
		if ( ! admin::get_helper()->is_password_match()){
            return Redirect::to( root::get_url_admin_user('add') )
				->with('message',    'Passwords is not same' );			
		}
        elseif ( $validator->fails() ){            
            $message = implode ( "<br>",$validator->messages()->all() ) ;
            return Redirect::to( root::get_url_admin_user('add') )
				->with('message',    $message )->withInput();
        }
        else{
            if($this->insert_to_db()){
				Helper_File::delete_old_tmp_file();
                return Redirect::to( root::get_url_admin_user('add') )
					->with('message',  "Berhasil memasukkan ke database");
            }
            else{
                return Redirect::to( root::get_url_admin_user('add') )
					->with('message', admin::get_error_message() )->withInput();
            }
        }
        
    }
    public function getEdit($id){
        $obj = admin::get_helper()->get_create_model()->find($id);
        if($obj){
			$datas = admin::get_helper()->get_values( $obj );
			$current_id = $datas ['desa_name'];
			$datas ['alamat_desa'] = $this->get_alamat_combo( $current_id );
			$datas ['helper']	=	admin::get_helper();
			$datas ['id']		=	$id;
            return View::make('sarung.admin.user.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_user() );
        }
    }

    public function postEdit(){
        $edit_url  = root::get_url_admin_user('edit/'.Input::get("id"));
        $validator = admin::get_helper()->get_validator();  
        if ( $validator->fails() ){ 
            $message = implode ( $validator->messages()->all() ) ;
            return Redirect::to( $edit_url )->with('message', $message );
        }
        else{
            if($this->edit_to_db( Input::get("id") )){
				Helper_File::delete_old_tmp_file();
                return Redirect::to( $edit_url )->with('message',  "Berhasil merubah database");
            }
            else{
                return Redirect::to( $edit_url )->with('message',  admin::get_error_message() );
            }
        }
        
    }	
    public function getDelete($id){
        $obj = admin::get_helper()->get_create_model()->find($id);
        if($obj){
			
			$datas = admin::get_helper()->get_values( $obj );
			$current_id = $datas ['desa_name'];
			$datas ['alamat_desa'] = $this->get_alamat_combo( $current_id );
			$datas ['helper']	=	admin::get_helper();
			$datas ['id']		=	$id;
            return View::make('sarung.admin.user.delete' , $datas );
        }
        else{
            return Redirect::to( root::get_url_admin_user() );
        }
    }

    public function postDelete(){
        $url  = root::get_url_admin_user('delete/'.Input::get("id"));
        if($this->delete_to_db( Input::get('id') )){
			Helper_File::delete_old_tmp_file();
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  "Gagal Menghapus database");
        }
    }
	/**
	 **/
    private function delete_to_db($id){
		$del_object  = admin::get_helper()->get_create_model()->find($id) ;
		$file_url    = $del_object->foto;
		$save_object = admin::get_saveid_obj( $this->helper->get_table_name() , $id ) ;
		$status = admin::multi_purpose_db( self::get_db_name() , array($save_object) , array($del_object) );
		if( $status ){
			$this->have_deleted_file( $file_url , 'Kosong');
		}
		return $status;
    }

	/**
	*/
	private function have_deleted_file( $old , $new ){
		$deleted_file = Helper_File::convert_url_to_path( $old );
		if ( ! file_exists( $deleted_file )){
			return false;
		}
		elseif( $old != $new   ){
			return ! (Helper_File::delete( $deleted_file ) );
		}
		return false;
	}
	/**
	*/
    private function edit_to_db($id){
		$old_url_file = User_Model::find($id)->foto;
		$save_object =  admin::get_helper()->get_the_obj( 'edit' , $id );
		//! we have to delete old file if user has given new photo path
		
		$pdo = DB::connection( self::get_db_name())->getPdo();
		$pdo->beginTransaction();
		$status = false;
		try {
			if( $this->have_deleted_file($old_url_file , $save_object->foto ) ){
				throw new Exception("Delete file didnt success");
			}
			$save_object ->save();
			$pdo->commit();
			$status = true;
		    // all good
		}
		catch (\Exception $e) {
			$this->set_error_message($e->getMessage()) ;
			$pdo->rollback();
		}
		return $status;
    }
	/*
	*/
    private function insert_to_db(){
        $id 			= 	admin::get_id( admin::get_helper() ->get_table_name() , $this->helper->get_max_id() );		
		$save_objects = array( admin::get_helper() ->get_the_obj( 'add' , $id ));
		$del_objects  = array(SaveId::nameNid( $this->helper->get_table_name() , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}