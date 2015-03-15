<?php
class Kalender_Controller extends AdminRoot_Controller{
	public $helper ;
    public function __construct(){
		parent::__construct(1);
		$this->helper = new Kalender_Helper;
	}
    public function getIndex(){
        $data = array();
        $data ['wheres']  =  $this->helper->get_table_filter();
        $data ["sessions"] = $this->helper->get_obj_find()->orderBy('updated_at' , 'DESC')->paginate(15);
		$data ["info"]     = $this->helper->get_table_info( $data ["sessions"] ); 
        return View::make( "sarung.admin.kalender.index" , $data);
    }	
    public function getAdd(){
		$datas = array();
		$datas ['helper'] = $this->helper;
        return View::make( "sarung.admin.kalender.add" , $datas);
    }
    public function postAdd(){
        $validator = $this->helper->get_validator();        
        if ( $validator->fails() ){            
            $message = implode ( "<br>",$validator->messages()->all() ) ;
            return Redirect::to( root::get_url_admin_kalender('add') )
				->with('message',    $message );
        }
        else{
            if($this->insert_to_db()){
                return Redirect::to( root::get_url_admin_kalender('add') )
					->with('message',  "Berhasil memasukkan ke database");
            }
            else{
                return Redirect::to( root::get_url_admin_kalender('add') )
					->with('message',  "Gagal memasukkan ke database");
            }
        }
        
    }
    public function getEdit($id){
        $obj = Kalender_Model::find($id);
        if($obj){
			$datas = $this->helper->get_values($obj , $id );
			$datas ['helper'] = $this->helper;
            return View::make('sarung.admin.kalender.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_kalender() );
        }
    }

    public function postEdit(){
        $edit_url  = root::get_url_admin_kalender('edit/'.Input::get("id"));
        $validator = $this->helper->get_validator();  
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
        $obj = Kalender_Model::find($id);
        if($obj){
			$datas = $this->helper->get_values($obj , $id );
			$datas ['helper'] = $this->helper;
            return View::make('sarung.admin.kalender.delete' , $datas );
        }
        else{
            return Redirect::to( root::get_url_admin_kalender() );
        }
    }

    public function postDelete(){
        $url  = root::get_url_admin_kalender('delete/'.Input::get("id"));
        if($this->delete_to_db( Input::get('id') )){
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  "Gagal Menghapus database");
        }
    }
	
    private function delete_to_db($id){
        $session 		= 	$this->helper->get_the_obj( false , $id );
        $save_id 		= 	admin::get_saveid_obj( $this->helper->get_table_name() , $id ) ; 
		$pdo = DB::connection( Config::get('database.default') )->getPdo();
		$pdo->beginTransaction();
		$status = false;
		try {
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
        $kalender 		= 	$this->helper->get_the_obj( false , $id );
		$status = DB::transaction(function()use ( $kalender ){
            $kalender->save();
			return true;
		});
		return $status;
    }
	
    private function insert_to_db(){

        $id 			= 	admin::get_id( $this->helper->table_name , $this->helper->get_max_id() );
        $the_obj 		= 	$this->helper->get_the_obj( true , $id );
        $save_id 		= 	SaveId::nameNid( $this->helper->table_name , $id ) ; 
		return DB::transaction(function()use ( $the_obj , $save_id ){
            $the_obj->save();
            if($save_id)
                $save_id->delete();
			return true;
		});
    }
    
}