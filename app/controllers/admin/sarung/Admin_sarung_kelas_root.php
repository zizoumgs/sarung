<?php
class Admin_sarung_kelas_root extends Admin_sarung_pelajaran{
    private $input;
    
    public function __construct(){
                parent::__construct();
    }
	/*Kelas Root table*/
    protected function set_tingkat_name($val)   {  $this->input ['tingkat_name'] = $val; }
    protected function get_tingkat_name()       {  return $this->input ['tingkat_name'] ; }
    protected function get_tingkat_selected ()  {  return Input::get( $this->get_tingkat_name() ) ;}
    
	/*Kelas Root table*/
    protected function set_level_name($val)     { $this->input ['level_name'] = $val; }
    protected function get_level_name()         { return $this->input['level_name'];}
    protected function get_level_selected ()     { return Input::get( $this->get_level_name());}
	/*
		return form-group class which will be containter for input html
	*/
    protected function get_input_cud_group_kelas_root( $label , $input ){
        return sprintf('
        <div class="form-group form-group-sm">
            <label class="col-sm-2 control-label" >%1$s</label>
            <div class="col-sm-8">
                %2$s
            </div>
        </div>' , $label , $input);
    }
    /*
		All variable that you should set it manually
		return none ;
	*/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Kelas');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('Kelas_filter');
        $this->set_table_name('kelas_root');
        
		//! form
		$this->set_tingkat_name('tingkat_kelas_name');
		$this->set_level_name('level_kelas_name');
    }
	/**
	 *	Default view which
	 *	return @index()
	*/
    public function getIndex(){
        $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Kelas Table  '.$href);
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
                $row .= sprintf('<td>%1$s</td>' , $event->tingkat );
                $row .= sprintf('<td>%1$s</td>' , $event->level);
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
    					<th>Tingkat</th>
    					<th>Level</th>
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
	 *	return form html for add , edit and delete
	**/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array(
					$this->get_tingkat_name() 		=> 	'' ,
					$this->get_level_name()			=>	'' 
        );
        $array = $this->make_one_two_array($array , $values);
		$tingkat = $this->get_input(array('type' => 'number' ,
										 'class' => sprintf('%1$s form-control',$this->get_tingkat_name()) ,
										 'min' => 1 , 'max' => 10 , 
										 'name' => $this->get_tingkat_name() , 'Value' => $array [$this->get_tingkat_name()]
										 ) , $disabled) ;
		$level = $this->get_input(array('type' => 'number' ,
										 'class' => sprintf('%1$s form-control',$this->get_level_name()) ,
										 'min' => 1 , 'max' => 10 , 
										 'name' => $this->get_level_name() , 'Value' => $array [$this->get_level_name()]
										 ) , $disabled) ;
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_input_cud_group_kelas_root('Tingkat', $tingkat);
        $hasil .= $this->get_input_cud_group_kelas_root('Level'  , $level);
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }    
	/**
	 *	return array
	 *	will be called in add , edit function 
	*/
    protected function get_rules($with_id = false){
        $array = array(
            $this->get_tingkat_name ()  => 'required|numeric' ,
            $this->get_level_name   ()  => 'required|numeric' 
        ); 
        if($with_id)
            $array ['id'] = "required|numeric" ; 
        return $array;
    }
	/**
	 *	return array , useful for inserting value to input when we do editing 
	*/
    protected function set_values_to_inputs($model){
        return array(
                     $this->get_tingkat_name()		=>  $model->tingkat		,
                     $this->get_level_name()		=>  $model->level
        );
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
   		$event->tingkat            = $data [ $this->get_tingkat_name()   ]	;
       	$event->level	           = $data [ $this->get_level_name() ]		;
        return $event;
    }
    /*
	  return obj from particular table of database
	*/
    protected function get_model_obj(){        return new Kelas_Root_Model();    }
	/**
	 *	return url string for view
	*/	
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/kelas_root" ;}
	/**
	 *	return url string for add 
	*/
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/kelas_root/eventadd" ;}
	/**
	 *	return url string for edit
	*/
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/kelas_root/eventedit" ;}
	/**
	 *	return url string for delete
	*/
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/kelas_root/eventdel" ;}
}