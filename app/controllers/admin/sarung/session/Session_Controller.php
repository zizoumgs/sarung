<?php
class Session_Controller extends Controller{
    public function __contruct(){            }
	
    public function getIndex(){
        $data = array();
        $data ["sessions"] = Session_Model::orderBy('updated_at' , 'DESC')->paginate(15);
        $data ['wheres']  = array();
        return View::make( "sarung.admin.session.index" , $data);
    }    
    public function getAdd(){
		$datas = array();
		$datas ['models'] = Session_Helper::get_up_model();
        return View::make( "sarung.admin.session.add" , $datas);
    }
    public function postAdd(){
        $validator = Session_Helper::get_validator();        
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
            return View::make('sarung.admin.session.edit' , Session_Helper::get_values($obj , $id ) );
        }
        else{
            return Redirect::to( root::get_url_admin_session() );
        }
    }

    public function postEdit(){
        $edit_url  = root::get_url_admin_session('edit/'.Input::get("id"));
        $validator = Session_Helper::get_validator();  
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
            return View::make('sarung.admin.session.delete' , Session_Helper::get_values($obj , $id ) );
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
            return Redirect::to( $url )->with('message',  "Gagal Menghapus database");
        }
    }
	
    private function delete_to_db($id){
        $session = Session_Helper::get_the_session_obj( false , $id );
		$session_addon 	= 	Session_Helper::get_the_addon_session_obj("delete" , $id );
        $save_id 		= 	admin::get_saveid_obj( Session_Helper::table_name , $id ) ; 

		$pdo = DB::connection( Config::get('database.default') )->getPdo();
		$pdo->beginTransaction();
		$status = false;
		try {
			$session_addon->delete();
			//! for saving
			$session->delete();
			if($save_id)
				$save_id->save();
			$pdo->commit();
			$status = true;
		    // all good
		}
		catch (\Exception $e) {
			//$this->set_pdo_exception($e);
			//$this->set_error_message($e->getMessage()) ;
		    //DB::rollback();
			$pdo->rollback();
		}
		return $status;
    }
	
    private function edit_to_db($id){
        $session 		= 	Session_Helper::get_the_session_obj( false , $id );
		$session_addon 	= 	Session_Helper::get_the_addon_session_obj("edit" , $id )		;
		$status = DB::transaction(function()use ( $session,$session_addon ){
            $session->save();
			$session_addon->save();
			return true;
		});
		return $status;
    }
	
    private function insert_to_db(){

        $id 			= 	admin::get_id( Session_Helper::table_name , Session_Helper::get_max_id() );
        $session 		= 	Session_Helper::get_the_session_obj( true , $id );
		$session_addon 	= 	Session_Helper::get_the_addon_session_obj("add" , $id );
        $save_id 		= 	admin::get_the_saveid_obj( Session_Helper::table_name , $id ) ; 
		return DB::transaction(function()use ($session,$session_addon , $save_id ){
            $session->save();
            if($save_id)
                $save_id->delete();
			if($session_addon)
				$session_addon->save();
			return true;
		});
    }
    
}