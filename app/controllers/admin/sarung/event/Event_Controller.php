<?php
class Event_Controller extends Admin{
    public function __construct(){
		parent::__construct(1);
	}
    const get_name = "name";
    const get_short_name = "short_name";
    const table_name = 'event' ; 
    
    private function get_max_id(){   return Event_Model::max('id') ;   }
    
    private function get_obj_for_save( $add , $id ){
        $event = new Event_Model ();
        if( $add )
            $event->id = $id;
        else
            $event = $event->find( $id );            
       	$event->nama       = Input::get(    self::get_name	    )	    ;
   		$event->inisial    = Input::get(    self::get_short_name	)   ;
        return $event;
    }
    
    public function get_validator(){
   		$rules  = array(    self::get_name          =>  'required'  ,
                            self::get_short_name    =>  'required'
                );
        return Validator::make(  Input::all() , $rules);
    }
	
    public function getIndex(){
        $data = array();
        $data ["events"] = Event_Model::orderBy('updated_at' , 'DESC')->paginate(15);
        $data ['wheres']  = array();
        return View::make( "sarung.admin.event.index" , $data);
    }    
    public function getAdd(){
        return View::make( "sarung.admin.event.add");
    }
    public function postAdd(){
        $validator = $this->get_validator();        
        if ( $validator->fails() ){            
            $message = implode ( $validator->messages()->all() ) ;
            return Redirect::to( root::get_url_admin_event('add') )->with('message',    $message );
        }
        else{
            if($this->insert_to_db()){
                return Redirect::to( root::get_url_admin_event('add') )->with('message',  "Berhasil memasukkan ke database");
            }
            else{
                return Redirect::to( root::get_url_admin_event('add') )->with('message',  "Gagal memasukkan ke database");
            }
        }
        
    }
    public function getEdit($id){
        $obj = Event_Model::find($id);
        if($obj){
            $datas  ['name_value']  =   $obj->nama;
            $datas  ['short_name_value']  =   $obj->inisial;
            $datas  ['id']              =   $id ;
            return View::make('sarung.admin.event.edit' ,$datas);
        }
        else{
            return Redirect::to( root::get_url_admin_event() );
        }
    }
    public function postEdit(){
        $edit_url  = root::get_url_admin_event('edit/'.Input::get("id"));
        $validator = $this->get_validator();  
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
        $obj = Event_Model::find($id);
        if($obj){
            $datas  ['name_value']  =   $obj->nama;
            $datas  ['short_name_value']  =   $obj->inisial;
            $datas  ['id']              =   $id ;
            return View::make('sarung.admin.event.delete' ,$datas);
        }
        else{
            return Redirect::to( root::get_url_admin_event() );
        }
    }
    public function postDelete(){
        if($this->delete_to_db( Input::get('id') )){
            return Redirect::to( root::get_url_admin_event() )->with('message',  "Berhasil memasukkan ke database");
        }
        else{
            return Redirect::to( root::get_url_admin_event() )->with('message',  "Gagal memasukkan ke database");
        }
    }
 
 
    private function delete_to_db($id){
        $event = $this->get_obj_for_save( false , $id );
        $save_id = admin::get_saveid_obj( self::table_name , $id ) ; 
		return DB::transaction(function()use ($event , $save_id ){
            $event->delete();
            $save_id->save();
			return true;
		});
    }
 
    private function edit_to_db($id){
        $event = $this->get_obj_for_save( false , $id );
		return DB::transaction(function()use ($event ){
            $event->save();
			return true;
		});        
    }
    private function insert_to_db(){
        $id = admin::get_id( self::table_name , self::get_max_id() );
        $event = $this->get_obj_for_save( true , $id );
        $save_id = SaveId::nameNid( self::table_name , $id ) ; 
		return DB::transaction(function()use ($event , $save_id ){
            $event->save();
            if($save_id)
                $save_id->delete();		
			return true;
		});
    }
    
}