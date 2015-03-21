<?php
class Session_Controller extends Admin {
    public function __construct(){
		parent::__construct(1);
		admin::init_helper( new Session_Helper);		
	}
	private static function get_db_name(){	return Config::get('database.default'); }

    public function getIndex(){
        $data = array();
        $data ["sessions"] = Session_Model::orderBy('updated_at' , 'DESC')->paginate(15);
        $data ['wheres']  = array();
        return View::make( "sarung.admin.session.index" , $data);
    }    
    public function getAdd(){
		$datas = array();
		$datas ['models'] = admin::get_helper()->get_up_model();
        return View::make( "sarung.admin.session.add" , $datas);
    }
    public function postAdd(){
        $validator = admin::get_helper()->get_validator();        
        if ( $validator->fails() ){            
            $message = implode ( "<br>",$validator->messages()->all() ) ;
            return Redirect::to( root::get_url_admin_session('add') )->with('message',    $message );
        }
        else{
            if($this->insert_to_db()){
                return Redirect::to( root::get_url_admin_session('add') )->with('message',  "Berhasil memasukkan ke database");
            }
            else{
                return Redirect::to( root::get_url_admin_session('add') )->with('message',  "Gagal memasukkan ke database");
            }
        }
        
    }
    public function getEdit($id){
        $obj = Session_Model::find($id);
        if($obj){
            return View::make('sarung.admin.session.edit' , admin::get_helper()->get_values($obj , $id ) );
        }
        else{
            return Redirect::to( root::get_url_admin_session() );
        }
    }

    public function postEdit(){
        $edit_url  = root::get_url_admin_session('edit/'.Input::get("id"));
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
                return Redirect::to( $edit_url )->with('message',  "Gagal merubah ke database");
            }
        }
        
    }
	

    public function getDelete($id){
        $obj = Session_Model::find($id);
        if($obj){
            return View::make('sarung.admin.session.delete' , admin::get_helper()->get_values($obj , $id ) );
        }
        else{
            return Redirect::to( root::get_url_admin_session() );
        }
    }

    public function postDelete(){
        $url  = root::get_url_admin_session('delete/'.Input::get("id"));
        if($this->delete_to_db( Input::get('id') )){
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  admin::get_error_message() );
        }
    }
	
    private function delete_to_db($id){
		$del_objects  []	= 	admin::get_helper()->get_the_addon_session_obj("delete" , $id );
		$del_objects  [] 	= 	admin::get_helper()->get_the_session_obj( false , $id ) ;
		$save_objects [] = admin::get_saveid_obj( admin::get_helper()->get_table_name() , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
    private function edit_to_db($id){
		$save_objects = array(
								admin::get_helper()->get_the_session_obj( false , $id ) ,
								admin::get_helper()->get_the_addon_session_obj("edit" , $id )
						);
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , array()  );
    }
	
    private function insert_to_db(){
		$id 			= 	admin::get_id( admin::get_helper()->table_name , admin::get_helper()->get_max_id() );
		$save_objects = array(
							  admin::get_helper()->get_the_session_obj( true , $id ) 		,
							  admin::get_helper()->get_the_addon_session_obj("add" , $id ) 	);
		$del_objects  = array(SaveId::nameNid( admin::get_helper()->table_name , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}