<?php
/**
 *		This class will suport add and delete , no edit option for this class instead , you just delete that item and begin to edit
 *		database table name: kelasisi
 *		parent of class is Admin_sarung_support in Admin_sarung_support.php
**/
class Admin_sarung_class_support extends Admin_sarung_support{
	public function __construct(){
		parent::__construct();
	}
	protected function set_table_form_name($val) {
		$this->input ['table_form_name'] = $val ;
	}
	protected function get_table_form_name(){
		return $this->input ['table_form_name'] ;
	}
	protected function set_default_value(){
		parent::set_default_value();
		$this->set_table_form_name('table_form');
	}
	protected function get_text_on_top($aktif){
        $href 	= 	sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );
        $aba 	= 	sprintf('<span class="glyphicon glyphicon-inbox"></span> Class Table');
		if($this->get_error_message() != "")
			$aba .= sprintf('
							<div style="clear:both;"></div>
							<div class="navbar-form navbar-right">
								<label class="x-small-font ">%1$s</label>
							</div>',$this->get_error_message());
		return $aba;
	}
	/**
     *  function usualy used for filtering result
     *  return only input html
    */
    protected function get_form_group($input){
		return sprintf('<div class="form-group ">
        					   %1$s
					   </div>' , $input );
	}
	protected function set_name_filter_name($val){
		$this->input ['filter_session'] = $val;
	}
	protected function get_name_filter_name(){
		return $this->input ['filter_session'];
	}
	/**
	 *	form group for horizontal form
	 *	return html 
	*/
	protected function get_group_for_hor_form($label , $input){
		$result = sprintf('
			<div class="form-group">
				<label for="%1$s" class="col-sm-2 control-label">%1$s</label>
				<div class="col-sm-10">					
					%2$s
				</div>
			</div>' , $label , $input);
		return $result;
	}	
	/**
	 *	make two array to one
	 *	return array
	*/
	protected function array_combine($modified_array , $modifiying_array){
		foreach($modifiying_array as $key => $val){
			$modified_array [$key] = $val;
		}
		return $modified_array;
	}	
}

/**
 *	this class only help add kelas class
*/
class Admin_sarung_class_helper{
	private $input = array();
	/*session in inser form*/
	public function set_ins_name_session($val){ $this->input ['insert_session'] = $val ;}
	public function get_ins_name_session(){return $this->input ['insert_session'] ;}
	
	public function set_ins_name_id($val) { $this->input ['insert_id'] = $val ; }
	public function get_ins_name_id() { return $this->input ['insert_id']; }
	
	public function set_ins_name_first($val) { $this->input ['insert_first'] = $val ; }
	public function get_ins_name_first() { return $this->input ['insert_first']; }
	
	public function set_ins_name_second($val) { $this->input ['insert_second'] = $val ; }
	public function get_ins_name_second() { return $this->input ['insert_second']; }
	
	public function set_ins_name_kelas($val) { $this->input ['insert_kelas'] = $val ; }
	public function get_ins_name_kelas() { return $this->input ['insert_kelas']; }
	
	public function set_ins_name_catatan($val) { $this->input ['insert_catatan'] = $val ; }
	public function get_ins_name_catatan() { return $this->input ['insert_catatan']; }

	public function set_ins_name_form($val) { $this->input ['insert_form'] = $val ; }
	public function get_ins_name_form() { return $this->input ['insert_form']; }

	public function set_ins_name_submit($val) { $this->input ['insert_submit'] = $val ; }
	public function get_ins_name_submit() { return $this->input ['insert_submit']; }
	
	public function set_del_name_form($val) { $this->input ['del_form'] = $val ; }
	public function get_del_name_form() { return $this->input ['del_form']; }

	public function set_del_name_id($val) { $this->input ['del_id_f_'] = $val ; }
	public function get_del_name_id() { return $this->input ['del_id_f_']; }
	
	public function set_del_name_idkelas($val) { $this->input ['del_name_f_'] = $val ; }
	public function get_del_name_idkelas() { return $this->input ['del_name_f_']; }
	
	public function set_del_name_idsantri($val) { $this->input ['del_idsantri_f_'] = $val ; }
	public function get_del_name_idsantri() { return $this->input ['del_idsantri_f_']; }

	public function js_func_name_to_del(){
		return  " delete_kelas ";
	}
	public function __construct(){
		$this->set_ins_name_first('first_name');
		$this->set_ins_name_second('second');
		$this->set_ins_name_id('id_santri_ins');
		$this->set_ins_name_kelas('kelas_ins');
		$this->set_ins_name_session('session_ins');
		$this->set_ins_name_catatan('catatan_ins');
		$this->set_ins_name_form('insert_form');
		$this->set_ins_name_submit('submit');
		$this->set_del_name_form('dele_form_add');
		$this->set_del_name_idkelas('dele_kelas_name');
		$this->set_del_name_idsantri('dele_santri_name');
		$this->set_del_name_id('id');
	}
	/**
	 *	get js
	 **/
	public function get_js(){
		$delete_submit = sprintf(
		'
			//! for submit delete
			function %1$s(id , idkelas , idsantri){				
				$("#%2$s").val(id);
				$("#%3$s").val(idkelas);
				$("#%4$s").val(idsantri);
				$("#%5$s").submit();
			};	
		', $this->js_func_name_to_del() ,
		$this->get_del_name_id() ,
		$this->get_del_name_idkelas() ,
		$this->get_del_name_idsantri(),
		$this->get_del_name_form()
		);
        $js = sprintf('<script>
			//! for showing dialog
            function select_handle(id , first_name , second_name , session , catatan){
				$("#myModal").modal({keyboard: true});
                //var url= "%1$s";
                $("#%1$s").val(id);
                $("#first_name").val(first_name +" "+ second_name);				
                $("#id").val(id);
                $("#%2$s").selectpicker("val", session );
            }
			//! for submit add 
			$(function() {
				$("#%3$s").click(function(){
					$("#%4$s").submit();
				});
			});
			//!
			%5$s
         ',
		 $this->get_ins_name_id()		,
		 $this->get_ins_name_session()	,
		 $this->get_ins_name_submit()	,
		 $this->get_ins_name_form()		,
		 $delete_submit
		 );
         $js.= "</script>";
		 return $js;
	}
}
/**
 *	this class will focus on adding kelas item
*/
class Admin_sarung_class extends Admin_sarung_class_support{
	private $helper;
	public function __construct(){
		parent::__construct();
	}
	/**
	 *	filter result by session`s name
	 *	return obj
	 **/
	private function set_get_filter_by_session($model  , & $where){
		$selected_session = $this->get_value( $this->get_session_select_name() );
		$where [ $this->get_session_select_name()] = $selected_session;
		return $model->where('session.nama','=',$selected_session);
				
	}
	/**
	 *	filter result by session`s name
	 *	return obj
	 **/
	private function set_get_filter_by_name($model  , & $where){
		$selected = $this->get_value( $this->get_name_filter_name() );
		$where [ $this->get_name_filter_name()] = $selected;
        return $model->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".$selected."%" ,
                                              "%".$selected."%" )
                                        );				
	}
	/**
	 *	get button for delete
	 *	return button html
	*/
	private function get_delete_button($val , $idSantri){
		return sprintf('<button title="Click to delete" class="btn btn-default btn-xs mar-rig-lit" onclick="%3$s(%4$s,\'%5$s\',\'%6$s\')"><b>%1$s</b><br>%2$s</button>',
			 $val->kelas_name , $val->session_name , $this->helper->js_func_name_to_del() ,
			 $val->id ,
			 $val->idkelas ,
			 $idSantri
		);		
	}
	/**
	 * 	give information about kelas where the user have been as well as link to delete
	 * 	return none
	 */
	private function get_user_data_kelas($model){
		$hasil = "";
		$santri = new Class_Model();
		$kelas = $santri->getkelassantribyid($model->id);
		foreach($kelas as $val){
			$hasil .= $this->get_delete_button($val , $model->id);
		}
		return $hasil;
	}
    /**
     * this will display all user information
     * Return string
    */
    protected function get_user_data_add($model , $col_array = array( "col-md-2" , "col-md-10 x-small-font" )){
        $date = new DateTime($model->awal);
        $nis = $date->format("y").str_pad($model->nis,$model->perkiraansantri,"0", STR_PAD_LEFT);
        $nis   = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nis: %1$s</span>' , $nis);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span>  %3$s<br>' ,
                        $model->first_name ,
                        $model->second_name ,
                        $nis);
        
        $foto  = sprintf('<img src="%1$s" class="small-img thumbnail">', $this->get_foto_file($model) );
        $jenis = sprintf('<span>%1$s</span>', $model->jenis);
        $email  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> Email: %1$s</span><br>', $model->email);

        $alamat = $ttl = "";
        //$id = 5;
        $sessi = sprintf('<span><span class="glyphicon glyphicon-user"></span> Session: %1$s</span>' , $model->nama);
        $nama = sprintf('<div class="row">
                        <div class="%6$s">%1$s</div>                        
                        <div class="%7$s">%2$s %3$s %4$s %5$s</div>
                        <div class="%7$s">%8$s</div>
                        </div>' , $foto  , $nama, $email, $alamat , $ttl  ,
						$col_array [0] , $col_array[1] ,
                        $sessi);
        return $nama;
	} 
	/**
	 **
	 **/
	public function set_default_value(){
		parent::set_default_value();
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Class register');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('kelasisi');
        //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/class/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/class/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/class/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/class");
		
		$this->set_model_obj( new Class_Model());
        //! special
        $this->set_foto_folder($this->base_url()."/foto");
	}
	/**
	 *	function that should be set for this class
	*/
	protected function set_default_values_for_add(){
		$this->set_session_select_name('select_filter_name_session');
		$this->set_name_filter_name('select_filter');
		$this->helper = new Admin_sarung_class_helper();
		$this->set_special_js_for_view();
	}
	/**
	 *	form to filter view
	 *	return string
	*/
	private function get_form_filter_for_add($params_form =array(), $addition_hidden_value = array() ){
		//! prepare
		$params_default = array(
			'url'		=> 	$this->get_url_this_add()							,
			'method'	=>	'get'												,
			'class' =>	'form-inline form-filter navbar-form navbar-left'		,
			'role' => 'form'
		);
		$new_params_form = $this->array_combine( $params_default , $params_form);
        $this->use_select();
		//! session
        $sessions = $this->get_session_select( array( 'class' => 'selectpicker' ,'selected' => $this->get_value($this->get_session_select_name())));
		$sessions = $this->get_form_group( $sessions );
		//!
		$tmp  = Form::text( $this->get_name_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Name' ,
                                                                       'Value' =>  $this->get_value($this->get_name_filter_name() ) ));
		$name_filter = $this->get_form_group( $tmp );		
		//! form 
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .= $name_filter . $sessions;
    		$hasil .= '<div class="form-group">';
        		$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    		$hasil .= '</div>';
        $hasil .= Form::close();
		return $hasil;
	}
	/**
	 *	remember this is global variabel
	*/
	private function add_fake_get($key , $val){
		$_GET[$key] = $val;
	}
	/**
	 *	return numerous hidden field that we need to keep it
	**/
	private function get_additional_hidden_field(){
		$hidden = "";
		$hidden .= Form::hidden($this->get_session_select_name(), $this->get_value($this->get_session_select_name()	));
		$hidden .= Form::hidden($this->get_name_filter_name() 	, $this->get_value($this->get_name_filter_name()	));
		if( isset($_GET['page'] )){
			$hidden .= Form::hidden('page' 	, $_GET['page']  );
		}
		return $hidden;
	}	
    /**
     *  @override
     *  default view for get methode
     *  return  @index()
    **/
    public final function getIndex(){
		return $this->getEventadd();
	}
    /**
     *  @override
     *  default view for get methode , we communicate with get , so if must , use fake get
     *  return  @index()
    **/
    public final function getEventadd($messages = ''){
		parent::getIndex();
		//!
		$this->set_default_values_for_add();
		//!
        $form = $this->get_form_filter_for_add(   );
        $wheres = array();		
        /* model */
        $events = new Santri_Model();
        $events = $events->get_santri_raw();
		//$events = $events->where('session.nama','=',$selected_session);
		$events = $this->set_get_filter_by_session($events , $wheres);
		$events = $this->set_get_filter_by_name($events , $wheres);
        $events = $events->orderBy('santri.id','DESC')->paginate(10);
        
        $information  = $form . $this->get_hidden_form_for_delete();
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>', $events->getFrom() , $events->getTotal());
        $table = $this->get_add_table($events);
        //!
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>			
            <div class="table_div">
                %2$s
                %3$s
            </div>
			%4$s',
			 	$this->get_text_on_top(1)            ,
   				$information                        ,
                $table.$this->get_form_insert()     ,
			 	$this->get_pagination_link($events  , $wheres)
			);
        $this->set_content(  $hasil );
		
        return $this->index();
    }
    /**
     *  input  model
     *  return table html
    */
    private function get_add_table($model ){
        $row = "";
        $count = 0 ; 
        foreach($model as $obj){
            $row .= sprintf('<tr id="row_%1$s">', $count);
                $row .= sprintf('<td><button class="btn btn-primary btn-xs"		
									onclick="select_handle(%1$s,\'%2$s\',\'%3$s\',\'%4$s\',\'%5$s\')">select_<br>%1$s</button>
                                </td>' ,
                                $obj->id , htmlentities(str_replace("'","\'",$obj->first_name)) ,
								htmlentities(str_replace("'","\'",$obj->second_name)), $obj->nama , $obj->catatan);
                //$row .= sprintf('<td>%1$s</td>' , $this->get_user_status_edit($obj));
                $row .= sprintf('<td>%1$s</td>' , $this->get_user_data_add($obj , array( "col-md-2" , "col-md-10 x-small-font" )) );
				$row .= sprintf('<td>%1$s</td>' , $this->get_user_data_kelas($obj) );
            $row .= "</tr>";
            $count++;
        }
        $hasil = sprintf('
                <table class="table table-striped table-hover" >
                	<tr class ="header">
                		<th>Id</th>
                        <th>User Data</th>
						<th>Kelas</th>		
                	</tr>
                	%1$s	
                </table>            
            ',
                $row                
            );
        return $hasil ; 
    }
	/**
	 *	get hidden form for delete
	**/
	private function get_hidden_form_for_delete(){
		//! nama awal + nama santri
		$params_default = array	(
			'url'		=> 	$this->get_url_this_dele()				,
			'method'	=>	'post'									,
			'class' 	=>	'form-horizontal'						,
			'name'		=>	$this->helper->get_del_name_form()		,
			'id'		=>	$this->helper->get_del_name_form()		,
			'role' 		=> 	'form'
		);
   		$form  = Form::open( $params_default ) ;
			$form .= Form::hidden($this->helper->get_del_name_id() , '' , array('id'=>$this->helper->get_del_name_id()) );//! id kelas isi
			$form .= Form::hidden($this->helper->get_del_name_idkelas() , '' , array('id'=>$this->helper->get_del_name_idkelas()) );//! id kelas
			$form .= Form::hidden($this->helper->get_del_name_idsantri() , '' , array('id'=>$this->helper->get_del_name_idsantri()) );//! id santri
			$form .= $this->get_additional_hidden_field();
		$form .= Form::close();
		return $form;
	}
	
	/**
	 *	form to insert santri into class
	 *	return html
	***/
	private function get_form_insert(){
		//$session = sprintf('<input type="text" class="form-control" id="%1$s">' , $this->get_ins);
		$attrb = array( 'name' => $this->helper->get_ins_name_session(), 'id' => $this->helper->get_ins_name_session() );
		$session = $this->get_session_select($attrb);
		$session = $this->get_group_for_hor_form('Session' , $session);
		//@
		$attrb = array( 'name' => $this->helper->get_ins_name_kelas(), 'id' => $this->helper->get_ins_name_kelas() );
		$kelas = $this->get_select_kelas($attrb);
		$kelas = $this->get_group_for_hor_form('Kelas' , $kelas);
		//@ id
		$name = $this->helper->get_ins_name_id();
		$id	 =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'ReadOnly'=>'' ));
		$id  = $this->get_group_for_hor_form("Id Santri",$id);
		//@ nama
		$name = $this->helper->get_ins_name_first();
		$nama =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'ReadOnly'=>'' ));
		$nama = $this->get_group_for_hor_form("Nama", $nama);
		//@ catatan
		$name = $this->helper->get_ins_name_catatan();
		$catatan =	Form::TextArea($name, '' , array('id' => $name , 'class' => 'form-control' ,'Rows'=>'5' ));
		$catatan = $this->get_group_for_hor_form("Catatan", $catatan);
		//@ additional
		$hidden = $this->get_additional_hidden_field();		
		//! nama awal + nama santri
		$params_default = array
		(
			'url'		=> 	$this->get_url_this_add()				,
			'method'	=>	'post'									,
			'class' 	=>	'form-horizontal'						,
			'name'		=>	$this->helper->get_ins_name_form()				,
			'id'		=>	$this->helper->get_ins_name_form()				,
			'role' 		=> 	'form'
		);
   		$form  = Form::open( $params_default ) ;
			$form .=	$session.$kelas.$id.$nama.$catatan;
			$form .= $hidden;
		$form 	.= Form::close();
		$result = sprintf('
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Add Kelas</h4>
					</div>
					<div class="modal-body">
						%1$s
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="%2$s">Insert</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->' , $form , $this->helper->get_ins_name_submit());
		return $result;
	}
	/**
	 *	add fakes for
	**/
	private function add_fakes_get_for_this($data){
		//! set fake get
		if( isset( $data['page'] )){
			$this->add_fake_get('page' , $data['page']);
		}
		$this->add_fake_get($this->get_session_select_name() , $data [$this->get_session_select_name()]);
		$this->add_fake_get($this->get_name_filter_name()    , $data [$this->get_name_filter_name()]);
	}
    /**
     *  no override
    */
    public final function postEventadd(){
        $this->set_default_values_for_add();
		$data = Input::all();
   		$rules = array( $this->helper->get_ins_name_id() => 'required|numeric' );
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventAdd($message);
		}
        else{
            $this->set_model_obj(new Class_Model() );
			$this->add_fakes_get_for_this($data);
            return $this->will_insert_to_db($data);
        }            
    }
	/**
	 *	@override
	 *	no child can override this function anymore
	 *	return postEventaddsucceded if succeded , getEventadd otherwise
	*/
	protected final  function Sarung_db_about_add($data , $edit = false , $values = array() ){
		//! data
        $id_user = $data [ $this->helper->get_ins_name_id()];
        $session = $data [ $this->helper->get_ins_name_session() ] ;
		$nama_kelas = $data [ $this->helper->get_ins_name_kelas() ];
        //! get idsession
		$session_obj = new Session_Model();
		$there = $session_obj->getfirst($session);
		//! get id class
		$kelas_obj = new Kelas_Model();
		$idkelas = $kelas_obj->getFirst( $nama_kelas )->id;
        //! main database
        $santri = new Class_Model();
        $santri->id             =   $data ['id']    ;//! see parent about this
        $santri->idsession      =   $there->id      ;
        $santri->idkelas		=   $idkelas        ;
		$santri->idsantri		=   $id_user        ;
        $santri->catatan        =   $data [ $this->helper->get_ins_name_catatan()];
        Log::info($id_user);
		Log::info($idkelas);
		Log::info($there->id);

        return $santri;
	}	
	/**
	 *	special js for this
	 *	return none
	**/
	private function set_special_js_for_view(){
		$js = $this->helper->get_js();
         $this->set_js($js);		
	}
	/**
	 ** override because mysql still delete class even though santri has examination score
	 ** which is relate to their class
	 ** return html
	**/
	protected function will_dele_to_db($data){
		$message = '<small>I`m sorry you cant edit this because i can`t find id for that class</small>';
		$data = Input::all();
		//@ check
		//@ find idkelas by kelas` name		
		$this->set_default_values_for_add();
		$this->add_fakes_get_for_this( $data );
		$idkelas	= $data [ $this->helper->get_del_name_idkelas()] ;
		$idsantri 	= $data [ $this->helper->get_del_name_idsantri()] ;
		if($idkelas > 0){
			//@ find examination that have relation with that class as well as santri id
			$ujian = new Class_Model();
			$objs = $ujian->getidujiansantri( $idkelas , $idsantri );
			$total = 0 ;
			foreach($objs as $obj){
				$total = $obj->total;
			}
			if( $total <= 0 ){
				//@ go on
				parent::will_dele_to_db($data);
				return $this->getEventadd();
			}
		}
		$this->set_error_message($message);
		return $this->getEventadd("fjdjjfkdjfkd");		
	}
	/**
	 *	failed to delete item
	 *	return $this->getEventdel;
	**/
	public function getEventdel($id = 0 , $message = ""){
		return $this->getEventadd( $id . $message);
	}
}