<?php
class Admin_sarung_kalender extends Admin_sarung_pelajaran{
    private $input;
    public function __construct(){
        parent::__construct();
    }

    /*You should call this on contructor ,and you should make this
		Configuraation for input and filter
		return none
		Usually for setting name input and filter
	*/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('Session');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('kalender');
        $this->set_table_name('kalender');
        
        $this->set_perkiraan_santri_name( 'perkiraan_santri' );
		$this->set_session_name ( 'session_name');
        $this->set_rating_name  ( 'rating_name' );
        $this->set_money_name   ( 'money_name'  );
        $this->set_event_name   ( 'event_name'  );
        $this->set_akhir_name   ( 'akhir_name'  );
		$this->set_awal_name	( 'awal_name'   );
		$this->set_aktif_name   ( 'aktif_name'	);
		
		//! filter
		$this->set_id_filter_name('id_filter');
		//! editor
		$this->set_editor_name('ckeditor');
	}
	/**
	 *	return array which is default for input html
	*/
	protected function get_default_value_input(){
        $array = array(
                       $this->get_session_name () => '' ,
                       $this->get_event_name    () => '' ,
					   $this->get_money_name    () => '' ,
                       $this->get_rating_name() => '2' ,
                       $this->get_awal_name()   =>  '' ,
                       $this->get_akhir_name()  =>  '' , 
					   $this->get_aktif_name()	=>	''
                       );
		return $array;
	}
	/*All value for filter */
	protected function set_id_filter_name($val) 	{ $this->input['id_filter'] = $val; }
	protected function get_id_filter_name() 		{ return $this->input['id_filter'] ; }
	protected function get_id_filter_selected ()	{ return Input::get( $this->get_id_filter_name() ); }
	/**
	 *Will get form filter
	 *return input file html
	*/
   	protected function get_form_filter( $go_where  , $method = 'get', $with_session = true ){
		$this->use_select();
        $additional = $hasil = "";
		$tmp = Form::text( $this->get_id_filter_name()  , '', array( 'class' => 'form-control input-sm' , 'placeholder' => 'Id' , 'Value' =>  $this->get_id_filter_selected() ));
		$additional .= $this->get_form_group( $tmp ,'Id Kalender');
		$tmp = $this->get_session_select( $this->get_session_selected() );
		$additional .= $this->get_form_group( $tmp  , '');
		$tmp = $this->get_event_select( $this->get_event_selected() ) ;
		$additional .= $this->get_form_group( $tmp  , '');
		$hasil =  $this->get_form_filter_default( $go_where , $method , $additional);        
		$hasil = sprintf('%1$s',$hasil );
		return $hasil;
	}
	/*
	 *	return html which containts all information about add .
	*/
	private function get_information(){
		return sprintf('
			<p>Table ini memerlukan pengisian table session dan event , jadi bila and tidak menemukan session atau event yang anda
			inginkan anda harus menambahkannya terlebih dahulu!</p><hr>
			<p>Jika kamu menginginkan menambahkan event silahkan click link berikut 		</p><a href="%1$s" class="btn btn-xs btn-primary pull-right">Even</a><br><hr>
			<p>Jika kamu menginginkan menambahkan session silahkan click link berikut 	</p><a href="%2$s" class="btn btn-xs btn-info pull-right">Session</a>
		',$this->get_url_admin_event() , $this->get_url_admin_session());
	}	
	/*
		return form-group class which will be containter for input html
	*/
    protected function get_input_cud_group_kalender( $label , $input ){
        return sprintf('
        <div class="form-group form-group-sm">
            <label class="col-sm-2 control-label" >%1$s</label>
            <div class="col-sm-8">
                %2$s
            </div>
        </div>' , $label , $input);
    }
	/**
	 *	return form-group class which will be containter for input html , you also get input from this function
	*/
    protected function get_text_cud_group_kalender( $label , $value , $name , $disabled){
        $input =  sprintf('
            <input  name="%3$s" class=" %3$s form-control " type="text" placeholder="%1$s" Value="%2$s" %4$s >' ,
            $label , $value , $name , $disabled);
        return $this->get_input_cud_group_kalender($label , $input );
    }
	
	/* all value for input*/
    protected function set_rating_name($val)   {  $this->input ['rating_name'] = $val; }
    protected function get_rating_name()       {  return $this->input ['rating_name'] ; }
    protected function get_rating_selected ()  {  return Input::get( $this->get_rating_name() ) ;}

    protected function set_money_name($val)   {  $this->input ['money_name'] = $val; }
    protected function get_money_name()       {  return $this->input ['money_name'] ; }
    protected function get_money_selected ()  {  return Input::get( $this->get_money_name() ) ;}
	
    protected function set_event_name($val)   {  $this->input ['event_name'] = $val; }
    protected function get_event_name()       {  return $this->input ['event_name'] ; }
    protected function get_event_selected ()  {  return Input::get( $this->get_event_name() ) ;}

    protected function set_aktif_name($val)   {  $this->input ['aktif_name'] = $val; }
    protected function get_aktif_name()       {  return $this->input ['aktif_name'] ; }
    protected function get_aktif_selected ()  {  return Input::get( $this->get_aktif_name() ) ;}
	
    protected function set_editor_name($val)   {  $this->input ['editor_name'] = $val; }
    protected function get_editor_name()       {  return $this->input ['editor_name'] ; }
    protected function get_editor_selected ()  {  return Input::get( $this->get_editor_name() ) ;}
	
	/**
	 *	return select html for session
	 */
	protected function get_session_select($selected){
		$session = new Session_Model();
		$sessions = $session->orderBy('nama' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_session_name() , 'selected' => $selected);		
		return $this->get_select($items , $default);
	}
	/**
	 *	return select html for event 
	*/
	protected function get_event_select($selected){
		$session = new Event_Model();
		$sessions = $session->orderBy('nama' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_event_name() , 'selected' => $selected);		
		return $this->get_select($items , $default);
	}
	/**
	 *	return input html
	*/
	protected function get_input( $parameters , $disabled){
		$input = "<input ";
		foreach($parameters as $key => $val ):
			$input .= sprintf('%1$s="%2$s"',$key , $val) ; 
		endforeach;
		$input .= sprintf(' %1$s >' , $disabled);
		return $input;
	}
	
	/**
	 *	return checkbox html along with form group class
	*/
	protected function get_check_box($label , $attrs = array() , $value=0 , $offset = 2 ){
		$attrs_result = "";
		foreach ($attrs as $key => $val ):
			$attrs_result .= sprintf('%1$s = "%2$s"' , $key , $val );
		endforeach;
		$checked = "";
		if($value == 1) {$checked = "checked";}
		$finish = 12 - $offset;
		return sprintf ('
			<div class="form-group">
				<div class="col-sm-offset-%1$s col-sm-%2$s ">
					<div class="checkbox">
						<label>
							<input type="checkbox" %4$s Value="1" %5$s> %3$s
						</label>
					</div>
				</div>
			</div>' , $offset , $finish , $label  , $attrs_result , $checked);
	
	}
	/**
	 *	return form html for add , edit and delete
	*/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
		$this->use_select();

        $array = $this->make_one_two_array( $this->get_default_value_input() , $values);
		$this->set_input_date( ".".$this->get_akhir_name() , true);
		$this->set_input_date( ".".$this->get_awal_name()  , false);
		$rating = $this->get_input(array('type' => 'number' ,
										 'class' => sprintf('%1$s form-control',$this->get_rating_name()) ,
										 'min' => 1 , 'max' => 10 , 
										 'name' => $this->get_rating_name() , 'Value' => $array [$this->get_rating_name()]
										 ) , $disabled) ;
		$money = $this->get_input(array('type' => 'number' ,
										 'class' => sprintf('%1$s form-control',$this->get_money_name()) ,
										 'min' => 0 , 'max' => 1000000000 , 'step' => 1000 , 
										 'name' => $this->get_money_name() , 'Value' => $array [$this->get_money_name()]
										 ) , $disabled) ;
		$aktif = Form::checkbox('name', 'value', true);
        //$array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
		$hasil .= $this->get_input_cud_group_kalender( 'Session'    , $this->get_session_select( $array[$this->get_session_name() ] ) ) ;
        $hasil .= $this->get_input_cud_group_kalender ( 'Event'      , $this->get_event_select ( $array[$this->get_event_name  () ] ) ) ;
        $hasil .= $this->get_input_cud_group_kalender( 'Rating'     , $rating) ;
		$hasil .= $this->get_input_cud_group_kalender( 'Money'      , $money ) ;
		$hasil .= $this->get_check_box('Aktif' , array('name' => $this->get_aktif_name() ) , $array[$this->get_aktif_name() ] ) ;
        $hasil .= $this->get_text_cud_group_kalender( 'Awal'        , $array [ $this->get_awal_name()]     , $this->get_awal_name()      , $disabled) ;
        $hasil .= $this->get_text_cud_group_kalender( 'Akhir'  , $array [ $this->get_akhir_name()]     , $this->get_akhir_name()      , $disabled) ;
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }	
	/**
	 *	return add , edit and create  html link inside table view
	*/
    protected final function get_edit_delete_row_kalender($additional = ""){
		$create = sprintf('<a href="%1$s/%2$s" class="btn btn-success btn-xs">Notice</a>'      , $this->get_url_this_notice(), $additional );
        return parent::get_edit_delete_row($additional). " " . $create;
    }
	/**
	 *	return @index()
	*/
	public function getNote($id , $messages = ""){
		$text_content = "";
		$tmp = Kalender_Note_Model::where('id_kalender' , '=' , $id)->first();
		if($tmp){
			$text_content = $tmp->note;
		}
		$this->use_ckEditor(".".$this->get_editor_name());
		
		$content ="";
		if($messages != ""){
			$content .= sprintf('<label class="label label-danger">%1$s</label>' , $messages);
		}
		$content .= Form::open(array('url' => $this->get_url_this_notice(), 'method' => 'post' , 'role' => 'form')) ;
		$content .= sprintf('
					<h1 class="title"><span class="glyphicon glyphicon-thumbs-up"></span> Please use as wise as possible</h1>
					<hr />
		            <textarea class="form-control ckeditor" rows="10" name="%1$s">%2$s</textarea><br>
					<button type="submit" class="btn btn-sm btn-primary">Submit</button><br>
						   ' , $this->get_editor_name() , $text_content);
		$content .= Form::hidden('id', $id );
		$content .= Form::close();
		$this->set_content($content);
		return $this->index();
	}
	/**
	 *	will go here when form in editor has clicked
	 *	return @getNote()
	*/
	public function postNote(){
		$content = htmlentities( $this->get_editor_selected() );
		$id = Input::get('id');
		if( ! is_numeric($id) ){
			echo "Haruslah numeric";
			return ;
		}
		$kalender_note = $this->get_kalender_note_obj($id);
		$kalender_note->id_kalender = $id ;
		$kalender_note->note	 	= $content;
		DB::transaction(function()use ( $kalender_note){
			$kalender_note->save();
		});
		return $this->getNote($id , 'Berhaasil merubah');
		//! we dont have delete feature for this database
		
	}
	/**
	 * return Kalender_note obj
	*/
	protected function get_kalender_note_obj($id_kalender){
		$obj = new Kalender_Note_Model();
		$result = $obj->where( 'id_kalender' ,'=',$id_kalender)->first();
				
		$kalender_note = New Kalender_Note_Model(); 
		//! add
		if($result){
			$kalender_note = $result->find( $result->id);
		}
		else{
			$id = Kalender_Note_Model::max('id');
			$id++;
			$kalender_note->id  = $id;
		}
		return $kalender_note;
	}
	/**
	 *	Default view for admin kalender class
	 *	return @index()
	*/
    public function getIndex(){
        $find_session 	= $this->get_session_selected();
		$find_event   	= $this->get_event_selected();
		$id				= $this->get_id_filter_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Kalender Table  '.$href);
        $row = "";
        $form = $this->get_form_filter( $this->get_url_this_view() );
        $kalender = $this->get_model_obj();
		$wheres = array() ;
        if( $find_session != "" && $find_session != "All"){
			$wheres []  = array( $this->get_session_name() =>  $find_session );
			$session    = new Session_Model();
			$session    = $session->where('nama' , 'LIKE' , "%".$find_session."%" )->firstOrFail();
			$kalender   = $kalender->where('idsession' , '=' , $session->id);
        }
        if( $find_event != "" && $find_event != "All"){
			$wheres   = array( $this->get_event_name() =>  $find_event );
			$session  = new Event_Model();
			$session  = $session->where('nama' , 'LIKE' , "%".$find_event."%" )->firstOrFail();
			$kalender = $kalender->where('idevent' , '=' , $session->id);
        }
		if( $id != ""){
			$kalender = $kalender->where('id' , '=' , $id);			
		}
		$kalenders = $kalender->orderBy('updated_at','DESC')->paginate(15);
        //$kalenders = $kalender->orderBy('updated_at','DESC')->paginate(15);
        foreach( $kalenders as $kalender){
            $event = $kalender;
            $row .= "<tr>";
				$diff_updated = $this->get_datediff(0 , $event->updated_at);
				$diff_created = $this->get_datediff(0 , $event->created_at);
									
                $row .= sprintf('<td>%1$s</td>' 			, $this->get_edit_delete_row_kalender( $event->id ));
                $row .= sprintf('<td>%1$s</td>' 			, $event->id);
                $row .= sprintf('<td>%1$s</td>' 			, $event->session->nama);
                $row .= sprintf('<td>%1$s</td>' 			, $event->event->nama);
                $row .= sprintf('<td>%1$s</td>' 			, $event->awal);
                $row .= sprintf('<td>%1$s</td>' 			, $event->akhir);
                $row .= sprintf('<td>%1$s</td>' 			, $event->aktif);
                $row .= sprintf('<td>%1$s</td>' 			, $event->money);
                $row .= sprintf('<td>%1$s <small>Days ago</small></td>' 			, $diff_updated);
                $row .= sprintf('<td>%1$s <small>Days ago</small></td>' 	, $diff_created);
            $row .= "</tr>";
        }
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			%2$s
            <div class="table_div">
    			<table class="table table-striped table-hover" >
    				<tr class ="header">
                        <th>Edit/Delete</th>
    					<th>Id</th>
    					<th>Session</th>
						<th>Event</th>
    					<th>Awal</th>
                        <th>Akhir</th>
                        <th>aktif</th>
                        <th>Money</th>
    					<th>Updated_at</th>
    					<th>Created_at</th>
    				</tr>
    				%3$s				
    			</table>
            </div>%4$s',
			 	$this->get_text_on_top() ,
   				$form               ,
                $row                ,
			 	$this->get_pagination_link($kalenders , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();        
    }
	/**
	 *	Must override because we should delelte kalender_note table manually
	 *	return getIndex();
	*/
    public function postEventdel(){
		$id = Input::get('id');
        if($id >= 0 ){
            $event = $this->get_model_obj()->find($id);
            $messages   = array("Gagal menghapus");
            $message    =   sprintf('<span class="label label-danger">%1$s</span>' ,
                            $this->make_message( $messages ));
            $bool = false;
   			$saveId  = $this->delete_db_admin_root( $this->get_table_name() , $id );
			//! delete kalender_note
			$kalender_note = $this->get_kalender_note_obj($id);
    		DB::transaction(function()use ( $event , $saveId , $kalender_note , &$bool ){
                $saveId->save();
				$kalender_note->delete();
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
	 *	YOu need this in add ,edit and delete
	 *	Panel in twitter bootstrap
	 *	return class panel html
	*/
    protected function get_panel( $heading , $body , $footer=""){
		if($footer != "") {
			$footer = sprintf('<div class="panel-footer">%1$s</div>' , $footer);
		}
        return sprintf('
            <div class="panel panel-primary ">
                <div class="panel-heading">%1$s</div>
                <div class="panel-body">
						%2$s
				</div>
                %3$s
            </div>', $heading , $body , $footer);
    }

	/**
	 *	Default view for add form
	 *	return @index()
	*/
    public function getEventadd($messages = ""){
        $heading    = 'Add Kalender';
        $body       = $this->get_form_cud( $this->get_url_this_add()) ;
		$content    = sprintf('<div class="col-md-8"> %1$s </div> ',$this->get_panel($heading , $body , $messages )) ;
		$content   .= sprintf('<div class="col-md-4"> %1$s </div> ',$this->get_panel("Information" , $this->get_information() )) ;
        $this->set_content( $content);
        return $this->index();
    }
	/**
	 *	Rules for input form
	 *	return array which contains rules
	*/
    protected function get_rules($with_id = false){
        $array = array(
            $this->get_money_name ()  => 'required|numeric' ,
            $this->get_rating_name   ()  => 'required|numeric' ,
            $this->get_awal_name()      => 'required' ,
            $this->get_akhir_name()     => 'required'
        ); 
        if($with_id)
            $array ['id'] = "required|numeric" ; 
        return $array;
    }
	/**
	 *	this will be called just before insert , edit
	 *	return object sql which will be save into database , after class this you just do obj->save()
	 *	
	 */
    protected function Sarung_db_about($data , $edit = false){
        $event = $this->get_model_obj();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
        }
		$session 		= Session_Model::where('nama', '=' , $this->get_session_selected() )->first();
		$event_model   	= Event_Model::where('nama', '=', $this->get_event_selected()  )->first();
		$aktif = 0 ;
		if($this->get_aktif_selected() == "1"){ $aktif = "1" ;}
		
       	$event->idsession       = $session->id		;
   		$event->idevent         = $event_model->id	;
		$event->aktif			= $aktif           	;
		$event->rating			= $data [ $this->get_rating_name()   ]           ;
		$event->money			= $data [ $this->get_money_name ()   ]           ;
        $event->awal            = $data [ $this->get_awal_name  ()   ]           ;
        $event->akhir           = $data [ $this->get_akhir_name ()   ]           ;
        return $event;
    }
	/**
	 *	Set values for input
	 *	return array
	*/
    protected function set_values_to_inputs($model){
            return array(
						 $this->get_session_name() 	=>	$model->session->nama  ,
						 $this->get_event_name()	=> 	$model->event->nama ,
						 $this->get_awal_name()		=>	$model->awal ,
						 $this->get_akhir_name()	=>	$model->akhir ,
						 $this->get_aktif_name()	=>	$model->aktif ,
						 $this->get_money_name()	=>	$model->money 
						 );        
    }
	/**
	 *	get maximum id for id of certain model
	 *	return max id
	*/
    protected function get_max_id(){ return Kalender_Model::max('id');}	
    /*
	  this will get table of database
	*/
    protected function get_model_obj(){        return new Kalender_Model();    }
	/**
	 *	return url string for view
	*/
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/kalender" ;}
	/**
	 *	return url string for add 
	*/
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/kalender/eventadd" ;}
	/**
	 *	return url string for edit
	*/
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/kalender/eventedit" ;}
	/**
	 *	return url string for delete
	*/
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/kalender/eventdel" ;}
	/**
	 *	return url string for creating view
	*/
	protected function get_url_this_notice(){ return $this->get_url_admin_sarung()."/kalender/note" ; }

}
