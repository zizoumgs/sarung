<?php
class Ujian_Controller extends AdminRoot_Controller{
	public $helper ;
    public function __construct(){
		parent::__construct(1);
		$this->helper = new Ujian_Helper;
	}
    public function getIndex(){
        $data = array();
        $data ['wheres']  =  $this->helper->get_table_filter();
        $data ["items"] = $this->helper->get_obj_find()->orderBy('updated_at' , 'DESC')->paginate(15);
		$data ["info"]     = $this->helper->get_table_info( $data ["items"] ); 
        return View::make( "sarung.admin.ujian.index" , $data);
    }	
    public function getAdd(){
		$datas = array();
		$datas ['helper'] = $this->helper;
        return View::make( "sarung.admin.ujian.add" , $datas);
    }
    public function postAdd(){
        $validator = $this->helper->get_validator();        
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
        $obj = $this->helper->get_create_model()->find($id);
        if($obj){
			$datas = $this->helper->get_values($obj , $id );
			$datas ['helper'] = $this->helper;
            return View::make('sarung.admin.ujian.edit' , $datas  );
        }
        else{
            return Redirect::to( root::get_url_admin_ujian() );
        }
    }

    public function postEdit(){
        $edit_url  = root::get_url_admin_ujian('edit/'.Input::get("id"));
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
        $obj = $this->helper->get_create_model()->find($id);
        if($obj){
			$datas = $this->helper->get_values($obj , $id );
			$datas ['helper'] = $this->helper;
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
        $model 		= 	$this->helper->get_the_obj( false , $id );
		return DB::transaction(function()use ( $model ){
            $model->save();
			return true;
		});
    }
	
    private function insert_to_db(){

        $id 			= 	admin::get_id( $this->helper->get_table_name() , $this->helper->get_max_id() );
        $the_obj 		= 	$this->helper->get_the_obj( true , $id );
        $save_id 		= 	SaveId::nameNid( $this->helper->get_table_name() , $id ) ;
		return DB::transaction(function()use ( $the_obj , $save_id ){
            $the_obj->save();
            if($save_id)
                $save_id->delete();
			return true;
		});
    }
    
}