<?php
class Ujian_Controller extends Admin{
    public function __construct(){
		parent::__construct(1);
		admin::init_helper( new Ujian_Helper );
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	
    public function getIndex(){
        $data = array();
        $data ['wheres']  =  admin::get_helper()->get_values_for_pagenation();
        $data ["items"] = admin::get_helper()->get_obj_find()->orderBy('updated_at' , 'DESC')->paginate(15);
		$data ["info"]     = admin::get_helper()->get_table_info( $data ["items"] ); 
        return View::make( "sarung.admin.ujian.index" , $data);
    }	
    public function getAdd(){
		$datas = array();
		$datas ['helper'] = admin::get_helper();
        return View::make( "sarung.admin.ujian.add" , $datas);
    }
    public function postAdd(){
        $validator = admin::get_helper()->get_validator();        
        if ( $validator->fails() ){            
            $message = implode ( "<br>",$validator->messages()->all() ) ;
            return Redirect::to( root::get_url_admin_ujian('add') )
				->with('message',    $message );
        }
        else{
            if($this->insert_to_db()){
                return Redirect::to( root::get_url_admin_ujian('add') )
					->with('message',  "Berhasil memasukkan ke database");
            }
            else{
                return Redirect::to( root::get_url_admin_ujian('add') )
					->with('message',  "Gagal memasukkan ke database");
            }
        }
        
    }
    public function getEdit($id){
        $obj = admin::get_helper()->get_create_model()->find($id);
        if($obj){
			$datas = admin::get_helper()->get_values($obj , $id );
			$datas ['helper'] = admin::get_helper();
            return View::make('sarung.admin.ujian.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_ujian() );
        }
    }

    public function postEdit(){
        $edit_url  = root::get_url_admin_ujian('edit/'.Input::get("id"));
        $validator = admin::get_helper()->get_validator();  
        if ( $validator->fails() ){ 
            $message = implode ( $validator->messages()->all() ) ;
            return Redirect::to( $edit_url )->with('message', $message );
        }
        else{
            if($this->edit_to_db( Input::get("id") )){
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
			$datas = admin::get_helper()->get_values($obj , $id );
			$datas ['helper'] = admin::get_helper();
            return View::make('sarung.admin.ujian.delete' , $datas );
        }
        else{
            return Redirect::to( root::get_url_admin_ujian() );
        }
    }

    public function postDelete(){
        $url  = root::get_url_admin_ujian('delete/'.Input::get("id"));
        if($this->delete_to_db( Input::get('id') )){
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  "Gagal Menghapus database");
        }
    }
	
    private function delete_to_db($id){
		$del_objects  [] = admin::get_helper()->get_the_obj( false , $id ) ;
		$save_objects [] = admin::get_saveid_obj( admin::get_helper()->get_table_name() , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
    private function edit_to_db($id){
		$save_objects = array(admin::get_helper()->get_the_obj( false , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , array()  );
    }
	
    private function insert_to_db(){
        $id 			= 	admin::get_id( admin::get_helper()->get_table_name() , admin::get_helper()->get_max_id() );		
		$save_objects = array(admin::get_helper()->get_the_obj( true , $id ));
		$del_objects  = array(SaveId::nameNid( admin::get_helper()->get_table_name() , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}