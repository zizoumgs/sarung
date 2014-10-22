<?php
/**
 *	this class will focus on adding kelas item
 *	it has relationship with below file
 *	Admin_sarung_ujis.php
*/
class Admin_sarung_ujis_add_helper{
    /**
     *  for store value
     *  
    **/
    protected $hidden_input;
    public function set_hidden_value($name , $val){
        $this->hidden_input []  = Form::hidden($name,$val, array( 'id' => $name));
    }
    public function get_hidden_value(){
        $input = "";
        foreach($this->hidden_input as $val){
            $input .= $val ; 
        }
        return $input;
    }
    
    protected $input; 
	protected function get_group_for_hor_form($label , $input){
		return FUNC\get_group_for_hor_form($label , $input);
	}
	/**
	 *	for find id url 
	*/
	public function set_url_to_find_id_ujian($val){
		$this->input ['find_url_id'] = $val ;
	}
	public function get_url_id_ujian(){
		return $this->input ["find_url_id"] ;
	}
	public function set_id_ujian_name($val){
		$this->input ['find_url_id_name'] = $val ;
	}
	public function get_id_ujian_name(){
		return $this->input ["find_url_id_name"] ;
	}
    
	/**
	 *	get and set id santri name	: this is and read only input text
	*/
	public function set_id_santri_name($val){
		$this->input ['id_santri_name'] = $val ;
	}
	public function get_id_santri_name(){
		return $this->input ['id_santri_name'];
	}
	/**
	 *	get and set first and second name	: this is and read only input text
	*/
	public function set_name_santri_name($val){
		$this->input ['name_santri'] = $val ;
	}
	public function get_name_santri_name(){
		return $this->input ['name_santri'] ;
	}
	/**
	 *	get and set nilai which is gottentby santri : this is input text
	 */
	public function set_nilai_name($val){
		$this->input ['nilai_santri_name'] = $val ;
	}
	public function get_nilai_name(){
		return $this->input ['nilai_santri_name'];
	}
	/**
	 *	get and set form for this
	**/
	public function set_form_name($val){
		$this->input['form_name_ajax'] = $val;
	}
	public function get_form_name(){
		return $this->input ['form_name_ajax'];
	}
	/**
	 *	get and set course/pelajaran name for this since we will insert it into database along with id ujian
	 */
	public function set_course_name($val){
		$this->input['course_name_'] = $val;
	}
	public function get_course_name(){
		return $this->input ['course_name_'] ; 
	}

	/**
	 *	get and set input field
	 */
	public function set_id_table_name($val){
		$this->input['id_kelas_table'] = $val;
	}
	public function get_id_table_name(){
		return $this->input ['id_kelas_table'] ; 
	}
    
	/**
	 *	get and set dialog
	 */
	public function set_dialog_table_name($val){
		$this->input['dialog_kelas_table'] = $val;
	}
	public function get_dialog_table_name(){
		return $this->input ['dialog_kelas_table'] ; 
	}
    

	/**
	 *	get and set name for this class , so every class is unique
	 */
	public function set_class_this_name($val){
		$this->input['kelas_kelas_table'] = $val;
	}
	public function get_class_this_name(){
		return $this->input ['kelas_kelas_table'] ; 
	}
	/**
	 *	get and set name for this class , so every class is unique
	 */
	public function set_dialog_button_name($val){
		$this->input['dialog_button_table'] = $val;
	}
	public function get_dialog_button_name(){
		return $this->input ['dialog_button_table'] ; 
	}
	/**
	 *	get and set name for this class , so every class is unique
	 */
	public function set_url_submit($val){
		$this->input['url_submit'] = $val;
	}
	public function get_url_submit(){
		return $this->input ['url_submit'] ; 
	}
    
	/**
	***     default value
	***/
	public function __construct( $init = true , $name_class = "unique"){
        $this->set_class_this_name($name_class);
        if($init)
            $this->init();
	}
    /**
    ***/
    public function init(){
        $ngamuk = $this->get_class_this_name();
        $this->set_dialog_button_name   ('dia_but_name'         .$ngamuk   );
		$this->set_id_ujian_name        ('id_helper_name'       .$ngamuk   );
		$this->set_id_santri_name       ('id_santri_ajax'       .$ngamuk   );
		$this->set_name_santri_name     ('name_santri_ajax'     .$ngamuk   );
		$this->set_nilai_name           ('nilai_name_ajax'      .$ngamuk   );
		$this->set_form_name            ('form_name_ajax'       .$ngamuk   );
		$this->set_id_table_name        ('kelas_name'           .$ngamuk   );
        $this->set_dialog_table_name    ('dialog_super_name'    .$ngamuk   );
        $this->set_course_name          ('ngamuk_name'          .$ngamuk   );
    }
    /**
     *  will give js function which will be used for add
    */
    public function get_click_function($obj){
		$row = sprintf('select_handle(%1$s,\'%2$s\',\'%3$s\',%4$s)' ,
			$obj->santri_id		,
			$obj->first_name 	,
			$obj->second_name	,
            $obj->id_from_outside_db       ,
			1
		);
		return $row;
    }
	/**
	 *	js with ajax
	*/
	public function get_js(){
		//@ to click 
        $click_function = sprintf('
			//! for showing dialog
            function select_handle(idsantri , first_name , second_name , id){
				$("#%1$s").modal({keyboard: true});
                $("#%2$s").val(idsantri);
                $("#%3$s").val(first_name +" "+ second_name);
				$("#%4$s_not_hidden").val(id);
            }
			',
            $this->get_dialog_table_name()  ,
			$this->get_id_santri_name()	    ,
			$this->get_name_santri_name()	,
			$this->get_id_ujian_name()
		 );
		
		//@ final
		$js = sprintf(
		'
		<script>
		%1$s
		$(function() {			
            $("#%4$s").focus();
			$( "#%2$s"  ).click(function () {
                $("#%3$s").submit();
			});
		})
		</script>
		',$click_function , $this->get_dialog_button_name(), $this->get_form_name() ,
        $this->get_id_ujian_name()
		);
		return $js;
	}
    /**
     *  get_form
     *  return function 
    */
	public function get_form( $url ,$with_hidden_value = true, $method = 'post'){
        
		//@ id table
        $this->set_url_submit($url);
		$name = $this->get_id_ujian_name();
		$id_table	=	Form::text($name."_not_hidden", '' , array('id' => $name."_not_hidden" , 'class' => 'form-control' ,'ReadOnly'=>'' ));
		$id_table  	= 	$this->get_group_for_hor_form("Id Ujian",$id_table);		
		//@ id santri
		$name = $this->get_id_santri_name();
		$id	 =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'ReadOnly'=>'' ));
		$id  = $this->get_group_for_hor_form("Id Santri",$id);

		//@ nama
		$name = $this->get_name_santri_name();
		$nama =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'ReadOnly'=>'' ));
		$nama = $this->get_group_for_hor_form("Nama", $nama);
		//@ nilai
		$name  = $this->get_nilai_name();
		$nilai =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ));
		$nilai = $this->get_group_for_hor_form("Nilai", $nilai);
        
		//@ gather all
		$element =	$id_table.$id.$nama.$nilai;
        //@ hidden value
        if($with_hidden_value)
            $element .= $this->get_hidden_value();
		//@ form 
		$params_default = array
		(
			'url'		=> 	$this->get_url_submit()      			,
			'method'	=>	$method									,
			'class' 	=>	'form-horizontal'						,
			'name'		=>	$this->get_form_name()		,
			'id'		=>	$this->get_form_name()		,
			'role' 		=> 	'form'
		);
   		$form	= Form::open( $params_default ) ;
			$form .= $element;
		$form 	.= Form::close();

		return $form;
	}    
    /**
     *  get dialog for add
    **/
    public function get_dialog($url_to){
        $form = $this->get_form($url_to);
		$result = sprintf('
		<div class="modal fade" id="%2$s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Add Nilai Santri</h4>
					</div>
					<div class="modal-body">
						%1$s
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="%3$s">Insert</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->' , $form ,
        $this->get_dialog_table_name() ,
        $this->get_dialog_button_name());//$this->helper->get_ins_name_submit());
		return $result;        
    }


}
/**
 *  main class of this documentation
*/
class Admin_sarung_ujis extends Admin_sarung_ujis_view{
	private $helper_add ;
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 	give information about examination
	 * 	return none
	 */
	private function get_user_data_ujian_add($model){
		$hasil = "";
		$hasil .= $this->get_button($model->kalender->event->nama		,   'Event');
		$hasil .= $this->get_button($model->kalender->session->nama 	,   'Session');
		$hasil .= $this->get_button($model->pelajaran->nama	 			,   'Pelajaran');		
		$hasil .= $this->get_button($model->kelas->nama 			    ,   'Kelas');
		$hasil .= $this->get_button($model->kalinilai	    			,   'Kelipatan');
		$hasil .= $this->get_button($model->pelaksanaan 				,   'Pelaksanaan');		
		return $hasil;
	}
	/**
	 * 	give information about kelas where the user is 
	 * 	return none
	 */
	private function get_user_data_kelas($model){
		$hasil = "";
		$hasil .= $this->get_button($model->kelas_name ."<br>". $model->session_name			 	, 'Kelas');
		return $hasil;
	}
    /**
     * this will display all user information
     * Return string
    */
    protected function get_user_data_add($model , $col_array = array( "col-md-2" , "col-md-10 x-small-font" )){
        $date = new DateTime($model->awal);
        $nis = $date->format("y").str_pad($model->nis,$model->perkiraansantri,"0", STR_PAD_LEFT);
        $nis   = sprintf('<span><span class="glyphicon glyphicon-certificate"></span> Nis: %1$s</span>' , $nis);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span>  %3$s' ,
                        $model->first_name 	    ,
                        $model->second_name 	,
                        $nis);
        $foto  			= sprintf('<img src="%1$s" class="small-img my-thumbnail">', $this->get_foto_file( $model ) );
        $jenis 			= sprintf('<span>%1$s</span>', $model->jenis);
		$id_user 		= sprintf('<span><span class="glyphicon glyphicon-user"></span> Id:%1$s</span>', $model->santri_id);
		$created_at  	= sprintf('<span><span class="glyphicon glyphicon-envelope"></span> %1$s</span>', $model->created_at);
		$updated_at  	= sprintf('<span><span class="glyphicon glyphicon-envelope"></span> %1$s</span>', $model->updated_at);
        //$id = 5;
        $nama = sprintf('<div class="row">
	                        <div class="%1$s">%3$s</div>                        
	                        <div class="%2$s">
								<div class="inline">%4$s %5$s %6$s %7$s</div>
								</div>
                        </div>' ,$col_array [0] , $col_array[1] ,
						$foto  , $nama,	$id_user,
						$created_at , $updated_at  
                        );
        return $nama;
	} 
	/**
	 ** 
	 **/
	public function set_default_value(){
		parent::set_default_value();
	}
	/**
	 *	function that should be set for this class
	**/
	protected function set_default_values_for_add(){
        $this->helper_add = new Admin_sarung_ujis_add_helper ();
		$this->helper_add->set_url_to_find_id_ujian( $this->get_url_admin_sarung()."/ujis/addfindid");
	}
	/**
	 *	function to handle find_id
	 *	return string
	*/
    public function getAddfindid(){        return $this->getEventadd();    }
	/**
	 *	form to filter
	 *	return form html
	**/
	private function get_form_filter_for_add($params_form =array(), $addition_hidden_value = array() ){
		//! prepare
		$params_default = array(
			'url'		=> 	$this->helper_add->get_url_id_ujian()   				,
			'method'	=>	'get'												,
			'class' 	=>	'navbar-form navbar-right'	,
			'role' 		=> 'search'
		);
        //@ begin
		$new_params_form = $this->array_combine( $params_default , $params_form);
        $this->use_select();
        $name = $this->helper_add->get_id_ujian_name();
        $find_id_field = sprintf('
							<div class="input-group ">
								<input name="%1$s" id="%1$s" type="text" class="form-control input-sm" title="Type Id Ujian Here Here"
                                placeholder="Type Id Ujian Here" Value="%2$s" >
								<span class="input-group-btn"  >
									<button type="submit" class="btn btn-success btn-sm" >
										<span class="glyphicon glyphicon-search"></span> &nbsp;
									</button>
								</span>						
							</div>
        ', $name , $this->get_value($name) );
		//@ form 
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .= $find_id_field;
        $hasil .= Form::close();
		return $hasil;
	}
    /**
     *  @override
     *  default view for get methode , we communicate with get , so if must , use fake get
     *  return  @index()
    **/
    public final function getEventadd($messages = ''){
        $array = array("id"=>"5");
        $wheres = $where_filter = array();
		$where_query = $lbl_pgnation = "" ;

		//!
		$this->set_default_values_for_add();
        $js = $this->helper_add->get_js();
   		$this->set_js($js);        
		//@        
        $form = $this->get_form_filter_for_add();
		//@ filter page
		$from = $this->get_value('page');
		if( $from == "" ){
			$from = 1 ;
		}
        $this->helper_add->set_hidden_value('page',$from);        
        $from--;
        $from *= 10;
        
        //@ get ujian model
        $tmp = $this->helper_add->get_id_ujian_name();
        $id_ujian = $this->get_value( $tmp );
        $ujian = Ujian_Model::find($id_ujian);
        //@ hidden value
        $wheres [$tmp]  = $id_ujian;
        $this->helper_add->set_hidden_value($tmp,$id_ujian);
        $this->helper_add->set_hidden_value($tmp,$id_ujian);
		//@ course/pelajaran
        if( $ujian )
            $this->helper_add->set_hidden_value($this->helper_add->get_course_name() , $ujian->idpelajaran);

        //@ model without limit
        $events = $this->get_model_obj();
        $events = $events->get_raw_query_add( $ujian);
		$this->pagenation = Paginator::make($events, count($events),  10 );
        $lbl_pgnation = FUNC\get_pagination_label($this->pagenation);
		//@ new model with limit
		$event = new Ujis_Model();
		$events = $event->get_raw_query_add($ujian , sprintf(' limit %1$s , 10 ', $from));
				
        $information  = $form ;
        $information .= sprintf('<div class="navbar-text navbar-left information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span>%1$s</div>',
								$lbl_pgnation);
        $table = $this->get_add_table($events ,$ujian);
        //!
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>			
            <div class="table_div like-table-pagination">
				<div class="row">
					%2$s
				</div>
                %3$s
            </div>
			%4$s',
			 	$this->get_text_on_top(1)            ,
   				$information                        ,
                $table.$this->get_form_insert()     ,
				FUNC\get_pagenation_link($this->pagenation , $wheres)
			);
        $this->set_content(  $hasil );
		
        return $this->index();
    }
    /**
	 *	table for this 
     *  @params:  model
     *  return table html
    */
    private function get_add_table($model , $second_model){
        $hasil = "";
        if(count($model) == 0){
            $hasil = sprintf('
            <br>
            <div class="alert alert-info" role="alert">
                It seems there are no result : please insert proper id on find id field  , and make sure there are santri in that class. You will not see anythings
                 if you didn`t insert any santri in the class
            </div>
            ');
        }
        else{
            $ujian = $second_model;
            $row = "";
            $count = 0 ; 
            foreach($model as $obj){
                $row .= sprintf('<div id="row_%1$s" class="row like-table" >', $count);
                    $row .= sprintf('
            			<div class="col-xs-2 col-md-1 ">
            				<button class="btn btn-primary btn-sm" onclick="%1$s">Add</button>
                        </div>' ,$this->helper_add->get_click_function($obj)            			
            			);
                    $row .= sprintf('<div class="col-xs-4 col-md-4">%1$s</div>' , $this->get_user_data_add($obj , array( "col-md-3" , "col-md-9 x-small-font" )) );
            		$row .= sprintf('<div class="col-xs-4 col-md-4">%1$s</div>' , $this->get_user_data_ujian_add($ujian) );				
            		$row .= sprintf('<div class="col-xs-2 col-md-3">%1$s</div>' , $this->get_user_data_kelas($obj) );
                $row .= "</div>";
                $count++;
            }            
            $hasil = sprintf('
				<div class="row like-table-header">
					<div class="col-xs-2 col-md-1 ">Id</div>
					<div class="col-xs-4 col-md-4 ">Santri</div>
					<div class="col-xs-4 col-md-4 ">Keterangan</div>
					<div class="col-xs-2 col-md-3 ">Class History</div>
				</div>
                	%1$s	
            ', $row                
            );
        }
        return $hasil ; 
    }
	/**
	 *	form to insert santri into class
	 *	return html
	***/
	private function get_form_insert(){
		//@ additional
		//$hidden = $this->get_additional_hidden_field();
		//$form = $this->helper_ajax->get_form( $this->get_url_this_edit() );
        return $this->helper_add->get_dialog( $this->get_url_this_add() , 'post');
	}
    /**
     *  no override
     *  url to catch post add submit
    */
    public final function postEventadd(){
        //@ important
        $this->set_default_values_for_add();
        //@
		$data = Input::all();
   		$rules = array( $this->helper_add->get_nilai_name() => 'required|numeric' );
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEventAdd($message);
		}
        else{
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
        $idujian    =   $data [ $this->helper_add->get_id_ujian_name()  ]   ;
        $idsantri   =   $data [ $this->helper_add->get_id_santri_name() ]   ;
        $nilai      =   $data [ $this->helper_add->get_nilai_name()]        ;
        $idpelajaran=   $data [ $this->helper_add->get_course_name()]       ;
        $obj = $this->get_model_obj();
        $obj->id            =   $data ['id']    ;
        $obj->idujian       =   $idujian        ;
        $obj->idsantri      =   $idsantri       ;
        $obj->nilai        =   $nilai       ;
        $obj->idpelajaran        =   $idpelajaran       ;
        return $obj;
	}	

}