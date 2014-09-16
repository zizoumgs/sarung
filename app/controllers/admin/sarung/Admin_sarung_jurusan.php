<?php
class Admin_sarung_jurusan extends Admin_sarung_pelajaran{
    private $input;
    public function __construct(){        parent::__construct();    }
   
    protected function set_jurusan_name($val)   {  $this->input ['jurusan_name'] = $val; }
    protected function get_jurusan_name()       {  return $this->input ['jurusan_name'] ; }
    protected function get_jurusan_selected ()  {  return Input::get( $this->get_jurusan_name() ) ;}
    
    protected function set_jurusan_short_name($val)     { $this->input ['jurusan_short_name'] = $val; }
    protected function get_jurusan_short_name()         { return $this->input['jurusan_short_name'];}
    protected function get_jurusan_short_selected ()     { return Input::get( $this->get_jurusan_short_name());}
	/**
	 *	return form html for add , edit and delete
	**/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array(
                       $this->get_jurusan_name 			() 	=> 	'' ,
                       $this->get_jurusan_short_name    () 	=> 	''
                       );
        $array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Jurusan'     , $array [ $this->get_jurusan_name()]   , $this->get_jurusan_name()    , $disabled) ;
        $hasil .= $this->get_text_cud_group( 'Short_Name'  , $array [ $this->get_jurusan_short_name()]     , $this->get_jurusan_short_name()      , $disabled) ;
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }

    /*
		All variable that you should set it manually
		return none ;
	*/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Pelajaran');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('jurusan_filter');
        $this->set_table_name('jurusan');
        
		//! form
		$this->set_jurusan_name('jurusan_name');
		$this->set_jurusan_short_name('jurusan_name_short');
    }
	/**
	 *	Default view which
	 *	return @index()
	*/
    public function getIndex(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Jurusan Table  '.$href);
        $row = "";
        $form = $this->get_form_filter( $this->get_url_this_view() );
        $session = $this->get_model_obj();
        $wheres = array();
        if( $find_name != ""){
            $wheres [] = array( $this->get_name_for_text() => $find_name );
            $session = $session->where('nama' , 'LIKE' , "%".$find_name."%");
        }
        $sessions = $session->orderBy('updated_at','DESC')->paginate(15);
        foreach($sessions as $event){
            $row .= "<tr>";
                $row .= sprintf('<td>%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s</td>' , $this->get_edit_delete_row( $event->id ));
                $row .= sprintf('<td>%1$s</td>' , $event->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->short);
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
    					<th>Short Name</th>
    					<th>Updated_at</th>
    					<th>Created_at</th>
    				</tr>
    				%3$s				
    			</table>
            </div>%4$s',
			 	$this->get_text_on_top() ,
   				$form               ,
                $row                ,
			 	$this->get_pagination_link($sessions , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();
    }
	/**
	 *	return array
	 *	will be called in add , edit function 
	*/
    protected function get_rules($with_id = false){
        $array = array(
            $this->get_jurusan_name ()  => 'required' ,
            $this->get_jurusan_short_name   ()  => 'required' 
        ); 
        if($with_id)
            $array ['id'] = "required|numeric" ; 
        return $array;
    }
	/**
	 *	return obj
	 *	this will be called just before insert , edit
	*/
    protected function Sarung_db_about($data , $edit = false){
        $event = $this->get_model_obj();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
        }
   		$event->nama            = $data [ $this->get_jurusan_name()   ]			;
       	$event->short           = $data [ $this->get_jurusan_short_name() ]		;
        return $event;
    }
	/**
	 *	return array , useful for inserting value to input when we do editing 
	*/
    protected function set_values_to_inputs($model){
        return array(
                     $this->get_jurusan_name()			=>  $model->nama            ,
                     $this->get_jurusan_short_name()	=>  $model->short
        );
    }
	
    //! this will get table of database
    protected function get_model_obj(){        return new Jurusan_Model();    }
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/jurusan" ;}
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/jurusan/eventadd" ;}
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/jurusan/eventedit" ;}
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/jurusan/eventdel" ;}
}



