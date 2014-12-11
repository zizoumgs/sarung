<?php
/**
 *	This is first program i write without smooking, 09-dec-2014 . it is hard to program/think
 *	(~_~)
*/
/**
 *	this class will be filter result table , and it will be used by view class only (not add)
*/
class Admin_sarung_larangan_meta_helper_filter{
	private $input ;
	/**
	 *	for filter Jenis
	*/
	public function set_jenis_filter_name($val){
		$this->input ['filter_jenis'] = $val;
	}
	public function get_jenis_filter_name(){
		return $this->input ['filter_jenis'];
	}

	/**
	 *	for filter session
	*/
	public function set_session_filter_name($val){
		$this->input ['filter_session'] = $val;
	}
	public function get_session_filter_name(){
		return $this->input ['filter_session'];
	}

	/**
	 *	for filter name
	*/
	public function set_name_filter_name($val){
		$this->input ['filter_by_name'] = $val;
	}
	public function get_name_filter_name(){
		return $this->input ['filter_by_name'];
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
			$where [ $this->get_name_filter_name()] = $selected;
            return $model->wherenama($selected);
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
	 *	filter result by session`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_session( & $where ,  $model ){
		$selected = Input::get( $this->get_session_filter_name() );
		if($selected != "" && $selected !="All"){			
			$where [ $this->get_session_filter_name()] = $selected;
            return $model->wheresession($selected);
		}
		return $model;
	}
	/**
	 *	filter result by jenis`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_jenis( & $where ,  $model ){
		$selected = Input::get( $this->get_jenis_filter_name() );
		if($selected != "" && $selected !="All"){			
			$where [ $this->get_jenis_filter_name()] = $selected;
            return $model->wherejenis($selected);
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
        $this->set_session_filter_name('session_name');
        $this->set_jenis_filter_name('jenis_name');
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
        //@ session
        $name = $this->get_session_filter_name();
        $attrs = array( 'name' => $name ,"class" => "selectpicker span1" ,'selected'=> Input::get($name) ) ;
        $session = FUNC\get_session_select($attrs, array( "All"));
        //@ jenis
        $name = $this->get_jenis_filter_name();
        $attrs = array( 'name' => $name ,"class" => "selectpicker span1" ,'selected'=> Input::get($name) ) ;
        $jenis  = FUNC\get_jenis_pelanggaran_select( $attrs , array("All") );
		//@ form
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .= $name_filter . $id_filter . $session. $jenis;
    		$hasil .= '<div class="form-group">';
        		$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    		$hasil .= '</div>';
        $hasil .= Form::close();
		return $hasil;
	}

}

/**
 *  class to add
 *  form for add , edit and delete is in here
*/
class Admin_sarung_larangan_meta_add extends Admin_sarung_larangan_root{
    public function __construct(){
        parent::__construct();
    }

    protected function set_name_larangan($val)  { $this->input ['name_larangan'] = $val ;}
    protected function get_name_larangan()      { return $this->input ['name_larangan'] ;}

    protected function set_name_session($val)  { $this->input ['name_session'] = $val ;}
    protected function get_name_session()      { return $this->input ['name_session'] ;}

    protected function set_name_jenis($val)  { $this->input ['name_jenis'] = $val ;}
    protected function get_name_jenis()      { return $this->input ['name_jenis'] ;}

    protected function set_name_point($val)  { $this->input ['name_point'] = $val ;}
    protected function get_name_point()      { return $this->input ['name_point'] ;}

    protected function set_name_hukuman($val)  { $this->input ['name_hukuman'] = $val ;}
    protected function get_name_hukuman()      { return $this->input ['name_hukuman'] ;}
	/**
	 *	return array which modified inputs` variable
	*/
    protected function generate_data_4_input($inputs){
        $array = array();
		$array [$this->get_name_larangan()] = '' ;
		$array [$this->get_name_session()] = '' ;
		$array [$this->get_name_jenis()] = '' ;
		$array [$this->get_name_point()] = '' ;
		$array [$this->get_name_hukuman()] = '' ;		
        foreach($inputs as $input => $key ){
            $array [$input] = $key;
        }
        return $array;
    }
	/**
	 * generate input html
	*/
	protected function gen_inp_html($name , $attrs){
		$result = "";
		$tmp  = "";
		foreach( $attrs as $key => $val){
			$tmp .= sprintf(' %1$s = "%2$s" ', $key , $val); 
		}
		return sprintf('<input name = "%1$s" %2$s />' , $name , $tmp ) ;
	}
	/**
	 * generate input html
	*/
	protected function gen_are_html($name , $attrs){
		$result = "";
		$tmp  = "";
		$value = "";
		foreach( $attrs as $key => $val){
			if(strtolower($key) != "value" ){
				$tmp .= sprintf(' %1$s = "%2$s" ', $key , $val);
			}
			else
				$value = $val;
		}
		return sprintf('<textarea name="%1$s" %2$s >%3$s</textarea>' , $name , $tmp , $value ) ;
	}
	/**
	 *	option 0 = input
	 *	option 1 = text area
	 *	option 2 = select
	**/
	private function get_horizontal_input( $inputs ,$display_name,$the_name , $attrs , $option = 0 ){
		if($option != 2 ){
	        //@ array
	        $array = array( 'class' => 'form-control input-sm' ,
	                       'Value' =>  $inputs [ $the_name ] );
			$array = array_merge($array , $attrs);
			//!
			if($option == 0){
				$input = $this->gen_inp_html($the_name , $array);
			}
			elseif($option == 1){
				$input = $this->gen_are_html($the_name , $array);
			}
		}
		else{
			$input = $inputs;
		}
		//! box
        $form = sprintf('
            <div class="form-group">
                <label for="nama" class="col-sm-1 control-label">%1$s</label>
                <div class="col-sm-6">
                    %2$s
                </div>
            </div>',$display_name, $input);
		return $form;
	}
    /**
     *  Will be used by another class in this file , including edit and delete
    */
    protected function get_form($url , $inputs , $addiditonal_form = "", $readonly = false){
		//@ init
		$form = "";
		$this->use_select();
        //@
		$read_only_array = array();
        if($readonly){
            $read_only_array ['readOnly'] = "";
        }
        $inputs = $this->generate_data_4_input($inputs , $read_only_array);
		//@ name
        $name = $this->get_name_larangan();
        $attrs = array( 'name' => $name ,"class" => "selectpicker" ,'selected'=> $inputs [$name] ) ;
        $tmp = FUNC\get_pelanggaran_name_select($attrs);
		$form .= $this->get_horizontal_input( $tmp, "Pelanggaran" , $name , $attrs , 2);		
		//@ session name
        $name = $this->get_name_session();
        $attrs = array( 'name' => $name ,"class" => "selectpicker" ,'selected'=> $inputs [$name] ) ;
        $tmp = FUNC\get_session_select($attrs);
		$form .= $this->get_horizontal_input( $tmp, "Session" , $name , $attrs , 2);
		//@ jenis name
        $name = $this->get_name_jenis();
        $attrs = array( 'name' => $name ,"class" => "selectpicker" ,'selected'=> $inputs [$name] ) ;
        $tmp  = FUNC\get_jenis_pelanggaran_select( $attrs );		
		$form .= $this->get_horizontal_input( $tmp, "Jenis" , $name , $attrs , 2);
 		//@ point name
		$name = $this->get_name_point();
		$attrs = array_merge(array("type" => "Number") , $read_only_array);
		$form .= $this->get_horizontal_input($inputs, "Point" , $name , $attrs);
		//@ hukuman name
		$name = $this->get_name_hukuman();
		$attrs = array_merge(array("rows" => "7") , $read_only_array);
		$form .= $this->get_horizontal_input($inputs, "Hukuman" , $name , $attrs , 1);
		
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
	/**
	 * To make better navigation
	 * return html
	*/
	protected function get_common_link(){
		$array = array("add" => $this->get_url_this_add() ,
					   "View" 	=> $this->get_url_this_view());
		$button = "";
		foreach( $array as $key => $val ){
			$button .= sprintf('<a href="%1$s" class="btn btn-default btn-xs mar-rig-lit" role="button"> %2$s </a>' , $val,$key);	
		}
		return $button;
	}
	/**
	 *	default function for add
	*/
    public function getEventadd($messages = array("")){
        //@ rules
        $this->set_default_values_for_add();
  		$this->set_purpose( self::ADDI);
        $all = Input::all();
		
        $heading    = sprintf('<h1 class="page-header">Add Pelanggaran %1$s</h1><p>%2$s</p><br>',$this->get_common_link() , $messages[0]);
        $body       = $this->get_form( $this->get_url_this_add() , $all  );
        $this->set_content( $heading.$body);
        return $this->index();
    }
	/**
	*/
    private function get_submit(){
        $button = Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm' ) );
        return sprintf('
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-11">
                    <button type="submit" class="btn btn-default">
						<span class="glyphicon glyphicon-thumbs-up"></span> Do it</button>
                </div>
            </div>                       
        ',$button);
    }
    /**
    */
    protected final function get_rules($with_id = false){
        $this->set_default_values_for_add();
		$rules = array();
        $rules  [$this->get_name_hukuman()	] = "required" ;
		$rules  [$this->get_name_point()	] = "required|numeric" ;
        return $rules;
    }
    /**
    */
    protected function set_default_values_for_add(){
        $this->set_name_larangan("larangan_nama");
		$this->set_name_point("Larangan_point");
		$this->set_name_hukuman("Hukuman");
		$this->set_name_session("Larangan_session");
		$this->set_name_jenis("Jenis_larangan");
    }
    /**
    */
    protected function Sarung_db_about_add($data , $edit = false , $values = array() ){
		//@ pelanggaran id
		$obj = new Larangan_Nama_Model();
		$idlarangan = $obj->get_id_by_name( $data [$this->get_name_larangan()] );
		//@ session`s id
		$obj = new Session_Model();
		$idsession = $obj->get_id_by_name( $data [$this->get_name_session()] );
		//@ prepare to insert
        $model = $this->get_model_obj();
        $model->id = $data ['id'] ;		
        $model->point = $data [ $this->get_name_point()] ;
		$model->hukuman = $data [$this->get_name_hukuman() ] ;
		$model->idlarangan = $idlarangan;
		$model->idsession  = $idsession ;
		//@ kind of pelanggaran
		$model->jenis		= $data [$this->get_name_jenis()] ;
        return $model ; 
    }
}
/**
 * class to edit
 */
class Admin_sarung_larangan_meta_edit extends Admin_sarung_larangan_meta_add{
    public function __construct(){
        parent::__construct();
    }
	/**
	*/
    protected function get_model_by_id($id){
        $mdl = $this->get_model_obj();
        $mdl = $mdl->find($id);
        return $mdl;
    }
	/**
	 *	input id
	 *	return array 
	*/
    protected function get_values_by_id($id){
        $all = $this->get_model_by_id($id);
        $result [ $this->get_name_larangan() ]  = $all->namaObj->nama;
		$result [ $this->get_name_session() ]   = $all->sessionObj->nama;
		$result [ $this->get_name_jenis()]		= $all->jenis;
		$result [ $this->get_name_hukuman()]	= $all->hukuman;
		$result [ $this->get_name_point()]		= $all->point;
		return $result;
    }	
	/**
	 * database for edit
    */
    protected function Sarung_db_about_edit($data , $values = array() ){
		//@ pelanggaran id
		$obj = new Larangan_Nama_Model();
		$idlarangan = $obj->get_id_by_name( $data [$this->get_name_larangan()] );
		//@ session`s id
		$obj = new Session_Model();
		$idsession = $obj->get_id_by_name( $data [$this->get_name_session()] );
		//@ prepare to insert
        $model = $this->get_model_obj();
        $model = $model->find( $data ['id'] ) ;		
        $model->point = $data [ $this->get_name_point()] ;
		$model->hukuman = $data [$this->get_name_hukuman() ] ;
		$model->idlarangan = $idlarangan;
		$model->idsession  = $idsession ;
		//@ kind of pelanggaran
		$model->jenis		= $data [$this->get_name_jenis()] ;
        return $model ; 
	}
    /**
	 * default view to edit
    */
    public function getEventedit($id , $values = array() , $messages= array("")){
        //@ rules
        $this->set_default_values_for_edit();
  		$this->set_purpose( self::EDIT );
		//$ set value
		$result = $this->get_values_by_id($id);
   		$id_table = Form::hidden( "id" ,$id);
		//@ add break
		if($messages[0] != "")
			$messages [0] .= "<br><br>";
        //@
        $heading    = sprintf('<h1 class="page-header">Edit larangan`s meta with <small><strong>id %1$s</strong></small> %2$s</h1><p>%3$s</p>',
							  $id,
							  $this->get_common_link(),
							  $messages[0]);
        $body       = $this->get_form( $this->get_url_this_edit() , $result  , $id_table);
        $this->set_content( $heading.$body);
        return $this->index();        
    }
    /**
    */
    protected function set_default_values_for_edit(){
		$this->set_default_values_for_add();
    }
    //protected function Sarung_db_about_e
    protected final function get_edit_rules($with_id = false){
        $this->set_default_values_for_edit();
		return $this->get_rules();
    }    
}
/**
 * class to delete
 */
class Admin_sarung_larangan_meta_delete extends Admin_sarung_larangan_meta_edit{
    public function __construct(){
        parent::__construct();
    }
	/**
	*/
	protected function Sarung_db_about_dele($data , $values = array() ){
		$obj = $this->get_model_obj();
		$obj = $obj->find( $data ['id'] );
		$obj->nama = $data [ $this->get_name_larangan() ] ;
        return $obj;
	}
	/**
	*/
    public function getEventdel($id , $values = array() , $messages= array("")){
        //@ rules
        $this->set_default_values_for_edit();
  		$this->set_purpose( self::DELE );
		$result = $this->get_values_by_id($id);
   		$id_table = Form::hidden( "id" ,$id);
		//@ add break
		if($messages[0] != "")
			$messages [0] .= "<br><br>";
        //@
        $heading    = sprintf('<h1 class="page-header">Delete larangan`s meta with id %1$s</h1><p>%2$s</p>',$id, $messages[0]);
        $body       = $this->get_form( $this->get_url_this_dele() , $result  , $id_table , true);
        $this->set_content( $heading.$body);
        return $this->index();        
    }
	/**
	**/
    protected function set_default_values_for_deleting(){
        parent::set_default_values_for_deleting();
        $this->set_default_values_for_edit();
    }
}
/**
 * root
*/
class Admin_sarung_larangan_meta extends Admin_sarung_larangan_meta_delete{
    protected function set_name_show_dialog($val){ $this->values ['dialog_show_name'] = $val ; }
    protected function get_name_show_dialog(){ return $this->values ['dialog_show_name']; }
    
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
            $group = sprintf('
                         Jenis: %1$s<br>
                         Point: %2$s<br>
                         Nama : %3$s
                         ',
                    $model->jenis,
                    $model->point,
                    $model->sessionobj->nama
                );
            $short_hukuman = str_limit($model->hukuman , 20 , "...");
            $short_hukuman = sprintf('<button class="btn btn-primary btn-xs "		
									onclick="select_handle(\'%1$s\')">%2$s</button>',$model->hukuman , $short_hukuman);
            $row .= sprintf('<div id="row_%1$s" class="row like-table" >', $count);
            $row .= sprintf('<div class="col-xs-1 col-md-1">%1$s</div>',$model->id);
            $row .= sprintf('<div class="col-xs-1 col-md-1">%1$s</div>',$this->get_edit_delete_row($model->id));
            $row .= sprintf('<div class="col-xs-3 col-md-3">%1$s</div>',$model->namaobj->nama);
            $row .= sprintf('<div class="col-xs-3 col-md-3">%1$s</div>',$group);
            $row .= sprintf('<div class="col-xs-2 col-md-2">%1$s</div>',$short_hukuman);
            $row .= sprintf('<div class="col-xs-2 col-md-2 text-left"><small>Created:%1$s <br> Updated:%2$s</small></div>',$model->created_at,$model->updated_at );
            $row .= "</div>";
            $count++;
        }
        return sprintf('
            <div class="row like-table-header">
            	<div class="col-xs-2 col-md-1 text-left" style="padding-left:0px;"><div >Id</div></div>
                <div class="col-xs-2 col-md-1 text-left" style="padding-left:0px;"><div >Man</div></div>
            	<div class="col-xs-2 col-md-3 text-left" style="padding-left:0px;">Nama Larangan</div>
                <div class="col-xs-3 col-md-3 text-left" style="padding-left:0px;">Berat-Larangan</div>
                <div class="col-xs-2 col-md-2 text-left" style="padding-left:0px;">Hukuman</div>
                <div class="col-xs-1 col-md-2 " style="padding-left:0px;">Made</div>
			</div>
            %1$s',
        $row);
    }
    /**
     **/
	protected function get_dialog(){
		$hasil = sprintf('
			<!------------------------------------------------------------------------------------------------------------------------->
			<div class="modal fade" id="%1$s" name="%1$s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span>
								<span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title">Hukuman</span></h4>
						</div>
						<div class="modal-body">
                            <!-- Place to show hukuman notes-->
                            <div id="hukuman"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		','hukumanModal');
		return $hasil;
	}
    /**
     *  overrride
    */
    public function getIndex(){
   		parent::getIndex();
        $where = array();
        $this->use_select();
        //@
        $model = $this->get_model_obj();
        //@ filter
        $filter = new Admin_sarung_larangan_meta_helper_filter();
        $filter->set_default_value( $this->get_url_admin_larangan_meta() );
        
        $model = $filter->set_get_filter_by_id($where , $model);
        $model = $filter->set_get_filter_by_name($where , $model);
        $model = $filter->set_get_filter_by_session($where , $model);
        $model = $filter->set_get_filter_by_jenis($where , $model);
        $models = $model->orderBy('updated_at','DESC')->paginate(15);		
        //@ information
        $information = $filter->get_form_filter_for_view();
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>',
                                $models->getFrom() , $models->getTotal());
        //@ pagination
        $table = $this->get_table($models);
		$models->setBaseUrl( $this->get_url_this_view() );
        //@ tittle
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			<div> %5$s </div>
            <div class="table_div like-table-pagination">
				<div class="row">
					%2$s
				</div>
                %3$s
            </div>
			%4$s',
			 	sprintf('Pelanggaran %1$s' , $this->get_common_link())          ,
   				$information        ,
                $table              ,
				FUNC\get_pagenation_link($models , $where) 	,
				$this->get_error_message()
			);
        $this->set_content(  $hasil. $this->get_dialog() );
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
        $this->set_table_name('larangan_meta');
        //@
        $this->set_model_obj(new Larangan_Meta_Model());
        
        $this->set_url_this_view( $this->get_url_admin_larangan_meta() );
        $this->set_url_this_add ($this->get_url_admin_larangan_meta("/eventadd") );
        $this->set_url_this_dele($this->get_url_admin_larangan_meta("/eventdel" ));
        $this->set_url_this_edit($this->get_url_admin_larangan_meta("/eventedit"));

        //@
        $this->set_name_show_dialog('future_soverrated');
        $js = sprintf('<script>
			//! for showing dialog
            function select_handle(hukuman){
                $("#hukuman").html(hukuman);
				$("#hukumanModal").modal({keyboard: true});
            }
            </script>
         ');
        $this->set_js($js);
        /*
        $this->set_url_this_dele($this->get_url_admin_sarung()."/ujis/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/ujis/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/ujis/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/ujis");
        */
    }
}