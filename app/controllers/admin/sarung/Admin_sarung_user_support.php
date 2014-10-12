<?php
/**
 *	this class will support to things , user and santri
*/
interface Admin_sarung_crud {
	const VIEW = 0;
	const ADDI = 1;
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
abstract class Admin_sarung_support_user extends Admin_sarung{
	const BANNED 	= 	-1	;
	const NEWS		=	0	;
	const NON_ANTIF	=	1	;
	const AKTIF		=	2	;
    protected $input;
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
    /* Below is name of select which contains status to filter*/
    protected function set_status_select_name($val){ $this->input ['status_select'] = $val ; }
    protected function get_status_select_name(){ return $this->input ['status_select'] ;}
    protected function get_status_select_selected(){ return $this->get_value( $this->get_status_select_name() ); }

    /* Below is name of filter input which will filter output by its name */
    protected function set_name_filter_name($val){ $this->input ['filter_name'] = $val ; }
    protected function get_name_filter_name(){ return $this->input ['filter_name'] ;}
    protected function get_name_filter_selected(){ return $this->get_value( $this->get_name_filter_name() ); }

	/**
	 *	return array
	 *	will be called in add , edit function 
	*/
    protected final function get_rules($with_id = false){
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
    /**
     *  return  html text on top of ...
    **/
    protected function set_text_on_top($value){ $this->values ['text_on_top'] = $value; }
    /**
     *  return  none
    **/    
    protected function get_text_on_top(){ return $this->values ['text_on_top']; }
	/**
     *  function usualy used for filtering result
     *  return only input html
    */
    protected function get_form_group($input , $name_label){
		return sprintf('<div class="form-group ">
        					   %1$s
					   </div>' , $input , $name_label);
	}
    /**
     *  return  html div which containt label and input
    **/
    protected function get_input_cud_group( $label , $input ){
        return sprintf('
        <div class="form-group form-group-sm">
            <label class="col-sm-2 control-label" >%1$s</label>
            <div class="col-sm-3">
                %2$s
            </div>
        </div>' , $label , $input);
    }
    /**
      *  return html which was used as place of add , edit , delete form
    **/
    protected function get_panel( $heading , $body , $footer=""){
        return sprintf('
            <div class="panel panel-primary">
                <div class="panel-heading">%1$s</div>
                <div class="panel-body">%2$s</div>
                <div class="panel-footer">%3$s</div>
            </div>', $heading , $body , $footer);
    }
    /**
     * this will display all user admind with respect to his admind status
     * Return string
    */
    protected function get_user_status($model){        
        $status  = sprintf('<span><span class="glyphicon glyphicon-question-sign"></span> status: %1$s</span><br>', $this->get_status($model->status) );
        $updated  = sprintf('<span><span class="glyphicon glyphicon-calendar"></span> Updated: %1$s</span><br>', $model->updated_at);
        $created  = sprintf('<span><span class="glyphicon glyphicon-time"></span> Created: %1$s</span>', $model->created_at);
        $role = '';
        $role       = sprintf('<span><span class="glyphicon glyphicon-magnet"></span> Role: %1$s</span><br>', $model->admindgroup->nama);
        $nama = sprintf('<div class="x-small-font">%1$s %2$s %3$s %4$s</div>' , $status  , $role, $updated, $created );
        return $nama;        
    }
    /**
     *  check whether give asking for foto or just give default foto
     *  return string file
    */
    protected function get_foto_file($model){
        $file = sprintf('%1$s/%2$s/%3$s',$this->get_foto_folder() , $model->id_user, $model->foto);
		return $this->check_and_get_file($file);
    }
	/*
		Check and get file
	*/
    protected function get_and_check_file($file){
		$path = helper_get_path_from_abs_url($file);
        if( ! File::exists($path) ){
			Log::info("-----------------------");
			Log::info("There are no file");
			Log::info($file);
			Log::info("-----------------------");
            return "";
        }
        return $file;
    }	
    /**
     * this will display all user information
     * Return string
    */
    protected function get_user_data($model , $col_array = array( "col-md-2" , "col-md-10 x-small-font" )){
		$file = sprintf('%1$s/%2$s/%3$s',$this->get_foto_folder() , $model->id, $model->foto);
        $foto  = sprintf('<img src="%1$s" class="small-img thumbnail">', $this->get_and_check_file($file) );
        //$foto  = sprintf('<img src="%1$s/%2$s/%3$s" class="small-img thumbnail">',$this->get_foto_folder() , $model->id, $model->foto );
        $jenis = sprintf('<span>%1$s</span>', $model->jenis);
        $email  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> Email: %1$s</span><br>', $model->email);
        $ttl    = sprintf('<span><span class="glyphicon glyphicon-info-sign"></span> TTL: %1$s %2$s</span>', $model->tempat->nama , $model->lahir);
        $alamat = sprintf('<span><span class="glyphicon glyphicon-map-marker"></span> Alamat:%1$s %2$s %3$s</span><br>' ,
                          $model->desa->kecamatan->kabupaten->nama ,
                          $model->desa->kecamatan->nama ,
                          $model->desa->nama);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span><br>' , $model->first_name , $model->second_name);
        $nama = sprintf('<div class="row">
                        <div class="%6$s">%1$s</div>
                        <div class="%7$s">%2$s %3$s %4$s %5$s</div>
                        </div>' , $foto  , $nama, $email, $alamat , $ttl  ,
						$col_array [0] , $col_array[1]);
        return $nama;
	}

  	/**
     *  will get user status , see admind`s table
     *  input : integer or Text 
     *  return string if input mode = 0 , meanwhile 1 return number
   	*/    
    protected function get_status( $signal , $mode = 0){
        /*
   		-1: banned studend 
   		0: not inserted into santri table , this for new registering student
   		1 : non_aktif -> cannot edit , just view 
   		2 : aktif 	 -> can edit
        */
        $value = array(
                       -1 => 'Banned users'     ,
                        0 => 'New Registering'  ,
                        1 => "Non Aktif"        ,
                        2 => "Aktif"
                       );
        if($mode == 0 ):
            if( isset($value [$signal]) ):
                return $value [$signal];
            endif;
        elseif($mode == 1):
            foreach($value as $key => $val){
                if( $val == $signal){
                    return $key;
                }
            }
        endif;
        return "Error";

    }	
    /**
     *  return array
    */
    protected function get_available_status( $default = 'All'){
        return array(
                    '-100'    =>  $default,
                     '-1'  =>  'Banned',
                      '0'   =>  'Registered' ,
                      '1'   =>  'Non Aktif' ,
                      '2'   =>  'Aktif'                           
                     );        
    }
    /**
     * this will filter admind which will be seen , admind with lower/same power can`t see higher power
     * Return obj
    */
    protected function set_filter_by_user($model_obj){
        return $model_obj->getlesserPowerid($this->get_user_power());
    }
    /**
     * this will filter view by name
     * Return obj
    */
    protected function set_filter_by_name($model_obj , & $wheres ){
        if( $this->get_name_filter_selected() != ""){
            $wheres [$this->get_name_filter_name()] = $this->get_name_filter_selected();
            return $model_obj->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".$this->get_name_filter_selected()."%" ,
                                              "%".$this->get_name_filter_selected()."%" )
                                        );
        }
        return $model_obj;
    }	
    /**
     * this will filter view by name
     * Return obj
    */
    protected function set_filter_by_status($model_obj , & $wheres ){
        $selected = $this->get_status_select_selected() ;
        if(  $selected != "" && $selected != -100){
            $wheres [ $this->get_status_select_name()  ] = $selected  ;
            return $model_obj->where('status' , '=' , $selected);
        }
        return $model_obj;
    }
}
/**
 *  Advanced Admin_sarung_event class
 *  Below is main class of this file
*/
abstract class Admin_sarung_support extends Admin_sarung_support_user implements Admin_sarung_crud{
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
	/**
	 **/	
    public function __construct(){
        parent::__construct();
    }
	/**
	 **/
    public function getIndex(){
		$this->set_purpose( self::VIEW);
		return parent::getIndex();
	}
	/**
	 **/	
    protected function set_default_value(){
        //! special
        $this->set_foto_folder($this->base_url()."/foto");
		$this->set_status_select_name('sta_fil');
        $this->set_name_filter_name('nam_fil');
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
            $messages   = array("Gagal menghapus");
            $message    =   sprintf('<span class="label label-danger">%1$s</span>' , $this->make_message( $messages ));
            return $this->getEventdel($id , $message);    
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
     *  After_Submit , We overrid because we have select which will change according to other result
     *  return getEventAdd or will_insert_to_db
    **/
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
	 *	default function to interact with db , include add, edit , and delete
	 *	return none , you can override then 
	**/		
    protected function Sarung_db_about($data , $edit = false , $values = array()){		return "";	}
	/**
	 *	function to get column which will insert into db
	 *	return @ Sarung_db_about
	**/	
	protected function Sarung_db_about_add($data , $edit = false , $values = array() ){
		return $this->Sarung_db_about( $data  , $edit , $values );
	}
	/**
	 *	function to get column which will edit db
	 *	return @ Sarung_db_about
	**/	
	protected function Sarung_db_about_edit($data , $values = array() ){
		return $this->Sarung_db_about( $data  , self::EDIT , $values );
	}
	/**
	 * return html
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
	protected final function will_change_to_db(){
	    DB::beginTransaction();
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
		    DB::commit();
			$status = true;
		    // all good
		} catch (\Exception $e) {
		        Log::info('-------------------------------------------------');
				Log::info($e);
		        Log::info('-------------------------------------------------');
		    DB::rollback();
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
