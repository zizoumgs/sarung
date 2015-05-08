<?php
/**
 *	this class will support larangan
 *	this class has developed base on Admin_sarung_suppor class 
*/
abstract class Admin_sarung_delete extends Admin_sarung_support_root implements Admin_sarung_crud{
    public function __construct(){        parent::__construct();    }
    /**
      *  after you click submit from delete from , you will go to here in order to delete from database
      *  return  will_dele_to_db if success and blank() if fail
    **/
    public function postEventdel(){
		$this->set_default_values_for_deleting();
		$id = Input::get('id');
        if($id >= 0 ){
			$data = Input::all();
			return $this->will_dele_to_db($data);
        }
        else{
            echo "You tried to put non positif id ";
        }
    }    
	/**
	 *	semi final to delete data
	 * 	return html
	*/
	protected function will_dele_to_db($data){
        if ( array_key_exists('id', $data)) {
    		$id 		= 	$data ["id"] ;
        }
        else{
            $id = Input::get('id');
            $data ['id'] = $id;
        }
		//!
		$event 		= 	$this->Sarung_db_about_dele($data);
		$this->add_obj_dele_db($event);
		$saveId  	= 	$this->delete_db_admin_root( $this->get_table_name() , $id );
		if($saveId){
			$this->add_obj_save_db($saveId);
		}
		//!
		if( $this->will_change_to_db()){
			return $this->postEventdelsucceded();
		}
        else{
			return $this->postEventdelfailed();
        }
	}
	/**
	 *	function to get column which will dele db
	 *	return @ Sarung_db_about
	**/
	protected function Sarung_db_about_dele($data , $values = array() ){
		return $this->get_model_obj()->find( $data ['id'] );
	}	
	/**
	 *	failed to delete item
	 *	return $this->getEventdel;
	**/
	protected function postEventdelfailed($values = array()){
		$id = $this->get_value('id') ;		
	    $messages   = array("Gagal menghapus");
        $message    =   sprintf('<span class="label label-danger">%1$s</span>' , $this->make_message( $messages ));
        return $this->getEventdel($id , $message);    		
	}
	/**
	 *	 onsucceded delete
	 *	 return @ index 
	*/
	protected function postEventdelsucceded($parameter = array()){
		$messages = array(" Sukses Menghapus ");
		$message = sprintf('<span class="label label-info">%1$s</span>' , $this->make_message( $messages ));
        return $this->getIndex();
	}
	/**
	 *	default value for delete
	*/
	protected function set_default_values_for_deleting(){
		$this->set_purpose( self::DELE);
	}
}
/**
*/
abstract class Admin_sarung_edit extends Admin_sarung_delete{
    public function __construct(){
        parent::__construct();
    }
    /**
      *  after you click submit from edit form , you will go to here in order to edit from database
      *  sequence : @get_rules() , @Sarung_db_about()
      *  return  getEventedit()
    **/
    public function postEventedit(){
		$this->set_purpose(self::EDIT);
		$data = Input::all() ;
        $id = Input::get('id');
		$rules = $this->get_edit_rules();
       	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			$this->set_error_message($message);
			return $this->getEventedit( $id , array() , array($message) );
		}
        else{
			return $this->will_edit_to_db($data);
        }
    }
    /**
     *  rules for edit
     *  @override
    **/
    protected function get_edit_rules(){ return $this->get_rules(true);}
	/**
	 **	function to get column which will edit db
	 **	return @ Sarung_db_about
	**/	
	protected function Sarung_db_about_edit($data , $values = array() ){
		return $this->Sarung_db_about( $data  , self::EDIT , $values );
	}
	/**
	 ** return html
	**/
	protected function will_edit_to_db($data){
		$event = $this->Sarung_db_about_edit($data);
		$id = $data ["id"] ;
		//! add db obj to save in further step
		$this->add_obj_save_db($event);
		if($this->will_change_to_db()){
			return $this->postEventeditsucceded( array('id' => $id) );
		}
		else{
			$messages = array("Gagal Memasukkan <br><br>");
			$message = sprintf('<span class="label label-danger">%1$s</span>%2$s' ,  $this->make_message( $messages ),$this->get_error_message());
			return $this->getEventedit($id ,array(),array( $message ) );
		}
	}
	/**
	 *	 onsucceded edit
	 *	 return @ getEventedit 
	*/
	protected function postEventeditsucceded($parameter = array()){
		$messages = array(" Sukses Mengedit");
		$message = sprintf('<span class="label label-info">%1$s</span>' , $this->make_message( $messages ));
		return $this->getEventedit( $parameter ['id'], array() , array($message));
	}
}
/**
***/
abstract class Admin_sarung_add extends Admin_sarung_edit{
    public function __construct(){
        parent::__construct();
    }
    /**
      *   first html if you want to add
      *   sequence: @get_form_cud , 
      *  return  index()
	 **/
    public function getEventadd($messages = array("")){
		$this->set_purpose( self::ADDI);
        $all = Input::all();
        $heading    = 'Add';
        $body       = $this->get_form_cud( $this->get_url_this_add() , $all  );
        $this->set_content( $this->get_panel($heading , $body , $messages [0] ) );
        return $this->index();
    }
    /**
     **  After_Submit , We overrid because we have select which will change according to other result
     **  return getEventAdd or will_insert_to_db
    ***/
	public function postEventadd(){
		$this->set_purpose( self::ADDI);
		$data = Input::all();
   		$rules = $this->get_rules();
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventAdd( array($message)) ;
		}
        else{
			return $this->will_insert_to_db($data);
        }
	}
	/**
	 **	function to get column which will insert into db
	 **	return @ Sarung_db_about
	**/	
	protected function Sarung_db_about_add($data , $edit = false , $values = array() ){
		return $this->Sarung_db_about( $data  , $edit , $values );
	}
	/**
	 *	before insert to db
	 *	return postEventaddsucceded if succeded , getEventadd otherwise
	**/
	protected function will_insert_to_db($data , $values = array()){
            $id = $this->get_id_from_save_id ( $this->get_table_name() ,$this->get_max_id() );
            $data ['id'] = $id ;
			//! all main db
            $event = $this->Sarung_db_about_add($data, false ,  $values );
            $saveId = $this->del_item_from_save_id( $this->get_table_name() , $id );
			//! add db obj to save in further step
			$this->add_obj_save_db($event);
			if($saveId){
				$this->add_obj_dele_db( $saveId);
			}    
			//! save to db
			if( $this->will_change_to_db() ){
				return $this->postEventaddsucceded();
			}
			else{
				$messages = array("Gagal Memasukkan <br><br>");
				$message = sprintf('<span class="label label-danger">%1$s</span>%2$s' ,  $this->make_message( $messages ),$this->get_error_message());
				return $this->getEventadd( array($message));
			}
	}
	/**
	 *	 onsucceded add
	 *	 @params array()	it is unused
	 *	 return @ getEventadd 
	*/
	protected function postEventaddsucceded( $parameter = array()){
		// @param  string  $path
		$messages = array(" Sukses Menambah");
		$message = sprintf('<span class="label label-info">%1$s</span>' ,$this->make_message( $messages ));
		return $this->getEventadd( array( $message) );
	}

}
/**
*/
abstract class Admin_sarung_larangan_root extends Admin_sarung_add{
	/**
	 *	$param 
	 **/
    public function __construct(){
        parent::__construct();
		$this->set_error_message('');
		$this->set_database_name( Config::get('database.default') );		
    }
	/*
		This list of object will be executed during transaction
	*/
	private $objs_save_db = array();
	private $objs_dele_db = array();
	//! parameter is obj
	public function add_obj_save_db($obj){
		$tmp = $obj ; 
		if( ! is_object($obj))
			$tmp = null ;
		$this->objs_save_db [] = $tmp ;
	}
    //@
	public function add_obj_dele_db($obj){
		$tmp = $obj ; 
		if( ! is_object($obj))
			$tmp = null ;
		$this->objs_dele_db [] = $tmp ;
	}
	protected function get_obj_save_db(){ return $this->objs_save_db ; }
	protected function get_obj_dele_db(){ return $this->objs_dele_db ; }
    //@ invers obj
	protected function set_invers_obj_save(){		$this->objs_save_db = array_reverse( $this->objs_save_db );	}
    //@ invers obj
	protected function set_invers_obj_dele(){		$this->objs_dele_db = array_reverse( $this->objs_dele_db );	}
    //@
	protected function set_pdo_exception($val) {$this->input['pdo_exception'] = $val;}
	protected function get_pdo_exception() { return $this->input['pdo_exception'] ;}
    //@	
	protected function set_error_message($val) {$this->input['error_message'] = $val;}
	protected function get_error_message() { return $this->input['error_message'] ;}
	/**
	 *	default
	 **/
    public function getIndex( ){
		$this->set_purpose(self::VIEW);
		return parent::getIndex();
	}
	/**
	 **/	
    protected function set_default_value(){
		parent::set_default_value();
	}
	/**
	 **/
    protected function set_values_to_inputs($model = 'empty'){}
	/**
	 **	default function to interact with db , include add, edit , and delete
	 **	return none , you can override then 
	***/		
    protected function Sarung_db_about($data , $edit = false , $values = array()){		return "";	}
	/**
	 *	last chance before change db
	 *	return bool:	true if succeded , false otherwise
	*/
	protected function will_change_to_db(){
		$pdo = DB::connection( $this->get_database_name() )->getPdo();
		$pdo->beginTransaction();
		//DB::beginTransaction();
		$status = false;
		try {
			//! for saving
			foreach( $this->get_obj_save_db() as $obj){
				if($obj == null) {
					throw new Exception("There are non object");
				}
				$obj->save();
			}
			foreach( $this->get_obj_dele_db() as $obj){
				if($obj == null) {
					throw new Exception("There are non object");
				}
				$obj->delete();
			}		    
		    //DB::commit();
			$pdo->commit();
			$status = true;
		    // all good
		}
		catch (\Exception $e) {
			$this->set_pdo_exception($e);
			$this->set_error_message($e->getMessage()) ;
		    //DB::rollback();
			$pdo->rollback();
		}
		return $status;
	}
	/**
	*/
	public function getEventEdit($id , $values = array()  , $messages = array("")){}	
    public function getEventdel($id , $values = array() , $messages= array("")){}
}



