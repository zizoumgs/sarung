<?php
/**
*/
/**
 *	this class will be filter result table , and it will be used by view class only (not add)
*/
class Admin_sarung_larangan_nama_helper_filter{
	private $input ;
	/**
	 *	for filter name
	*/
	public function set_name_filter_name($val){
		$this->input ['filter_session'] = $val;
	}
	public function get_name_filter_name(){
		return $this->input ['filter_session'];
	}
	/**
	 *	for pelajaran name
	*/
	public function set_id_filter_name($val){
		$this->input ['filter_byid'] = $val;
	}
	public function get_id_filter_name(){
		return $this->input ['filter_byid'];
	}
	public function set_url($val){		$this->input ['url_this_'] = $val;	}
	public function get_url(){			return $this->input ['url_this_'] ;	}
	/**
	 *	filter result by kelas`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_name( & $where ,  $model ){
		$selected = Input::get( $this->get_name_filter_name() );
		if($selected != "" && $selected !="All"){			
			$where [] = $selected;
            $model = $model->where("nama","LIKE", "%".$selected."%");
		}
		return $model;
	}	
	/**
	 *	filter result by event`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_id( & $where , $model  ){
		$selected = Input::get( $this->get_id_filter_name() );
		if($selected != "" && $selected !="All"){
			$where [] = $selected;
            $model = $model->where("id","=", $selected);
		}
		return $model;
	}	
	/**
	 *	filter result by name`s name
	 *	return obj 
	 **/
	public function set_default_value($url){
        $this->set_url($url);
        $this->set_name_filter_name("Test_ting");
        $this->set_id_filter_name("id_siapa");
	}
	/**
	 *	form to filter
	 *	return form html
	**/
	public function get_form_filter_for_view($params_form =array(), $addition_hidden_value = array() ){
		//! prepare
		$params_default = array(
			'url'		=> 	$this->get_url()									,
			'method'	=>	'get'												,
			'class' 	=>	'form-inline form-filter navbar-form navbar-left'	,
			'role' 		=> 'form'
		);
		foreach($params_form as $key => $val ){
			$params_default [$key] = $val ;
		}
		$new_params_form = $params_default; 
		//@ name
		$tmp  = Form::text( $this->get_name_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Name' ,
                                                                       'Value' =>  Input::get($this->get_name_filter_name() ) ));
		$name_filter = FUNC\get_form_group( $tmp );
        //@ id
		$tmp  = Form::text( $this->get_id_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Id' ,
                                                                       'Value' =>  Input::get($this->get_id_filter_name() ) ));
		$id_filter = FUNC\get_form_group( $tmp );
		//@ form
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .= $name_filter . $id_filter;
    		$hasil .= '<div class="form-group">';
        		$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    		$hasil .= '</div>';
        $hasil .= Form::close();
		return $hasil;
	}

}

/**
 *  class to add
*/
class Admin_sarung_larangan_nama_add extends Admin_sarung_larangan_root{
    public function __construct(){
        parent::__construct();
    }
    protected function set_name_larangan($val)  { $this->input ['name_larangan'] = $val ;}
    protected function get_name_larangan()      { return $this->input ['name_larangan'] ;}
    protected function generate_data_4_input($inputs){
        $array = array();
        $array [$this->get_name_larangan()] = '' ;
        foreach($inputs as $input => $key ){
            $array [$input] = $key;
        }
        return $array;
    }
    /**
     *  Will be used by another class in this file , including edit and delete
    */
    protected function get_form($url , $input , $addiditonal_form = "", $readonly = false){
        //@ array
        $array = array( 'class' => 'form-control input-sm' ,
                       'placeholder' => 'Nama' ,
                       'Value' =>  $input [$this->get_name_larangan()] );
        if($readonly){
            $array ['readOnly'] = "";
        }
        //@
        $input = $this->generate_data_4_input($input);
        $form = sprintf('
            <div class="form-group">
                <label for="nama" class="col-sm-1 control-label">Nama</label>
                <div class="col-sm-3">
                    %1$s
                </div>
            </div>',
            Form::text( $this->get_name_larangan()  , '',  $array));
        $params_default = array(
			'url'		=> 	$url            									,
			'method'	=>	'post'												,
			'class' 	=>	'form-horizontal'	,
			'role' 		=>  'form'
		);
        $result = Form::open($params_default);
        $result .= $form;
        $result .= $addiditonal_form;
        $result .= $this->get_submit();
        $result .= Form::close();
        return $result;
    }
    public function getEventadd($messages = array("")){
        //@ rules
        $this->set_default_values_for_add();
  		$this->set_purpose( self::ADDI);
        $all = Input::all();
        $heading    = '<h1 class="page-header">Add Nama</h1><p>'. $messages[0]."</p><br></br>";
        $body       = $this->get_form( $this->get_url_this_add() , $all  );
        $this->set_content( $heading.$body);
        return $this->index();
    }
    private function get_submit(){
        $button = Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
        return sprintf('
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-11">
                    <button type="submit" class="btn btn-default">Do it</button>
                </div>
            </div>                       
        ',$button);
    }
    /**
    */
    protected final function get_rules($with_id = false){
        $this->set_default_values_for_add();
		$rules = array();
        $rules  [$this->get_name_larangan()	] = "required" ;
        return $rules;
    }
    /**
    */
    protected function set_default_values_for_add(){
        $this->set_name_larangan("larangan_nama");        
    }
    /**
    */
    protected function Sarung_db_about_add($data , $edit = false , $values = array() ){
        $model = $this->get_model_obj();
        $model->id = $data ['id'] ;
        $model->nama = $data [ $this->get_name_larangan()] ;
        return $model ; 
    }
}
/**
 * class to edit
 */
class Admin_sarung_larangan_nama_edit extends Admin_sarung_larangan_nama_add{
    public function __construct(){
        parent::__construct();
    }
    protected function get_model_by_id($id){
        $mdl = $this->get_model_obj();
        $mdl = $mdl->find($id);
        return $mdl;
    }
	/**
    */
    protected function Sarung_db_about_edit($data , $values = array() ){
		$obj = $this->get_model_obj();
		$obj = $obj->find( $data ['id'] );
		$obj->nama = $data [ $this->get_name_larangan() ] ;
        return $obj;
	}
    /**
    */
    public function getEventedit($id , $values = array() , $messages= array("")){
        //@ rules
        $this->set_default_values_for_edit();
  		$this->set_purpose( self::EDIT);
        $all = $this->get_model_by_id($id);
        $result [ $this->get_name_larangan() ] = $all->nama;
   		$id_table = Form::hidden( "id" ,$id);
        //@
        $heading    = sprintf('<h1 class="page-header">Edit larangan`s name with id %1$s</h1><p>%2$s</p><br></br>',$id, $messages[0]);
        $body       = $this->get_form( $this->get_url_this_edit() , $result  , $id_table);
        $this->set_content( $heading.$body);
        return $this->index();        
    }
    /**
    */
    protected function set_default_values_for_edit(){
        $this->set_name_larangan("edit_larangan");        
    }
    //protected function Sarung_db_about_e
    protected final function get_edit_rules($with_id = false){
        $this->set_default_values_for_edit();
		$rules = array();
        $rules  [$this->get_name_larangan()	] = "required" ;
        return $rules;
    }    
}
/**
 * class to delete
 */
class Admin_sarung_larangan_nama_delete extends Admin_sarung_larangan_nama_edit{
    public function __construct(){
        parent::__construct();
    }
	protected function Sarung_db_about_dele($data , $values = array() ){
		$obj = $this->get_model_obj();
		$obj = $obj->find( $data ['id'] );
		$obj->nama = $data [ $this->get_name_larangan() ] ;
        return $obj;
	}
    public function getEventdel($id , $values = array() , $messages= array("")){
        //@ rules
        $this->set_default_values_for_edit();
  		$this->set_purpose( self::DELE);
        $all = $this->get_model_by_id($id);
        $result [ $this->get_name_larangan() ] = $all->nama;
   		$id_table = Form::hidden( "id" ,$id);
        //@
        $heading    = sprintf('<h1 class="page-header">Delete larangan`s name with id %1$s</h1><p>%2$s</p><br></br>',$id, $messages[0]);
        $body       = $this->get_form( $this->get_url_this_dele() , $result  , $id_table , true);
        $this->set_content( $heading.$body);
        return $this->index();        
    }
    protected function set_default_values_for_deleting(){
        parent::set_default_values_for_deleting();
        $this->set_default_values_for_edit();
    }
}
/**
 * root
*/
class Admin_sarung_larangan_nama extends Admin_sarung_larangan_nama_delete{
    public function __construct(){
        parent::__construct();
    }
    /**
    */
    private function get_table($models){
        $row =  "";
        $count = 0 ; 
        //!button
		$button = sprintf('<a href="%1$s" class="btn btn-default btn-xs mar-rig-lit" role="button"> Edit </a><br>
                         <a href="%1$s" class="btn btn-default btn-xs mar-rig-lit" role="button"> Delete </a>',"");
        foreach($models as $model){
            $row .= sprintf('<div id="row_%1$s" class="row like-table" >', $count);
            $row .= sprintf('<div class="col-xs-2 col-md-1">%1$s</div>',$model->id);
            $row .= sprintf('<div class="col-xs-2 col-md-1">%1$s</div>',$this->get_edit_delete_row($model->id));
            $row .= sprintf('<div class="col-xs-4 col-md-8">%1$s</div>',$model->nama);
            $row .= sprintf('<div class="col-xs-3 col-md-2 text-left">Created:%1$s <br> Updated:%2$s</div>',$model->created_at,$model->updated_at );
            $row .= "</div>";
            $count++;
        }
        return $row;
    }
    /**
     *  overrride
    */
    public function getIndex(){
   		parent::getIndex();
        $where = array();
        //@
        $model = $this->get_model_obj();
        //@ filter
        $filter = new Admin_sarung_larangan_nama_helper_filter();
        $filter->set_default_value( $this->get_url_admin_larangan_nama() );
        
        $model = $filter->set_get_filter_by_id($where , $model);
        $model = $filter->set_get_filter_by_name($where , $model);
        $models = $model->orderBy('updated_at','DESC')->paginate(15);
        //@ information
        $information = $filter->get_form_filter_for_view();
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>',
                                $models->getFrom() , $models->getTotal());
        //@ pagination
        $table = $this->get_table($models);
        //@ tittle
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			<div> %5$s </div>
            <div class="table_div like-table-pagination">
				<div class="row">
					%2$s
				</div>
				<div class="row like-table-header">
					<div class="col-xs-2 col-md-1 text-left" style="padding-left:0px;"><div >Id</div></div>
                    <div class="col-xs-2 col-md-1 text-left" style="padding-left:0px;"><div >Id</div></div>
					<div class="col-xs-5 col-md-8 text-left" style="padding-left:0px;">Nama Larangan</div>
                    <div class="col-xs-3 col-md-2 text-left" style="padding-left:0px;">Made</div>
				</div>
                %3$s
            </div>
			%4$s',
			 	sprintf('Pelanggaran <a href="%1$s" class="btn btn-default btn-xs mar-rig-lit" role="button"> Add </a>',$this->get_url_this_add())          ,
   				$information        ,
                $table              ,
				FUNC\get_pagenation_link($models , $where) 	,
				$this->get_error_message()
			);
        $this->set_content(  $hasil );
        return $this->index();
    }
    /**
    **/
    protected function set_default_value(){
		parent::set_default_value();
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Nama Pelanggaran');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('larangan_nama');
        //@
        $this->set_model_obj(new Larangan_Nama_Model());
        
        $this->set_url_this_view( $this->get_url_admin_larangan_nama() );
        $this->set_url_this_add ($this->get_url_admin_larangan_nama("/eventadd") );
        $this->set_url_this_dele($this->get_url_admin_larangan_nama("/eventdel" ));
        $this->set_url_this_edit($this->get_url_admin_larangan_nama("/eventedit"));
        /*
        $this->set_url_this_dele($this->get_url_admin_sarung()."/ujis/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/ujis/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/ujis/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/ujis");
        */
    }
}