<?php
/**
 *	this class will support to things , user and santri , class
 *	this class has develope base on event class 
*/
interface Admin_sarung_crud {
	const VIEW = 0;
	const ADDI = 1;
	const ADD  = 1;
	const EDIT = 2;
	const DELE = 3;
	/*this function for form to delete */
	public function getEventDel($id , $message);
	/*this function for deleting something into database*/
	public function postEventDel();
	/*this function for form to edit */
	public function getEventedit($id , $values = array() , $message = "");
	/*this function for editing something into database*/
	public function postEventedit();
	/*this function for form to add */
	public function getEventadd($messages = "");
	/*this function for adding something into database*/
	public function postEventadd();
	/*this function for view*/
    public function getIndex();
}
/**
 *	i separated class` in order to learn easily
*/
abstract class Admin_sarung_support_root extends Admin_sarung{
    protected $input;
	const BANNED 	= 	-1	;
	const NEWS		=	0	;
	const NON_ANTIF	=	1	;
	const AKTIF		=	2	;
	/**
	 *	setting purpose
	 *	@param val : integer
	 *	0 : view ,  1: add , 2 : edit , 3: delete
	*/
	protected function set_purpose($val){ $this->input ['purpose'] = $val ;}
	protected function get_purpose(){return $this->input ['purpose'] ;}
    /**
     *  folder of foto santri
    */
    protected function set_foto_folder($val){ $this->input ['folder_foto_'] = $val ; }
    protected function get_foto_folder(){ return $this->input ['folder_foto_'] ;}
	/**
	 *	return array
	 *	will be called in add , edit function 
	*/
    protected function get_rules($with_id = false){
        $rules = $this->get_inputs_rules();
        if($with_id)
            $rules ['id'] = "required|numeric" ; 
        return $rules;
    }
    /**
      *  set url for table
    **/
    protected function set_url_this_view($val){  $this->input ['table_url'] = $val  ; }
    /**
      *  return  url table which will be used for navigating
    **/
    protected function get_url_this_view(){ return $this->input ['table_url'] ;}
    /**
     *  set url for adding
    */
    protected function set_url_this_add($val){ $this->input ['add_url'] = $val  ; }
    /**
      *  return  url add which will be used for navigating
    **/
    protected function get_url_this_add(){ return $this->input ['add_url'] ;}
    /**
     *  set url for editing
    */
    protected function set_url_this_edit($val){ $this->input ['edit_url'] = $val  ; }
    /**
      *  return  url edit which will be used for navigating
    **/
    protected function get_url_this_edit(){ return $this->input ['edit_url']  ;}
    /**
     *  set url for deleting
    */
    protected function set_url_this_dele($val){ $this->input ['delete_url'] = $val  ; }
    /**
      *  return  url which will be used for delete
    **/
    protected function get_url_this_dele(){ return $this->input ['delete_url'] ;}
    /**
      *  will be used by get_rules()
      *  input = array
    **/
    protected function set_inputs_rules($val){ $this->input ['inputs_rules'] = $val;}
    /**
      *  will be used by get_rules()
      *  return  array
    **/
    protected function get_inputs_rules(){return $this->input['inputs_rules'];}
    //
    protected function set_session_select_name($val){ $this->input ['session_select'] = $val ; }
    protected function get_session_select_name(){ return $this->input ['session_select'] ;}
	/**
	 *	This will be needed during sql transaction
	**/
	protected function set_database_name($val){ $this->input ['db_nam_sar_sup'] = $val ;}
	protected function get_database_name(){return $this->input ['db_nam_sar_sup'];}
    /**
     *  get kelas
     *  return select
    **/
	protected function get_select_kelas( $attributes , $additional_item = array()){
        $default = array( "class" => "selectpicker",
                         "name" => '',
                         'id'   => '' , 
                         'selected' => '',
						 );
		//! transfer to default array
		$default = $this->array_combine($default , $attributes);
        $hasil = array();
        $sessions = Kelas_Model::orderby('nama' , 'ASC')->get();
        foreach($sessions as $item){
            $hasil [] = $item->nama ;
        }		
		//@ additioanl item
        foreach($additional_item as $item){            $hasil [] = $item ;        }		
        return $this->get_select( $hasil , $default);		
	}
	protected function get_kelas_select( $attributes , $additional_item = array( )){
		return $this->get_select_kelas( $attributes , $additional_item);
	}
    /**
     *  get pelajaran
     *  return select
    **/
	protected function get_pelajaran_select( $attributes ,   $additional_item = array()){
        $default = array( "class" => "selectpicker",
                         "name" => '',
                         'id'   => '' , 
                         'selected' => '',
						 );
		//! transfer to default array
		$default = $this->array_combine($default , $attributes);
        $hasil = array();
		//@ additioanl item
        foreach($additional_item as $item){            $hasil [] = $item ;        }
		//@ 
        $sessions = new Ujian_Model();
        foreach($sessions->get_names_of_pelajaran() as $item){
            $hasil [] = $item->name ;
        }
        return $this->get_select( $hasil , $default);		
	}
    /**
     *  get event
     *  return select
    **/
	protected function get_event_ujian_select( $attributes , $additional_item = array() ){
        $default = array( "class" => "selectpicker",
                         "name" => '',
                         'id'   => '' , 
                         'selected' => '',
						 );
		//! transfer to default array
		$default = $this->array_combine($default , $attributes);
        $hasil = array();
		//@ additioanl item
        foreach($additional_item as $item){
            $hasil [] = $item ;
        }
		//@
        $sessions = new Ujian_Model();
        foreach($sessions->get_names_of_ujian() as $item){
            $hasil [] = $item->name ;
        }

        return $this->get_select( $hasil , $default);		
	}	
    /**
     *  get session
     *  return select
    */
    protected function get_session_select( $attributes = array() , $additional_item = array()){
        $default = array( "class" => "selectpicker",
                         "name" => $this->get_session_select_name() ,
                         'id'   => $this->get_session_select_name() , 
                         'selected' => '',
						 );
		//! transfer to default array
		foreach( $attributes as $key => $val){
			$default [$key] = $val ;
		}			
        $hasil = array();
		//@ additioanl item
        foreach($additional_item as $item){
            $hasil [] = $item ;
        }
		//@
        $sessions = Session_Model::orderby('nama' , 'DESC')->get();
        foreach($sessions as $item){
            $hasil [] = $item->nama ;
        }
		
        return $this->get_select( $hasil , $default);
    }
    /**
     *  check whether give asking for foto or just give default foto
     *  return string file
    */
    protected function get_foto_file($model){
        $file = sprintf('%1$s/%2$s/%3$s',$this->get_foto_folder() , $model->id_user, $model->foto);
		return $this->get_and_check_file($file);
    }
	/*
		Check and get file
	*/
    protected function get_and_check_file($file){
		$path = helper_get_path_from_abs_url($file);
        if( ! File::exists($path) ){
			$file = sprintf('%1$s/unknow-48.png' , $this->get_foto_folder());
        }
        return $file;
    }	
}
/**
 *  Advanced Admin_sarung_event class
 *  Below is main class of this file
*/
abstract class Admin_sarung_support extends Admin_sarung_support_root implements Admin_sarung_crud{
	/*
		This list of object will be executed during transaction
	*/
	private $objs_save_db = array();
	private $objs_dele_db = array();
	//! parameter is obj
	protected function add_obj_save_db($obj){
		$tmp = $obj ; 
		if( ! is_object($obj))
			$tmp = null ;
		$this->objs_save_db [] = $tmp ;
	}
	protected function add_obj_dele_db($obj){
		$tmp = $obj ; 
		if( ! is_object($obj))
			$tmp = null ;
		$this->objs_dele_db [] = $tmp ;
	}
	protected function get_obj_save_db(){ return $this->objs_save_db ; }
	protected function get_obj_dele_db(){ return $this->objs_dele_db ; }
	protected function set_invers_obj_save(){
		$this->objs_save_db = array_reverse( $this->objs_save_db );
	}
	protected function set_invers_obj_dele(){
		$this->objs_dele_db = array_reverse( $this->objs_dele_db );
	}
	

	protected function set_pdo_exception($val) {$this->input['pdo_exception'] = $val;}
	protected function get_pdo_exception() { return $this->input['pdo_exception'] ;}
	
	protected function set_error_message($val) {$this->input['error_message'] = $val;}
	protected function get_error_message() { return $this->input['error_message'] ;}
	/**
	 *	$param 
	 **/
    public function __construct(){
        parent::__construct();
		$this->set_error_message('');
		$this->set_database_name( Config::get('database.default') );		
    }
	/**
	 *	
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
      *  after you click submit from delete from , you will go to here in order to delete from database
      *  return  will_dele_to_db if success and blank() if fail
    **/
    public function postEventdel(){
		$this->set_purpose( self::DELE);
		$id = Input::get('id');
        if($id > 0 ){
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
		//!
		$id 		= 	$data ["id"] ;
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
	 *
	 **/
    public function getEventdel($id , $message = ""){
		$this->set_purpose( self::DELE);
        if($id >= 0){
            $heading    = 'Will Delete id ' . $id;
            $this->set_id($id);
            $model = $this->get_model_obj()->find( $this->get_id() );
            $array = $this->set_values_to_inputs($model);
            $array ['id'] =   $id;
            $body  = $this->get_form_cud( $this->get_url_this_dele() , $array  , "disabled");
            $this->set_content( $this->get_panel($heading , $body , $message ) );
            return $this->index();
        }
        else{
            echo "You tried to put non positif id ";
        }
    }
    
    /**
     *  @override
     *  first html if you want to edit from database
     *  return  index() or blank if non positif
    **/
    public function getEventedit($id , $values = array() , $message = ""){
		$this->set_purpose( self::EDIT);
        if($id >= 0){
            $heading    = 'Will edit id ' . $id;
            $this->set_id($id);
            $array = $model = $values;
            
            if( empty ($model) ){
                $model = $this->get_model_obj()->find( $this->get_id() );
                $array = $this->set_values_to_inputs($model);                                
            }
            $array ['id'] =   $id;
            $body  = $this->get_form_cud( $this->get_url_this_edit() , $array );
            $this->set_content( $this->get_panel($heading , $body , $message ) );
            return $this->index();            
        }
        else{
            echo "Your Id is Not positif";
        }
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
		$rules = $this->get_rules(true);
       	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			$this->set_error_message($message);
			return $this->getEventedit( $id , $data , $message);
		}
        else{
			return $this->will_edit_to_db($data);
        }
    }
    /**
      *   first html if you want to add
      *   sequence: @get_form_cud , 
      *  return  index()
	 **/
    public function getEventadd($messages = ""){
		$this->set_purpose( self::ADDI);
        $all = Input::all();
        $heading    = 'Add';
        $body       = $this->get_form_cud( $this->get_url_this_add() , $all  );
        $this->set_content( $this->get_panel($heading , $body , $messages ) );
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
			return $this->getEventAdd($message);
		}
        else{
			return $this->will_insert_to_db($data);
        }
	}
	/**
	 **	default function to interact with db , include add, edit , and delete
	 **	return none , you can override then 
	***/		
    protected function Sarung_db_about($data , $edit = false , $values = array()){		return "";	}
	/**
	 **	function to get column which will insert into db
	 **	return @ Sarung_db_about
	**/	
	protected function Sarung_db_about_add($data , $edit = false , $values = array() ){
		return $this->Sarung_db_about( $data  , $edit , $values );
	}
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
			$messages = array("Gagal Mengedit ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' , $this->make_message( $messages ));
			return $this->getEventedit($id ,array(), $message);
		}
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
				$messages = array("Gagal Memasukkan ");
				$message = sprintf('<span class="label label-danger">%1$s</span>' ,  $this->make_message( $messages ));
				return $this->getEventadd($message);
			}
	}
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
	 *	 onsucceded add
	 *	 @params array()	it is unused
	 *	 return @ getEventadd 
	*/
	protected function postEventaddsucceded( $parameter = array()){
		// @param  string  $path
		$messages = array(" Sukses Menambah");
		$message = sprintf('<span class="label label-info">%1$s</span>' ,$this->make_message( $messages ));
		return $this->getEventadd($message);            		
	}
	/**
	 *	 onsucceded edit
	 *	 return @ getEventedit 
	*/
	protected function postEventeditsucceded($parameter = array()){
		$messages = array(" Sukses Mengedit");
		$message = sprintf('<span class="label label-info">%1$s</span>' , $this->make_message( $messages ));
		return $this->getEventedit( $parameter ['id'] ,array(), $message);
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

}


