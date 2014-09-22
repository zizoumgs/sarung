<?php
class Admin_sarung_kelas extends Admin_sarung_pelajaran{
    public function __construct(){        parent::__construct();    }
   	
	/*Kelas table*/
    protected function set_kelas_name($val)     	{ $this->input ['kelas_name'] = $val; }
    protected function get_kelas_name()         	{ return $this->input['kelas_name'];}
    protected function get_kelas_selected ()     	{ return Input::get( $this->get_kelas_name());}
	/*Kelas detail table */
    protected function set_tambahan_biaya_name($val)     	{ $this->input ['tambahan_biaya_name'] = $val; }
    protected function get_tambahan_biaya_name()         	{ return $this->input['tambahan_biaya_name'];}
    protected function get_tambahan_biaya_selected ()     	{ return Input::get( $this->get_tambahan_biaya_selected());}
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
        $this->set_table_name('kelas');
        
		//! form
		$this->set_tingkat_name('tingkat_kelas_name');
		$this->set_level_name('level_kelas_name');
		$this->set_kelas_name('kelas_name');
		$this->set_tambahan_biaya_name('tambahan_biaya_name');
    }

	/**
	 *	return form html for add , edit and delete
	**/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $array = array(
					$this->get_tingkat_name() 		=> 	'' ,
					$this->get_kelas_name()			=> 	'' ,
					$this->get_level_name()			=>	'' ,
					$this->get_tambahan_biaya_name	=>	''
        );
        $array = $this->make_one_two_array($array , $values);
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Tingkat'     	, $array [ $this->get_tingkat_name()]   , $this->get_tingkat_name()    , $disabled) ;
        $hasil .= $this->get_text_cud_group( 'Nama Kelas'  	, $array [ $this->get_kelas_name()]     , $this->get_kelas_name()      , $disabled) ;
		$hasil .= $this->get_text_cud_group( 'Level'  		, $array [ $this->get_level_name()]     , $this->get_level_name()      , $disabled) ;
		$hasil .= $this->get_text_cud_group( 'Level'  		, $array [ $this->get_level_name()]     , $this->get_level_name()      , $disabled) ;
        
   		$hasil .= Form::hidden('id', $this->get_id() );
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
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
                $row .= sprintf('<td>%1$s</td>' , $event->kelas->kelasRoot->tingkat );
                $row .= sprintf('<td>%1$s</td>' , $event->kelas->nama);
				$row .= sprintf('<td title="%2$s">%1$s</td>' , $event->jurusan->short , $event->jurusan->nama);
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
    					<th>Nama</th>
						<th>Jurusan</th>
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
    /*
	  return obj from particular table of database
	*/
    protected function get_model_obj(){        return new Kelas_Detail_Model();    }
	/**
	 *	return url string for view
	*/	
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/jurusan" ;}
	/**
	 *	return url string for add 
	*/
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/jurusan/eventadd" ;}
	/**
	 *	return url string for edit
	*/
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/jurusan/eventedit" ;}
	/**
	 *	return url string for delete
	*/
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/jurusan/eventdel" ;}
}



