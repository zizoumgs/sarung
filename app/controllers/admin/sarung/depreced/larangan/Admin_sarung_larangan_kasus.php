<?php
/**
 *	this class will be filter result table , and it will be used by view class only (not add)
*/
class Admin_sarung_larangan_kasus_helper_filter{
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
	 *	for id
	*/
	public function set_id_filter_name($val){
		$this->input ['filter_byid'] = $val;
	}
	public function get_id_filter_name(){
		return $this->input ['filter_byid'];
	}
	/**
	 *	for santri name
	*/
	public function set_filter_santri($val){
		$this->input ['filter_by_santri'] = $val;
	}
	public function get_filter_santri(){
		return $this->input ['filter_by_santri'];
	}
	
	public function set_url($val){		$this->input ['url_this_'] = $val;	}
	public function get_url(){			return $this->input ['url_this_'] ;	}
	/**
	 *	filter result by kelas`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_santri( & $where ,  $model ){
		//@ remove end space
		$find = rtrim( Input::get( $this->get_filter_santri() ) );
		//@ remove first space
		$selected = ltrim($find);
		if($selected != "" && $selected !="All"){
			$where [ $this->get_filter_santri()] = $selected;
            return $model->wheresantri($selected);
		}
		return $model;
	}
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
		$this->set_filter_santri('filter_santri');
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
        //@ session
		$tmp  = Form::text( $this->get_filter_santri()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Santri' ,
                                                                       'Value' =>  Input::get($this->get_filter_santri() ) ));
		$santri = FUNC\get_form_group( $tmp );
		//@ form
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .= $name_filter.$santri . $id_filter . $session. $jenis;
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
class Admin_sarung_larangan_kasus_add extends Admin_sarung_larangan_root{
    public function __construct(){
        parent::__construct();
    }

	//! will true if default value_for_add has been ran
	protected $init_value_add = false;
	//! to count total item which is used by 
	protected $total_item = array();
	/**
	 * to be used for add value to particular key of input
	*/
	private function set_item($key , $val ){
		$this->total_item  [] = $val ;
		$this->input[$key] = $val ; 
	}
    protected function set_name_alamat($val)  {	$this->set_item('name_alamat',$val);}
    protected function get_name_alamat()      { return $this->input ['name_alamat'] ;}

    protected function set_name_santri($val)  { $this->set_item('name_santri',$val);}
    protected function get_name_santri()      { return $this->input ['name_santri'] ;}

    protected function set_name_id_admind($val)  { $this->set_item('name_admind',$val);}
    protected function get_name_id_admind()      { return $this->input ['name_admind'] ;}

    protected function set_name_id_santri($val)  { $this->set_item('id_santri',$val);}
    protected function get_name_id_santri()      { return $this->input ['id_santri'] ;}

    protected function set_name_id_larangan($val)  { $this->set_item('id_larangan',$val);}
    protected function get_name_id_larangan()      { return $this->input ['id_larangan'] ;}
	
    protected function set_name_larangan($val)  { $this->set_item('name_larangan',$val);}
    protected function get_name_larangan()      { return $this->input ['name_larangan'] ;}

    protected function set_name_session($val)  { $this->set_item('name_session',$val);}
    protected function get_name_session()      { return $this->input ['name_session'] ;}

    protected function set_name_tanggal($val)  { $this->set_item('name_tanggal',$val);}
    protected function get_name_tanggal()      { return $this->input ['name_tanggal'] ;}
	
	/**
	 *	form name
	 **/
	protected function set_name_form($val){		$this->input ['form_name'] = $val;	}
	protected function get_name_form(){		return $this->input['form_name'];	}


	/**
	 *	return array which modified inputs` variable
	*/
    protected function generate_data_4_input($inputs){
        $array = array();
		foreach($this->total_item as $item){
			$array [$item] = "";
		}
        foreach($inputs as $key => $val ){
            $array [$key] = $val;
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
                <label for="nama" class="col-sm-3 control-label">%1$s</label>
                <div class="col-sm-9">
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
            //$read_only_array ['readOnly'] = "";
			$read_only_array ['disabled'] = "";
        }
        $inputs = $this->generate_data_4_input($inputs , $read_only_array);
		$form .= $this->get_santri_form($inputs , $read_only_array);
		$form .= $this->get_pelanggaran_form($inputs , $read_only_array);
		
        $params_default = array(
			'name'		=> 	$this->get_name_form()								,
			'id'		=> 	$this->get_name_form()								,
			'url'		=> 	$url            									,
			'method'	=>	'post'												,
			'role' 		=>  'form'
		);
        $result = Form::open($params_default);
        $result .= sprintf('<div class="row">%1$s</div>',$form);
        $result .= $addiditonal_form;
        $result .= $this->get_submit();
        $result .= Form::close();
        return $result;
    }
	/**
	 *	pelanggaran form.
	*/
	protected function get_pelanggaran_form( $inputs , $read_only_array){
		$form = "";
		$form .= "<div class='col-md-6'><div class='form-horizontal'>";
		//@ id larangan
		$name  = $this->get_name_id_larangan();
		$attrs = array_merge(array("type" => "Number" , "id" => $name ) , $read_only_array);
		$form .= $this->get_horizontal_input($inputs, "Id Pelanggaran" , $name , $attrs);
 		//@ santri name
		$name  = $this->get_name_larangan();
		$attrs = array("type" => "Text" , "ReadOnly" => "" , "id" => $name );
		$form .= $this->get_horizontal_input($inputs, "Nama" , $name , $attrs);
 		//@ address name
		$name  = $this->get_name_session();
		$attrs = array("type" => "Text" , "ReadOnly" => "" , "id" => $name );
		$form .= $this->get_horizontal_input($inputs, "Session" , $name , $attrs);
		$form .= "</div></div>";
		return $form ; 
	}
	/**
	 *	santri form and tanggal
	*/
	protected function get_santri_form( $inputs , $read_only_array){		
		$form = "";
		$form .= "<div class='col-md-6'><div class='form-horizontal'>";
		//@ id_admind
		$name  = $this->get_name_id_admind();
		$attrs = array_merge(array("type" => "Number" , "id"=>$name ) , $read_only_array);
		$form .= $this->get_horizontal_input($inputs, "Id Admin" , $name , $attrs);
		//@ id santri
		$name  = $this->get_name_id_santri();
		$attrs = array_merge(array("type" => "Number" , "id"=>$name) , $read_only_array);
		$form .= $this->get_horizontal_input($inputs, "Id Santri" , $name , $attrs);
 		//@ santri name
		$name  = $this->get_name_santri();
		$attrs = array("type" => "Text" , "ReadOnly" => "" , "id" => $name);
		$form .= $this->get_horizontal_input($inputs, "Santri" , $name , $attrs);
 		//@ address name
		$name  = $this->get_name_alamat();
		$attrs = array("type" => "Text" , "ReadOnly" => "" , "id" => $name );
		$form .= $this->get_horizontal_input($inputs, "Alamat" , $name , $attrs);
		//@ tanggal / date
		$name  = $this->get_name_tanggal();
		$attrs = array("type" => "Text" , "id" => $name , "class" => $name ." form-control input-sm " );
		$attrs = array_merge( $attrs , $read_only_array);
		$form .= $this->get_horizontal_input($inputs, "Tanggal" , $name , $attrs);
		$form .= "</div></div>";
		$this->set_input_date( ".".$this->get_name_tanggal() , true);
		return $form ; 
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
                <div class="col-sm-offset-11 col-sm-1">
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
        $rules  [$this->get_name_santri()	] = "required" ;
		$rules  [$this->get_name_alamat()	] = "required" ;
		$rules  [$this->get_name_larangan()	] = "required" ;
		$rules  [$this->get_name_session()	] = "required" ;
        return $rules;
    }
    /**
    */
    protected function Sarung_db_about_add($data , $edit = false , $values = array() ){
		//@ find id santri
		$id_admind = $data [ $this->get_name_id_admind() ] ;
		if($id_admind == -1){
			$id_santri = $data [ $this->get_name_id_santri() ] ;
			$santri = Santri_Model::find($id_santri);
			if($santri){
				$id_admind = $santri->user->id;
			}
			else{
				$id_admind = -1;
			}
		}
		//@ find id pelanggaran meta
		$idlarangan = $data [ $this->get_name_id_larangan()] ; 
		//@ prepare to insert
        $model = $this->get_model_obj();
        $model->id = $data ['id'] ;
		$model->idlarangan 	= 	$idlarangan;
		$model->idadmind   	= 	$id_admind ;
		$model->tanggal		=	$data [$this->get_name_tanggal()] ; 	
        return $model ; 
    }
    /**
	 *	all value that will be used by this class
    */
    protected function set_default_values_for_add(){
		if( $this->init_value_add )
			return;
		$this->set_name_alamat("alamat");
		$this->set_name_id_admind("id_admind");
		$this->set_name_id_larangan("id_larangan");
		$this->set_name_id_santri("id_santri");
		$this->set_name_larangan("larangan");
		$this->set_name_santri("Larangan_santri");
		$this->set_name_session("Session_larangan");
		$this->set_name_form('name_of_form') ;
		$this->set_name_tanggal("name_of_tanggal");
		//@ js
		$js = $this->get_js_ajax();
		$this->set_js($js);
		//!
		$this->init_value_add = true;
    }
}
/**
 * class to edit
 */
class Admin_sarung_larangan_kasus_edit extends Admin_sarung_larangan_kasus_add{
    public function __construct(){
        parent::__construct();
    }
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
        $result [ $this->get_name_id_admind() ] 	= $all->userObj->id;
		//@ sometime there are santri who doest have santri`s id
		if($all->userObj->santri)
			$result [ $this->get_name_id_santri() ] 	= $all->userObj->santri->id;
			
		$result [ $this->get_name_santri() ]		= $all->userObj->first_name ."-". $all->userObj->second_name;
		$result [ $this->get_name_alamat() ]		= $all->userObj->desa->kecamatan->nama."-". $all->userObj->desa->nama;
		$result [ $this->get_name_tanggal()]			= $all->tanggal;
		//@
		$result [ $this->get_name_id_larangan()]	= $all->metaObj->id;
		$result [ $this->get_name_larangan()]		= $all->metaObj->namaObj->nama;
		$result [ $this->get_name_session() ]		= $all->metaObj->sessionObj->nama;
		return $result;
    }	
	/**
    */
    protected function Sarung_db_about_edit($data , $values = array() ){
		//@ find id santri
		$id_admind = $data [ $this->get_name_id_admind() ] ;
		if($id_admind == -1){
			$id_santri = $data [ $this->get_name_id_santri() ] ;
			$santri = Santri_Model::find($id_santri);
			if($santri){
				$id_admind = $santri->user->id;
			}
			else{
				$id_admind = -1;
			}
		}
		//@ find id pelanggaran meta
		$idlarangan = $data [ $this->get_name_id_larangan()] ; 
		//@ prepare to insert
        $model = $this->get_model_obj();
		$model = $model->find( $data ['id'] );
		$model->idlarangan 	= 	$idlarangan;
		$model->idadmind   	= 	$id_admind ;
		$model->tanggal		=	$data [$this->get_name_tanggal()] ; 	
        return $model ; 
	}
    /**
    */
    public function getEventedit($id , $values = array() , $messages= array("")){
        //@ rules
        $this->set_default_values_for_edit();
  		$this->set_purpose( self::EDIT);
		//$ set value
		$result = $this->get_values_by_id($id);
   		$id_table = Form::hidden( "id" ,$id);
		//@ add break
		if($messages[0] != "")
			$messages [0] .= "<br><br>";
			
        //@
        $heading    = sprintf('<h1 class="page-header">Edit Kasus with <small><strong>id %1$s</strong></small> %2$s</h1><p>%3$s</p>',
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
		$rules = array();
        $rules  [$this->get_name_larangan()	] = "required" ;
        return $rules;
    }    
}
/**
 * class to delete
 */
class Admin_sarung_larangan_kasus_delete extends Admin_sarung_larangan_kasus_edit{
    public function __construct(){
        parent::__construct();
    }
	protected function Sarung_db_about_dele($data , $values = array() ){
		$obj = $this->get_model_obj();
		$obj = $obj->find( $data ['id'] );
        return $obj;
	}
    public function getEventdel($id , $values = array() , $messages= array("")){
        //@ rules
        $this->set_default_values_for_edit();
  		$this->set_purpose( self::DELE);
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
    protected function set_default_values_for_deleting(){
        parent::set_default_values_for_deleting();
        $this->set_default_values_for_edit();
    }
}
/**
 *	class for ajax , behold to Admin_sarung_larangan_kasus_add
*/
class Admin_sarung_larangan_kasus_ajax extends Admin_sarung_larangan_kasus_delete{
	public function __construct(){
		parent::__construct();
	}
	/**
	 *	url to ajax request
	 **/
	protected function set_url_ajax_santri($val){		$this->input ['ajax_url'] = $val;	}
	protected function get_url_ajax_santri(){		return $this->input['ajax_url'];	}

	protected function set_url_ajax_admind($val){		$this->input ['ajax_admind_url'] = $val;	}
	protected function get_url_ajax_admind(){		return $this->input['ajax_admind_url'];	}
	
	protected function set_url_ajax_pelanggaran($val){		$this->input ['ajax_pelanggaran_url'] = $val;	}
	protected function get_url_ajax_pelanggaran(){		return $this->input['ajax_pelanggaran_url'];	}
	
	protected function set_default_value(){
		parent::set_default_value();
		$this->set_url_ajax_santri( $this->get_url_admin_larangan_kasus("/ajaxchangeidsantri") );
		$this->set_url_ajax_admind( $this->get_url_admin_larangan_kasus("/ajaxchangeidadmind") );
		$this->set_url_ajax_pelanggaran( $this->get_url_admin_larangan_kasus("/ajaxchangeidpelanggaran") );
		//$this->set_default_values_for_add();
	}
	/**
	 *	get santri
	*/
	protected function get_js_ajax(){
		$click_function = sprintf('
		//! for typing on santri field
		function change_pelanggaran_handle(){
			var url 		= 	"%4$s";
			var postData = $("#%1$s").serializeArray();
            $.ajax({
			    url:url,
                data : postData,
				dataType: "json",
                success:function(result){
					$("#%2$s").val(result.%2$s);
					$("#%3$s").val(result.%3$s);
				}
			}); // end of ajax
			return false; // prevent further bubbling of event        			
		}',
		$this->get_name_form() ,
		$this->get_name_larangan() ,
		$this->get_name_session(),
		$this->get_url_ajax_pelanggaran() );
		
		//@ santri 
		$click_function .= sprintf('
		//! for typing on santri field
		function change_on_santri_area(url_local){
			var postData = $("#%1$s").serializeArray();
            $.ajax({
			    url:url_local,
                data : postData,
				dataType: "json",
                success:function(result){
					$("#%2$s").val(result.%2$s);
					$("#%3$s").val(result.%3$s);
				}
			}); // end of ajax
			return false; // prevent further bubbling of event        			
		}
        function change_santri_handle(){
			var url 		= 	"%4$s";
			$("#%6$s").val(-1);
			return change_on_santri_area( url );
        }
        function change_admind_handle(){
			var url 		= 	"%5$s";
			$("#%7$s").val(-1);
			return change_on_santri_area( url );
        }'
		,$this->get_name_form(), $this->get_name_alamat() , $this->get_name_santri()
		,$this->get_url_ajax_santri() , $this->get_url_ajax_admind()
		,$this->get_name_id_admind() , $this->get_name_id_santri()
		);
		//@ final
		$js = sprintf(
		'
		<script>	
		%1$s
		$(function() {
			addTextAreaCallback(document.getElementById("%2$s"), change_santri_handle	, 200 );
			addTextAreaCallback(document.getElementById("%3$s"), change_admind_handle	, 200 );
			addTextAreaCallback(document.getElementById("%4$s"), change_pelanggaran_handle	, 200 );
		})
		</script>
		',$click_function,
			$this->get_name_id_santri()  , $this->get_name_id_admind() , $this->get_name_id_larangan()
		);
		return $js;
	}
	/**
	 *	ajax wil go here , so do what you need
	*/
	public function anyAjaxchangeidsantri(){
		$this->set_default_values_for_add();
		$santri = new Santri_Model();
		$santri = $santri ->find( Input::get($this->get_name_id_santri() ));
		if($santri){
			$name = $santri->user->first_name ." " . $santri->user->second_name;
			$alamat = $santri->user->desa->kecamatan->nama ."-" . $santri->user->desa->nama;
		}
		else{
			$name = "There are no santri who has that id";
			$alamat = "There are no santri who has that id";
		}
		$result = array( $this->get_name_santri() => $name , $this->get_name_alamat() => $alamat );
		echo json_encode( $result); 
	}
	/**
	 *	ajax wil go here , so do what you need
	*/
	public function anyAjaxchangeidadmind(){
		$this->set_default_values_for_add();
		$id = Input::get( $this->get_name_id_admind());
		$user = new User_Model();
		$user = $user->find($id);		
		if(!$user){
			$name_santri = "There are no santri who has that id";
			$alamat = "There are no santri who has that id";
		}
		else{
			$name_santri = $user->first_name ." ". $user->second_name;
			$alamat = $user->desa->kecamatan->nama ."-". $user->desa->nama;
		}
		$result = array( $this->get_name_santri() => $name_santri , $this->get_name_alamat() => $alamat);
		echo json_encode( $result); 
	}
	/**
	 *	ajax wil go here , so do what you need
	*/
	public function anyAjaxchangeidpelanggaran(){
		$this->set_default_values_for_add();
		$id = Input::get( $this->get_name_id_larangan());
		$larangan = new Larangan_Meta_Model();
		$obj = $larangan->find($id);		
		if(!$obj){
			$name    = "There are no pelanggaran who has that id";
			$session = "There are no pelanggaran who has that id";
		}
		else{
			$name    = $obj->namaObj->nama;
			$session = $obj->sessionObj->nama;
		}
		$result = array( $this->get_name_larangan() => $name , $this->get_name_session() => $session);
		echo json_encode( $result); 
	}	
}
/**
 * root
*/
class Admin_sarung_larangan_kasus extends Admin_sarung_larangan_kasus_ajax{
    public function __construct(){
        parent::__construct();
    }
   /**
    *	return table
    */
    private function get_table($models){
        $row =  "";
        $count = 0 ; 
        //!button
		$button = sprintf('<a href="%1$s" class="btn btn-default btn-xs mar-rig-lit" role="button"> Edit </a><br>
                         <a href="%1$s" class="btn btn-default btn-xs mar-rig-lit" role="button"> Delete </a>',"");
        foreach($models as $model){
            $group = sprintf('
                         <small>%1$s %2$s<br>
                         %3$s-%4$s</small>
                         ',
					$model->userobj->first_name  ,
					$model->userobj->second_name ,
					$model->userobj->desa->kecamatan->nama,
                    $model->userobj->desa->nama
					
                );
            $short_hukuman = str_limit($model->metaobj->hukuman , 20 , "...");
            $short_hukuman = sprintf('<button class="btn btn-primary btn-xs "		
									onclick="select_handle(\'%1$s\')">%2$s</button>',$model->metaobj->hukuman , $short_hukuman);
            $row .= sprintf('<div id="row_%1$s" class="row like-table" >', $count);
            $row .= sprintf('<div class="col-xs-1 col-md-1">%1$s</div>',$model->id);
            $row .= sprintf('<div class="col-xs-1 col-md-1">%1$s</div>',$this->get_edit_delete_row($model->id));
            $row .= sprintf('<div class="col-xs-3 col-md-3">%1$s</div>',$model->metaobj->namaobj->nama);
            $row .= sprintf('<div class="col-xs-3 col-md-3">%1$s</div>',$group);
            $row .= sprintf('<div class="col-xs-2 col-md-2">%1$s</div>',$model->tanggal);
            $row .= sprintf('<div class="col-xs-2 col-md-2 text-left"><small>Created:%1$s <br> Updated:%2$s</small></div>',$model->created_at,$model->updated_at );
            $row .= "</div>";
            $count++;
        }
        return sprintf('
            <div class="row like-table-header">
            	<div class="col-xs-2 col-md-1 text-left" style="padding-left:0px;"><div >Id</div></div>
                <div class="col-xs-2 col-md-1 text-left" style="padding-left:0px;"><div >Mod</div></div>
            	<div class="col-xs-2 col-md-3 text-left" style="padding-left:0px;">Pelanggaran</div>
                <div class="col-xs-3 col-md-3 text-left" style="padding-left:0px;">Santri</div>
                <div class="col-xs-2 col-md-2 text-left" style="padding-left:0px;">Tanggal</div>
                <div class="col-xs-1 col-md-2 " style="padding-left:0px;">Made</div>
			</div>
            %1$s',
        $row);
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
        $filter = new Admin_sarung_larangan_kasus_helper_filter();
        $filter->set_default_value( $this->get_url_admin_larangan_kasus() );
        
        $model = $filter->set_get_filter_by_id($where , $model);
        $model = $filter->set_get_filter_by_name($where , $model);
        $model = $filter->set_get_filter_by_session($where , $model);
        $model = $filter->set_get_filter_by_jenis($where , $model);
		$model = $filter->set_get_filter_by_santri($where , $model);
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
			 	sprintf('Kasus %1$s' , $this->get_common_link())          ,
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
		$this->set_title('Kasus');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('larangan_kasus');
        //@
        $this->set_model_obj(new Larangan_Kasus_Model());
        
        $this->set_url_this_view( $this->get_url_admin_larangan_kasus() );
        $this->set_url_this_add ($this->get_url_admin_larangan_kasus("/eventadd") );
        $this->set_url_this_dele($this->get_url_admin_larangan_kasus("/eventdel" ));
        $this->set_url_this_edit($this->get_url_admin_larangan_kasus("/eventedit"));
        /*
        $this->set_url_this_dele($this->get_url_admin_sarung()."/ujis/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/ujis/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/ujis/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/ujis");
        */
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
}