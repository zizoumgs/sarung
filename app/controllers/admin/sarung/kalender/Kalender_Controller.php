<?php
class Kalender_Controller extends Admin{
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
		$del_objects  [] = $this->helper->get_the_obj( false , $id ) ;
		$save_objects [] = admin::get_saveid_obj( $this->helper->get_table_name() , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
    private function edit_to_db($id){
		$save_objects = array($this->helper->get_the_obj( false , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , array()  );
    }
	
    private function insert_to_db(){
        $id 			= 	admin::get_id( $this->helper->get_table_name() , $this->helper->get_max_id() );		
		$save_objects = array($this->helper->get_the_obj( true , $id ));
		$del_objects  = array(SaveId::nameNid( $this->helper->get_table_name() , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}