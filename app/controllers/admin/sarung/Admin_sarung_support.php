<?php
/**
 * use this class for creating class which is similiar with this 
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
abstract class Admin_sarung_support_sup extends Admin_sarung{
    protected $input;
     /**
     *  return max id for particular table
    **/
    protected function get_max_id(){
        $session = $this->get_model_obj();
        return $session->max('id');
    }
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

    /*
    *   set object of database
    *   this will get table of database
    */
    protected function set_model_obj($val){ $this->input ['model_obj'] = $val ;}
    /*
    *   return object
    *   this will get table of database
    */
    protected function get_model_obj(){        return $this->input ['model_obj'] ;    }
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
	 *	setting purpose
	 *	@param val : integer
	 *	0 : view ,  1: add , 2 : edit , 3: delete
	*/
	protected function set_purpose($val){ $this->input ['purpose'] = $val ;}
	protected function get_purpose(){return $this->input ['purpose'] ;}
}
/**
 *  Advanced Admin_sarung_event class
 *  Below is main class of this file
*/
abstract class Admin_sarung_support extends Admin_sarung_support_sup implements Admin_sarung_crud{
    public function __construct(){
        parent::__construct();
    }    
    public function getIndex(){
		$this->set_purpose(1);
	}
    protected function set_default_value(){}
    protected function Sarung_db_about($data , $edit = false , $values = array()){}
    protected function set_values_to_inputs($model = 'empty'){}
    /**
      *  after you click submit from delete from , you will go to here in order to delete from database
      *  sequence : @$this->delete_db_admin_root()
      *  return  index() if success and getEventdel() if fail
    **/
    public function postEventdel(){
		$this->set_purpose( self::DELE);
		$id = Input::get('id');
        if($id >= 0 ){
            $event = $this->get_model_obj()->find($id);
            $bool = false;
   			$saveId  = $this->delete_db_admin_root( $this->get_table_name() , $id );
    		DB::transaction(function()use ( $event , $saveId, &$bool  ,$id){
                $event->delete();
                $saveId->save();
    			$bool = true;    			
    		});            
			if($bool){
				return $this->postEventdelsucceded();
			}
            else{
	            $messages   = array("Gagal menghapus");
	            $message    =   sprintf('<span class="label label-danger">%1$s</span>' , $this->make_message( $messages ));
                return $this->getEventdel($id , $message);    
            }
        }
        else{
            echo "You tried to put non positif id ";
        }
    }    
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
            $event = $this->Sarung_db_about( $data , true  );
			$bool = false ; 
			DB::transaction(function()use ($event , &$bool , $id){
				$event->save();
				$bool = true;				
			});
			if($bool){
				return $this->postEventeditsucceded( array('id' => $id) );
			}
			else{
				$messages = array("Gagal Mengedit ");
				$message = sprintf('<span class="label label-danger">%1$s</span>' , $this->make_message( $messages ));
				return $this->getEventedit($id ,array(), $message);
			}
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
     *  return on_changing_select or postEventadd
    */
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
            $id = $this->get_id_from_save_id ( $this->get_table_name() ,$this->get_max_id() );
            $data ['id'] = $id ;
            $event = $this->Sarung_db_about( $data  );
			$bool = false ;
            $saveId = $this->del_item_from_save_id( $this->get_table_name() , $id );
			DB::transaction(function()use ($event , $saveId , &$bool , $id){
				$event->save();
                if($saveId)
           			$saveId->delete();		
				$bool = true;				
			});
			if($bool){
				return $this->postEventaddsucceded();
			}
			else{
				$messages = array("Gagal Memasukkan ");
				$message = sprintf('<span class="label label-danger">%1$s</span>' ,  $this->make_message( $messages ));
				return $this->getEventadd($message);
			}

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
