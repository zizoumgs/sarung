<?php
class Admin_sarung_event extends Admin_sarung{
    private $input;
    public function __construct(){
        parent::__construct();
    }
    
	private function get_form_group($input , $name_label){
		return sprintf('<div class="form-group ">
        					   %1$s
					   </div>' , $input , $name_label);
	}
    /*For all input_group , but you should use input as a parameter*/
    protected function get_input_cud_group( $label , $input ){
        return sprintf('
        <div class="form-group form-group-sm">
            <label class="col-sm-2 control-label" >%1$s</label>
            <div class="col-sm-3">
                %2$s
            </div>
        </div>' , $label , $input);
    }
    protected function get_text_cud_group( $label , $value , $name , $disabled){
        $input =  sprintf('
            <input  name="%3$s" class=" %3$s form-control " type="text" placeholder="%1$s" Value="%2$s" %4$s >' ,
            $label , $value , $name , $disabled);
        return $this->get_input_cud_group($label , $input );
    }
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
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
   	protected function get_form_filter( $go_where  , $method = 'get', $with_session = true ){
        $additional = $hasil = "";
		$tmp = Form::text( $this->get_name_for_text()  , '', array( 'class' => 'form-control input-sm' , 'placeholder' => 'Name' , 'Value' =>  $this->get_name_for_text_selected() ));
		$additional .= $this->get_form_group( $tmp ,'IdSantri');
		$hasil =  $this->get_form_filter_default( $go_where , $method , $additional);        
		$hasil = sprintf('%1$s',$hasil );
		//$hasil = sprintf('<div class="thumbnai">%1$s</div>' , $hasil);
		return $hasil;
	}

    protected function set_text_on_top($value){ $this->values ['text_on_top'] = $value; }
    protected function get_text_on_top(){ return $this->values ['text_on_top']; }
    protected function set_name_for_text($val) { $this->values ['find_name'] = $val; }
    protected function get_name_for_text(){ return $this->values['find_name'];}
    protected function get_name_for_text_selected(){ return Input::get($this->get_name_for_text() ); }
    protected function set_kalender_name($val){ $this->input ['kalender'] = $val ; }
    protected function get_kalender_name(){return $this->input ['kalender'] ; }
    protected function get_kalander_name_selected() { return Input::get( $this->get_kalender_name()); }
    protected function set_kalender_name_sho($val){ $this->input ['kalender_short'] = $val ; }
    protected function get_kalender_name_sho(){return $this->input ['kalender_short'] ; }
    protected function get_kalander_name_sho_selected() { return Input::get( $this->get_kalender_name()); }
    /*You should call this on contructor ,and you should make this*/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Kalender');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('kalender');
        $this->set_kalender_name('kalender_name');
        $this->set_kalender_name_sho('kalender_sho');
        $this->set_table_name('event');
    }
    /*
    protected function get_edit_delete_row($additional = ""){
        $edi = sprintf('<a href="%1$s/%2$s" class="btn btn-primary btn-xs" >Edit</a>'    , $this->get_url_admin_sarung()."/eventedit" , $additional );
        $del = sprintf('<a href="%1$s/%2$s" class="btn btn-info btn-xs">Delete</a>'      , $this->get_url_admin_sarung()."/eventdel" , $additional );
        return $edi."  ".$del;
    }
    */
    public function getIndex(){        return $this->getEvent();    }
    public function getEvent(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );
        $this->set_text_on_top('Kalender Table  '.$href);
        $row = "";
        $form = $this->get_form_filter( $this->get_url_this_view() );
        $events = new Event_Model();
        if( $find_name != ""){
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
                //$events->appends( array() )->links()
			 	$this->get_pagination_link($events) 
			);
        $this->set_content($hasil);
        return $this->index();
    }
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/event" ;}
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/event/eventadd" ;}
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/event/eventedit" ;}
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/event/eventdel" ;}
    protected function get_panel( $heading , $body , $footer=""){
        return sprintf('
            <div class="panel panel-primary">
                <div class="panel-heading">%1$s</div>
                <div class="panel-body">%2$s</div>
                <div class="panel-footer">%3$s</div>
            </div>', $heading , $body , $footer);
    }
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
    public function postEventedit(){
		$data = Input::only( 'id' ,$this->get_kalender_name() , $this->get_kalender_name_sho() );
		$rules = array( $this->get_kalender_name() => 'required' , $this->get_kalender_name_sho() => 'required');
    	$validator = Validator::make($data, $rules);
        $id                 = $data ['id'] ;
		$kalender_name 	    = $data [ $this->get_kalender_name() ];
		$kalender_name_sho  = $data [ $this->get_kalender_name_sho() ];
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventedit( $message );
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
    public function getEventadd($messages = ""){
        $heading    = 'Add';
        $body       = $this->get_form_cud( $this->get_url_this_add());        
        $this->set_content( $this->get_panel($heading , $body , $messages ) );
        return $this->index();
    }
    public function postEventadd(){
		$data = Input::only( $this->get_kalender_name() , $this->get_kalender_name_sho() );
		$rules = array( $this->get_kalender_name() => 'required' , $this->get_kalender_name_sho() => 'required');
    	$validator = Validator::make($data, $rules);
		$kalender_name 	    = $data [ $this->get_kalender_name() ];
		$kalender_name_sho  = $data [ $this->get_kalender_name_sho() ];
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventadd( $message );
		}
        else{
            $id = $this->get_id_from_save_id ( $this->get_table_name() ,$this->get_max_id() );
            $data ['id'] = $id ;
            $event = $this->Sarung_db_about($data  );
			$messages = array("Gagal Memasukkan ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ;
            $saveId = $this->del_item_from_save_id( $this->get_table_name() , $id );
			DB::transaction(function()use ($event , $saveId , &$bool , $id){
				$event->save();
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
    protected function set_values_to_inputs($model){
            return array($this->get_kalender_name() =>  $model->nama  , $this->get_kalender_name_sho() => $model->inisial );        
    }
    //! this will get table of database
    protected function get_model_obj(){
        return new Event_Model();
    }
    /* this will be called just before insert , edit */
    private function Sarung_db_about($data , $edit = false){
        $event = new Event_Model();
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
    
    private function get_max_id(){ return Event_Model::max('id');}
}