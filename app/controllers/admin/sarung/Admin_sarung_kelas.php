<?php
class Admin_sarung_kelas extends Admin_sarung_kelas_root{
    public function __construct(){        parent::__construct();    }
   	
	/*Kelas table*/
    protected function set_kelas_name($val)     	{ $this->input ['kelas_name'] = $val; }
    protected function get_kelas_name()         	{ return $this->input['kelas_name'];}
    protected function get_kelas_selected ()     	{ return Input::get( $this->get_kelas_name());}
	/**
	 *	return select html for jurusan
	 */
	protected function get_jurusan_select($selected = ''){
		$session = new Jurusan_Model();
		$sessions = $session->orderBy('nama' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_jurusan_name() , 'selected' => $selected);
		return $this->get_select($items , $default);
	}
	/**
	 *	return select html for kelas_root
	 */
	protected function get_tingkat_select($selected = ''){
		$session = new Kelas_Root_Model();
		$sessions = $session->orderBy('tingkat' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->tingkat;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_tingkat_name() , 'selected' => $selected);
		return $this->get_select($items , $default);
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
        $this->set_table_name('kelas');
        
		//! form
		$this->set_tingkat_name('tingkat_kelas_name');
		$this->set_kelas_name('kelas_name');
		$this->set_jurusan_name('jurusan_name');
    }

	/**
	 *	return html form for add , edit and delete
	**/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
		$this->use_select();
        $array = array(
					$this->get_tingkat_name() 		=> 	'' ,
					$this->get_kelas_name()			=> 	'' ,
					$this->get_jurusan_name()		=> '' ,
        );
        $array = $this->make_one_two_array($array , $values);		
        $params = array('label' , 'value');
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
        $hasil .= $this->get_text_cud_group( 'Nama Kelas'  	, $array [ $this->get_kelas_name()]     , $this->get_kelas_name()      , $disabled) ;
		$hasil .= $this->get_input_cud_group_kelas_root( 'Jurusan'  , $this->get_jurusan_select($array[$this->get_jurusan_name()]) ) ;
		$hasil .= $this->get_input_cud_group_kelas_root( 'Tingkat'  , $this->get_tingkat_select($array[$this->get_tingkat_name()]) ) ;
        
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
                $row .= sprintf('<td>%1$s</td>' , $event->kelasRoot->tingkat );
                $row .= sprintf('<td>%1$s</td>' , $event->nama);
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
            $this->get_kelas_name ()  => 'required'			
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
		$jurusan = new Jurusan_Model();
		$idjurusan = $jurusan->where('nama','=' , $data [ $this->get_jurusan_name()   ] )->first();
		$kelasRoot =  new Kelas_Root_Model();
		$idKelasRoot = $kelasRoot->where('tingkat' ,'=' , $data [ $this->get_tingkat_name() ])->first();
		
   		$event->nama            = $data [ $this->get_kelas_name()   ]			;
       	$event->idjurusan       = $idjurusan->id;
		$event->idkelasroot		= $idKelasRoot->id;
        return $event;
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
	/*
	 *	return html which containts all information about add .
	*/
	private function get_information(){
		return sprintf('
			<p>Table ini memerlukan pengisian table Jurusan dan Tingkat , jadi bila and tidak menemukan session atau event yang anda
			inginkan anda harus menambahkannya terlebih dahulu!</p><hr>
			<p>Jika kamu menginginkan menambahkan Jurusan silahkan click link berikut 		</p><a href="%1$s" class="btn btn-xs btn-primary pull-right">Jurusan</a><br><hr>
			<p>Jika kamu menginginkan menambahkan Tingkat silahkan click link berikut 	</p><a href="%2$s" class="btn btn-xs btn-info pull-right">Tingkat</a>
		',$this->get_url_admin_jurusan() , $this->get_url_admin_kelas_root());
	}	
	/**
	 *	return array , useful for inserting value to input when we do editing 
	*/
    protected function set_values_to_inputs($model){
        return array(
                     $this->get_kelas_name()			=>  $model->nama            ,
					 $this->get_tingkat_name()			=> $model->kelasRoot->tingkat ,
					 $this->get_jurusan_name()			=> $model->jurusan->nama
        );
    }
    /*
	  return obj from particular table of database
	*/
    protected function get_model_obj(){        return new Kelas_Model();    }
	/**
	 *	return url string for view
	*/	
    protected function get_url_this_view(){ return $this->get_url_admin_sarung()."/kelas" ;}
	/**
	 *	return url string for add 
	*/
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/kelas/eventadd" ;}
	/**
	 *	return url string for edit
	*/
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/kelas/eventedit" ;}
	/**
	 *	return url string for delete
	*/
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/kelas/eventdel" ;}
}



