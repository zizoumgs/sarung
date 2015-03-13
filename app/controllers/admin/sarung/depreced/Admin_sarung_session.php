<?php
class Admin_sarung_session_support extends Admin_sarung_support{//Admin_sarung_event{
    public function __construct(){
        parent::__construct();
    }    
   
    protected function set_session_name($val)   {  $this->input ['session_name'] = $val; }
    protected function get_session_name()       {  return $this->input ['session_name'] ; }
    protected function get_session_selected ()  {  return Input::get( $this->get_session_name() ) ;}
    
    protected function set_perkiraan_santri_name($val)  { $this->input ['perkiraan_santri'] = $val ;}
    protected function get_perkiraan_santri_name()      { return $this->input ['perkiraan_santri'];}
    protected function get_perkiraan_santri_selected () { return Input::get( $this->get_perkiraan_santri_name() );}
    
    protected function set_awal_name($val)      { $this->input ['awal_name'] = $val ;}
    protected function get_awal_name()          { return $this->input['awal_name'];}
    protected function get_awal_selected ()     { return Input::get ( $this->get_awal_name()) ; }
    
    protected function set_akhir_name($val)     { $this->input ['akhir_name'] = $val ; }
    protected function get_akhir_name()         { return $this->input ['akhir_name'] ;}
    protected function get_akhir_selected ()    { return Input::get( $this->get_akhir_name() ) ;}
    
    protected function set_nilai_name($val)     { $this->input ['nilai_name'] = $val ; }
    protected function get_nilai_name()         { return $this->input ['nilai_name'] ;}
    
    protected function set_model_name($val)     { $this->input ['model_name'] = $val ; }
    protected function get_model_name()         { return $this->input ['model_name'] ;}
    
    protected function get_model_list(){        return array("Persen"  , "Peringkat");    }
    protected function get_model_def(){        return "Persen";    }
    
    protected function set_text_on_top($val) { $this->input ['text_on_top'] = $val;}
    protected function get_text_on_top(){ return $this->input ['text_on_top'] ;}
    
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
     *  @override
     *  return error message
    **/
    protected function get_error_message(){
        $mes = parent::get_error_message();
        if($mes != ""){
            return "<hr style='border:1px solid #CCCCCC;'>".$mes."<hr style='border:1px solid #CCCCCC;'>";
        }
        return "";
    }
    /**
     *  override
     *  prepare something that to be saved into db
    */
    protected function will_change_to_db(){
        $data           = Input::all();        
        //! insert into sessionaddon
        $ses_addon = new Session_Addon_Model();
        $tmp = $this->get_obj_addon($data ['id']);
        if($this->get_purpose() == self::DELE){
            if( $tmp->first()){
               $ses_addon = $ses_addon->find( $tmp->first()->id );
            }
            else{
                //@ error
                return;
            }
            $this->add_obj_dele_db($ses_addon);
            $this->set_invers_obj_dele();
            return parent::will_change_to_db();            
        }
        else{
            //@ there are idsession 
            if( $tmp->first()){
               $ses_addon = $ses_addon->find( $tmp->first()->id );
            }
            //@ there are no id session , usually this is add
            else{
                //! we need find id
                $data ['id']    = $this->get_id_from_save_id ( $this->get_table_name() ,$this->get_max_id() );
                $ses_addon_a = new Session_Addon_Model();        
                $id = $this->get_id_from_save_id ( $ses_addon->get_table_name() , $ses_addon_a->max('id') );
                $ses_addon->id = $id;
            }        
        }
        //@ inti
        $ses_addon->nilai = $data [$this->get_nilai_name()];
        $ses_addon->model = $data [$this->get_model_name()];
        $ses_addon->idsession = $data ['id'] ;
        $this->add_obj_save_db($ses_addon);
        return parent::will_change_to_db();
    }
    /**
     *  get obj of sessionaddon`s table
    */
    protected function get_obj_addon($idsession){
        return Session_Addon_Model::where("idsession","=", $idsession);
    }
}
/**
 *  this class prepare for deleting session especially
**/
class Admin_sarung_session_dele extends Admin_sarung_session_support{
    public function __construct(){
        parent::__construct();
    }
    /**
      *   first html if you want to delete from database
      *  return  index() or blank if non positif
    **/
    public function getEventdel($id , $message = ""){
        if($id >= 0){
            $this->set_id($id);
            $model = $this->get_model_obj()->find( $this->get_id() );
            $array = $this->set_values_to_inputs($model);
            $body  = $this->get_form_cud( $this->get_url_this_dele() , $array ,"disabled");
            $header = sprintf('<h1><span class="glyphicon glyphicon-plus"></span>Session Delete:</h1>%1$s<hr style="border:1px solid #CCCCCC;">',$message);
            $this->set_content( $header.$body.$this->get_error_message() );
            return $this->index();
        }
        else{
            echo "You tried to put non positif id ";
        }
    } 
}
/**
 *  this class prepare for editing session especially
**/
class Admin_sarung_session_edit extends Admin_sarung_session_dele{
    public function __construct(){
        parent::__construct();
    }
    /**
      *   first html if you want to edit from database
      *  return  index() or blank if non positif
    **/
    public final function getEventedit($id ,$values=array(), $message = ""){
        if($id >= 0){
            $this->set_id($id);
            $model = $this->get_model_obj()->find( $this->get_id() );
            $array = $this->set_values_to_inputs($model);
            $body  = $this->get_form_cud( $this->get_url_this_edit() , $array );
            $header = sprintf('<h1><span class="glyphicon glyphicon-plus"></span>Session Edit</h1>%1$s<hr style="border:1px solid #CCCCCC;">',$message);
            $this->set_content($header.$body.$this->get_error_message() );
            return $this->index();            
        }
        else{
            echo "Your Id is Not positif";
        }
    }
    /**
     *  no override
    **/
    public final  function postEventedit(){
        $this->set_purpose( self::EDIT);
		$data = Input::all();
        $id =   $data ['id'] ;
   		$rules = $this->get_rules(true);
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
            $this->set_error_message($message);
			return $this->getEventEdit($id ,array(), $message);
		}
        else{
            return $this->will_edit_to_db($data);
        }            
    }    
}
/**
 *  this class prepare for add session especially
**/
class Admin_sarung_session_add extends Admin_sarung_session_edit{
    public function __construct(){
        parent::__construct();
    }
    public final function getEventadd($messages = ""){
		$this->set_purpose( self::ADDI);
        $all = Input::all();
        $heading    = 'Add';
        $body       = $this->get_form_cud( $this->get_url_this_add() , $all  );
        $header = sprintf('<h1><span class="glyphicon glyphicon-plus"></span>Session</h1>%1$s<hr style="border:1px solid #CCCCCC;">',$messages);
        $this->set_content( $header.$body.$this->get_error_message() );
        return $this->index();
    }
    /**
     *  Default postEventadd ; prepare to insert into database
    **/
    public final function postEventadd(){
        $this->set_purpose( self::ADDI);
        $data = Input::all();
   		$rules = $this->get_rules( true);
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventadd( $message );
		}
        else{
            return $this->will_insert_to_db($data);
        }        
    }
}
class Admin_sarung_session extends Admin_sarung_session_add{
    public function __construct(){        parent::__construct();    }
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array(
                       $this->get_session_name () => '' ,
                       $this->get_nilai_name    () => '0' ,
                       $this->get_model_name    () => $this->get_model_def() ,
                       $this->get_perkiraan_santri_name() => '2' ,
                       $this->get_awal_name()   =>  '' ,
                       $this->get_akhir_name()  =>  ''
        );
        $array = $this->make_one_two_array($array , $values);
        $this->use_select();
		$this->set_input_date( ".".$this->get_akhir_name() , true);
		$this->set_input_date( ".".$this->get_awal_name()  , false);
        $perkiraan_santri = sprintf('<input type="number" name="%1$s" class="%1$s form-control" min="1" max="3" Value="%2$s" %3$s  >',
                                    $this->get_perkiraan_santri_name()              , 
                                    $array [ $this->get_perkiraan_santri_name()]    ,
                                    $disabled );
        
        $array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Session'     , $array [ $this->get_session_name()]   , $this->get_session_name()    , $disabled) ;
        $hasil .= $this->get_input_cud_group( 'Perkiraan Santri'  , $perkiraan_santri) ;
        //@ nilai
        $name = $this->get_nilai_name();
        $nilai = sprintf('<input type="number" name="%1$s" class="%1$s form-control" min="0" Value="%2$s" %3$s  >',
                                    $name              , 
                                    $array [ $name]    ,
                                    $disabled );        
        $hasil .= $this->get_input_cud_group( 'Stayed student'  , $nilai) ;
        //@ model
        $hasil .= $this->get_input_cud_group( 'Model Kenaikan'  , $this->get_model_kenaikan_select() ) ;        
        //@ awal and akhir
        $name = $this->get_awal_name();
        $hasil .= $this->get_text_cud_group( 'Awal'     , $array [$name]    , $name     , $disabled) ;
        $name = $this->get_akhir_name();
        $hasil .= $this->get_text_cud_group( 'Akhir'    , $array [$name]    , $name     , $disabled) ;
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }
    /***
    ****  combo box for model kenaikan
    ****  return select
    ***/
    protected function get_model_kenaikan_select(){
        $name = $this->get_model_name();
        $default = array( "class" => "selectpicker col-md-12" , "name" => $name , "id"   => $name , 'selected' => $this->get_value($name) );
        $items = array("Persen" , "Peringkat");
        return $this->get_select( $items , $default);
    }
    /***
    ****  You should call this on contructor ,and you should make this
    ***/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Session');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('session');
        
        $this->set_perkiraan_santri_name( 'perkiraan_santri' );
        $this->set_session_name ( 'session_name');
        $this->set_awal_name    ( 'awal_name');
        $this->set_akhir_name   ( 'akhir_name' );
        $this->set_nilai_name   ( 'nilai_name') ;
        $this->set_model_name   ( 'model_name');
        
    }
    /**
     *  Default index for this function 
    */
    public function getIndex(){
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Session Table  '.$href);
        $row = "";
        $form = "";
        $session = new Session_Model();
        $wheres = array();
        $sessions = $session->orderBy('updated_at','DESC')->paginate(15);
        foreach($sessions as $event){
            $row .= "<tr>";
                $row .= sprintf('<td>%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $event->id ));
                $row .= sprintf('<td>%1$s</td>' , $event->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->awal);
                $row .= sprintf('<td>%1$s</td>' , $event->akhir);
                $row .= sprintf('<td>%1$s</td>' , $event->perkiraansantri);
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
    					<th>Awal</th>
                        <th>Akhir</th>
                        <th>Perkiraan digit santri</th>
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
			 	$this->get_pagination_link($sessions , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();
    }



    /**
     *  All rules for add , edit and delete
     *  return array
    **/
    protected function get_rules($with_id = false){
        $array = array(
            $this->get_session_name ()  => 'required' ,
            $this->get_nilai_name   ()  => 'required' ,
            $this->get_perkiraan_santri_name() => "required|numeric" ,
            $this->get_awal_name()      => 'required' ,
            $this->get_akhir_name()     => 'required'
        ); 
        if($with_id)
            $array ['id'] = "required|numeric" ; 
        return $array;
    }
   /**
   ***  this will be called just before insert , edit
   ***  return object from session
   ***/
    protected function Sarung_db_about($data , $edit = false , $values = array()){
        $event = new Session_Model();
        if( !$edit ){            $event->id = $data ['id'] ;        }
        else{   $event = $event->find( $data ['id'] );        }
       	$event->nama            = $data [ $this->get_session_name() ]           ;
        $event->perkiraansantri = $data [ $this->get_perkiraan_santri_name() ]  ;
        $event->awal            = $data [ $this->get_awal_name()    ]           ;
        $event->akhir           = $data [ $this->get_akhir_name()   ]           ;
        //@ everything is ready
        return $event;
    }
    /**
     *  
    */
    protected function set_values_to_inputs($model = 'empty'){
        $nilai_name = 0 ; 
        $obj = $this->get_obj_addon($model->id);
        if($obj->first()){
            $nilai_name = $obj->first()->nilai;
        }
        return array(
                     $this->get_session_name()              =>  $model->nama            ,
                     $this->get_nilai_name()                =>  $nilai_name             ,
                     $this->get_perkiraan_santri_name()     =>  $model->perkiraansantri ,
                     $this->get_awal_name()                 =>  $model->awal            ,
                     $this->get_akhir_name()                =>  $model->akhir
        );
    }

    //! this will get table of database
    protected function get_model_obj(){        return new Session_Model();    }
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/session" ;}
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/session/eventadd" ;}
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/session/eventedit" ;}
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/session/eventdel" ;}
}