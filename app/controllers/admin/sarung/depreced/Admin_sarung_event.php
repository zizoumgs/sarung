<?php
/**
 *  This is event , and this is not kalender
 *  Sub class from this class if you want to semi automatic crud
 *  Depreced
 **/
class Admin_sarung_event extends Admin_sarung{
    private $input;
    public function __construct(){
        parent::__construct();
    }
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
     *  return  html input only
    **/
    protected function get_text_cud_group( $label , $value , $name , $disabled){
        $input =  sprintf('
            <input  name="%3$s" class=" %3$s form-control " type="text" placeholder="%1$s" Value="%2$s" %4$s >' ,
            $label , $value , $name , $disabled);
        return $this->get_input_cud_group($label , $input );
    }
    /**
     *  return  html div
    **/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        return $this->get_form_cud_event( $go_where , $values , $disabled , $method);
    }
    /**
     *  return  html form which will be used for add, edit and delete
    **/    
	protected function get_form_filter_default( $go_where , $method , $additional){
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' =>'form-inline form-filter')) ;
		$hasil .= $additional ;
		$button = '<div class="form-group">';
		$button .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$button .= '</div>';
		//$hasil .= '<button type="submit" class="btn btn-success submit-filter" >Filter</button>';
		$hasil .= $button;
		$hasil .= Form::close();
		return $hasil;
	}
    /**
     *  return  html form which will be used to filter table view
    **/
   	protected function get_form_filter( $go_where  , $method = 'get', $with_session = true ){
        $additional = $hasil = "";
		$tmp = Form::text( $this->get_name_for_text()  , '', array( 'class' => 'form-control input-sm' , 'placeholder' => 'Name' , 'Value' =>  $this->get_name_for_text_selected() ));
		$additional .= $this->get_form_group( $tmp ,'IdSantri');
		$hasil =  $this->get_form_filter_default( $go_where , $method , $additional);        
		$hasil = sprintf('%1$s',$hasil );
		//$hasil = sprintf('<div class="thumbnai">%1$s</div>' , $hasil);
		return $hasil;
	}
    /**
     *  return  html text on top of ...
    **/
    protected function set_text_on_top($value){ $this->values ['text_on_top'] = $value; }
    /**
     *  return  none
    **/    
    protected function get_text_on_top(){ return $this->values ['text_on_top']; }
    protected function set_name_for_text($val) { $this->values ['find_name'] = $val; }
    protected function get_name_for_text(){ return $this->values['find_name'];}
    protected function get_name_for_text_selected(){ return Input::get($this->get_name_for_text() ); }
    /**
     *  return  input name of kalender
    **/    
    protected function set_kalender_name($val){ $this->input ['kalender'] = $val ; }
    protected function get_kalender_name(){return $this->input ['kalender'] ; }
    protected function get_kalander_name_selected() { return Input::get( $this->get_kalender_name()); }
    /**
     *  return  input name of short name of kalender
    **/    
    protected function set_kalender_name_sho($val){ $this->input ['kalender_short'] = $val ; }
    protected function get_kalender_name_sho(){return $this->input ['kalender_short'] ; }
    protected function get_kalander_name_sho_selected() { return Input::get( $this->get_kalender_name()); }
    /**
      *  called by @get_form_cud
      *  return  none
    **/
    protected final function get_form_cud_event($go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array( $this->get_kalender_name() => '' , $this->get_kalender_name_sho() => '' );
        $array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Kalender'    , $array [ $this->get_kalender_name()]       , $this->get_kalender_name()       , $disabled) ;
        $hasil .= $this->get_text_cud_group( 'Short Name'  , $array [ $this->get_kalender_name_sho()]   , $this->get_kalender_name_sho()   , $disabled) ;
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;        
    }
    /**
      *  return  @getIndex()
    **/
    public function getIndex(){        return $this->getEvent();    }
    /**
      *  called by getIndex()
      *  return  @index()
    **/
    public function getEvent(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );
        $this->set_text_on_top('Event Table  '.$href);
        $row = "";
        $form = $this->get_form_filter( $this->get_url_this_view() );
        $events = new Event_Model();
        $wheres = array();
        if( $find_name != ""){
            $wheres [] = array( $this->get_name_for_text() => $find_name );
            $events = $events->where('nama' , 'LIKE' , "%".$find_name."%");
        }
        $events = $events->orderBy('updated_at' , 'DESC')->paginate(15);
        foreach($events as $event){
            $row .= "<tr>";
                $row .= sprintf('<td>%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $event->id ));
                $row .= sprintf('<td>%1$s</td>' , $event->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->inisial);
                $row .= sprintf('<td>%1$s</td>' , $event->updated_at);
                $row .= sprintf('<td>%1$s</td>' , $event->created_at);
            $row .= "</tr>";
        }
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			%2$s
            <div class="table_div">
    			<table class="table table-striped table-hover" >
    				<tr class ="header">
    					<th>Id</th>
                        <th>Edit/Delete</th>
    					<th>Name</th>
    					<th>Short_Name</th>
    					<th>Updated_at</th>
    					<th>Created_at</th>
    				</tr>
    				%3$s				
    			</table>
            </div>%4$s',
			 	$this->get_text_on_top() ,
   				$form               ,
                $row                ,
			 	$this->get_pagination_link($events , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();
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
      *   first html if you want to delete from database
      *  return  index() or blank if non positif
    **/
    public function getEventdel($id , $message = ""){
        if($id >= 0){
            $heading    = 'Will Delete id ' . $id;
            $this->set_id($id);
            $model = $this->get_model_obj()->find( $this->get_id() );
            $array = $this->set_values_to_inputs($model);
            $body  = $this->get_form_cud( $this->get_url_this_dele() , $array  , "disabled");
            $this->set_content( $this->get_panel($heading , $body , $message ) );
            return $this->index();
        }
        else{
            echo "You tried to put non positif id ";
        }
    }    
    /**
      *  after you click submit from delete from , you will go to here in order to delete from database
      *  sequence : @$this->delete_db_admin_root()
      *  return  index() if success and getEventdel() if fail
    **/
    public function postEventdel(){
		$id = Input::get('id');
        if($id >= 0 ){
            $event = $this->get_model_obj()->find($id);
            $messages   = array("Gagal menghapus");
            $message    =   sprintf('<span class="label label-danger">%1$s</span>' ,
                            $this->make_message( $messages ));
            $bool = false;
   			$saveId  = $this->delete_db_admin_root( $this->get_table_name() , $id );
    		DB::transaction(function()use ( $event , $saveId, &$bool  ,$id){
                $saveId->save();
    			$bool = true;
    			$event->delete();
    		});            
			if($bool){
				$messages = array(" Sukses Menghapus");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
			}
            else{
                return $this->getEventdel($id , $message);    
            }
            return $this->getIndex();            
        }
        else{
            echo "You tried to put non positif id ";
        }
    }

    /**
      *   first html if you want to edit from database
      *  return  index() or blank if non positif
    **/
    public function getEventedit($id , $message = ""){
        if($id >= 0){
            $heading    = 'Will edit id ' . $id;
            $this->set_id($id);
            $model = $this->get_model_obj()->find( $this->get_id() );
            $array = $this->set_values_to_inputs($model);
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
		$data = Input::all() ;
        $id = Input::get('id');
		$rules = $this->get_rules(true);
       	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventedit( $id , $message );
		}
        else{
            $event = $this->Sarung_db_about( $data , true  );
			$messages = array("Gagal Mengedit ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ; 
			DB::transaction(function()use ($event , &$bool , $id){
				$event->save();
				$bool = true;				
			});
			if($bool){
				$messages = array(" Sukses Mengedit");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
			}
			return $this->getEventedit($id , $message);
        }
    }

    /**
      *   first html if you want to add
      *   sequence: @get_form_cud , 
      *  return  index()
    **/
    public function getEventadd($messages = ""){
        $heading    = 'Add';
        $body       = $this->get_form_cud( $this->get_url_this_add());        
        $this->set_content( $this->get_panel($heading , $body , $messages ) );
        return $this->index();
    }

    /**
      *   after you click submit from add form , you will go to here in order to add into database
      *   sequence : @get_rules() , @get_max_id() , @Sarung_db_about()
      *  return  getEventAdd()
    **/
    public function postEventadd(){
		//$data = Input::only( $this->get_kalender_name() , $this->get_kalender_name_sho() );
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
			$messages = array("Gagal Memasukkan ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ;
            $saveId = $this->del_item_from_save_id( $this->get_table_name() , $id );
			DB::transaction(function()use ($event , $saveId , &$bool , $id){
				$event->save();
                if($saveId)
           			$saveId->delete();		
				$bool = true;				
			});
			if($bool){
				$messages = array(" Sukses Menambah");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
			}
			return $this->getEventadd($message);            
        }
    }

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
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Kalender');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('kalender');
        $this->set_kalender_name('kalender_name');
        $this->set_kalender_name_sho('kalender_sho');
        $this->set_table_name('event');
        
        //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/event/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/event/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/event/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/event");
        //!
        $this->set_model_obj(new Event_Model() );
        //! input rules
   		$rules = array( $this->get_kalender_name() => 'required' , $this->get_kalender_name_sho() => 'required');
        $this->set_inputs_rules($rules);
    }
    /**
     *  return array 
     *  useful for edit and delele view
    */
    protected function set_values_to_inputs($model){
            return array($this->get_kalender_name() =>  $model->nama  , $this->get_kalender_name_sho() => $model->inisial );        
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
     * you should override  this .
     * will be called just before insert , edit
    **/
    protected function Sarung_db_about($data , $edit = false){
        // $event = new Event_Model();
        $event = $this->get_model_obj();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
        }
       	$event->nama       = $data [ $this->get_kalender_name() ]		;
   		$event->inisial    = $data [ $this->get_kalender_name_sho() ]	;
        return $event;        
    }
     /**
     *  return max id for particular table
    **/
    protected function get_max_id(){
        //return Session_Model::max('id');
        $session = $this->get_model_obj();
        return $session->max('id');
    }
}