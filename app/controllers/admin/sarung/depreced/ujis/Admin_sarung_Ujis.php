<?php
/**
 *		This class will suport add and delete , no edit option for this class instead , you just delete that item and begin to edit
 *		database table name: kelasisi
 *		parent of class is Admin_sarung_support in Admin_sarung_support.php
**/
class Admin_sarung_ujis_support extends Admin_sarung_support{
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
	protected function get_text_on_top($aktif = 0 ){
		$array = array('btn-default' , 'btn-default' , 'btn-default', 'btn-default');
		$array [$aktif] = 'btn-success';
		$href 	 = 	sprintf('<a href="%1$s" class="btn %2$s btn-xs mar-rig-lit" role="button"> View </a>' 	, $this->get_url_this_view(),$array [0] );
        $href 	.= 	sprintf('<a href="%1$s" class="btn %2$s btn-xs mar-rig-lit" role="button"> Add </a>' 	, $this->get_url_this_add()  ,$array [1]);
        $abas 	= 	sprintf('<span class="glyphicon glyphicon-inbox"></span> Class and santri Table ').$href;
		$aba   = sprintf('
			 <ul class="nav nav-pills">
				<li class="col-xs-9">
					<div class="input-group">
						%1$s
					</div>
				</li>
			</ul>
		',$abas);
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
	/**
	 *	form group for horizontal form
	 *	return html 
	**/
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
	**/
	protected function array_combine($modified_array , $modifiying_array){
		foreach($modifiying_array as $key => $val){
			$modified_array [$key] = $val;
		}
		return $modified_array;
	}	



}
/**
 **	this class will be used for ajax	: it supports only view
 **	and focus on updating
***/
class Admin_sarung_ujis_ajax_helper{
	/**
	 *	form group for horizontal form
	 *	return html 
	*/
	protected function get_group_for_hor_form($label , $input){
		return FUNC\get_group_for_hor_form($label , $input);
	}
	
	private $input = array();
	public function __construct(){
		
	}
	/**
	 *	this is line edit for idujian
	*/
	public function set_id_ujian_name($val){
		$this->input ['id_ujian_'] = $val ;
	}
	public function get_id_ujian_name(){
		return $this->input ['id_ujian_'] ;
	}
	
	/**
	 *	get and set filter session
	*/
	public function set_session_name($val){
		$this->input ['session_name'] = $val ;
	}
	public function get_session_name(){
		return $this->input ['session_name'] ;
	}
	/**
	 *	get and set filter ma-pel
	*/
	public function set_pelajaran_name($val){
		$this->input ['mapel_name'] = $val ;
	}
	public function get_pelajaran_name(){
		return $this->input ['mapel_name'] ;
	}
	/**
	 *	get and set filter class
	*/
	public function set_kelas_name($val){
		$this->input ['kelas_name'] = $val ;
	}
	public function get_kelas_name(){
		return $this->input ['kelas_name'] ;
	}
	/**
	 *	get and set event name
	*/
	public function set_event_name($val){
		$this->input ['event_name'] = $val ;
	}
	public function get_event_name(){
		return $this->input ['event_name'];
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
	 *	get and set input field
	 */
	public function set_id_table_name($val){
		$this->input['id_kelas_table'] = $val;
	}
	public function get_id_table_name(){
		return $this->input ['id_kelas_table'] ; 
	}
	/**
	 *	get and set area which will be changed by ajax through typing
	 */
	public function set_url($val){
		$this->input ['url_target'] = $val ;
	}
	public function get_url(){
		return $this->input ['url_target'] ;
	}
	
	/**
	 *	get and set area which will be changed by ajax through typing
	 */
	public function set_url_santri($val){
		$this->input ['url_target_santri'] = $val ;
	}
	public function get_url_santri(){
		return $this->input ['url_target_santri'] ;
	}
	

	/**
	 *	name of pelaksanaan
	**/
	public function set_pelaksanaan_name($val)	{	$this->input ['pelaksanaan_name'] = $val ;	}
	public function get_pelaksanaan_name()		{ 	return $this->input ['pelaksanaan_name'] ;	}
	/**
	 *	name of submit button
	**/
	public function set_submit_button_name($val)	{	$this->input ['submit_button_name'] = $val ;	}
	public function get_submit_button_name()		{ 	return $this->input ['submit_button_name'] ;	}
	/**
	 *	name of id ujian hidden : you cant see it
	**/
	public function set_id_table_label_name($val)	{	$this->input ['id_ujian_label_name'] = $val ;	}
	public function get_id_table_label_name()		{ 	return $this->input ['id_ujian_label_name'] ;	}

	/**
	 *	you should set this
	**/
	public function set_default_value($url_ujian , $url_santri , $name_of_class = "uclass"){
		//@ set values
		$this->set_session_name('session_name_ajax'		.$name_of_class);
		$this->set_kelas_name('kelas_name_ajax'			.$name_of_class);
		$this->set_pelajaran_name('pelajaran_name_ajax'	.$name_of_class);
		$this->set_event_name('event_name__ajax'		.$name_of_class);
		$this->set_id_santri_name('id_santri_ajax'		.$name_of_class);
		$this->set_name_santri_name('name_santri_ajax'	.$name_of_class);
		$this->set_nilai_name('nilai_name_ajax'			.$name_of_class);
		$this->set_form_name('form_name_ajax'			.$name_of_class);
		$this->set_id_ujian_name('id_ujian_name'		.$name_of_class);
		$this->set_pelaksanaan_name		('pelaksanaan_name'	.$name_of_class);
		$this->set_submit_button_name	('submit_button_name'	.$name_of_class);
		/*should be named as id*/
		$this->set_id_table_name('id');
		$this->set_id_table_label_name('id_label');
		
		$this->set_url($url_ujian);
		$this->set_url_santri($url_santri);
	}
	/**
	 *	return examination fields
	**/
	protected function get_element_to_ujian($test = ""){
		//@ session
		$name = $this->get_session_name();
		$session = Form::text($name, '' , array('id' => $name 	, 'class' => 'form-control' ,'ReadOnly'=>'' , 'VALUE' => $test ));
		$session = $this->get_group_for_hor_form('Session' , $session);
		//@ pelajaran
		$name = $this->get_pelajaran_name();
		$pelajaran = Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'ReadOnly'=>'' , 'VALUE' => Input::get($name)));
		$pelajaran = $this->get_group_for_hor_form('Pelajaran' , $pelajaran);
		//@ kelas
		$name = $this->get_kelas_name() ;
		$kelas = Form::text($name, '' , array('id' => $name 	, 'class' => 'form-control' ,'ReadOnly'=>'' , 'VALUE' => Input::get($name)));
		$kelas = $this->get_group_for_hor_form('Kelas' , $kelas);
		//@ event
		$name = $this->get_event_name();
		$event = Form::text($name, '' , array('id' => $name 	, 'class' => 'form-control' ,'ReadOnly'=>'' , 'VALUE' => Input::get($name)));
		$event = $this->get_group_for_hor_form('Event' , $event);
		//@ pelaksanaan
		$name = $this->get_pelaksanaan_name();
		$event = Form::text($name, '' , array('id' => $name 	, 'class' => 'form-control' ,'ReadOnly'=>'' , 'VALUE' => Input::get($name)));
		$event = $this->get_group_for_hor_form('Pelaksanaan' , $event);
		
		return $session.$pelajaran.$kelas.$event;
	}
	/**
	 *	js with ajax
	*/
	public function get_js(){
		//@
		$click_function = sprintf('
		//! for typing on santri field
        function change_santri_handle(){
			var url 		= 	"%1$s";
			var postData = $("#%2$s").serializeArray();
            $.ajax({
			    url:url,
                data : postData,
				dataType: "json",
                success:function(result){
					$("#%3$s").val(result.%3$s);
				}
			}); // end of ajax
			event.preventDefault(); // disable normal form submit behavior
			return false; // prevent further bubbling of event        
        }					   
		',$this->get_url_santri() , /*$this->get_id_santri_name()*/$this->get_form_name(), $this->get_name_santri_name()
		);
		$click_function .= sprintf('
		//! for typing on ujian field
        function change_ujian_handle(){
			var url = "%1$s";
            var postData = $("#%2$s").serializeArray();
            $.ajax({
			    url:url,
                data : postData,
				dataType: "json",
                success:function(result){
					$("#%3$s").val(result.%3$s);
					$("#%4$s").val(result.%4$s);
					$("#%5$s").val(result.%5$s);
					$("#%6$s").val(result.%6$s);
					$("#%7$s").val(result.%7$s);
				}
			}); // end of ajax
			event.preventDefault(); // disable normal form submit behavior
			return false; // prevent further bubbling of event        
        }					   
		',$this->get_url() , $this->get_form_name(), $this->get_session_name() , $this->get_event_name(),
		$this->get_pelajaran_name(), $this->get_pelaksanaan_name() , $this->get_kelas_name()
		);
		//@ to click 
		//! santri_id 		, 	first_name 	, second_name 	, 	course_name
		//! session_name	,	event_name	, pelaksanaan	,	kelas_name
		//!	nilai			,	id_ujian	,	id
        $click_function .= sprintf('
			//! for showing editing dialog 
            function select_handle_edit(	idsantri , first_name , second_name , course_name , session_name , event_name , pelaksanaan,
									kelas_name	,nilai , id_ujian , id ){
				$("#myModal").modal({keyboard: true});
                //var url= "%1$s";
                $("#%1$s").val(idsantri);				
                $("#%2$s").val(first_name +" "+ second_name);
				$("#%3$s").val(course_name);
				$("#%4$s").val(session_name);
				$("#%5$s").val(event_name);
				$("#%6$s").val(pelaksanaan);
				$("#%7$s").val(kelas_name);
				$("#%8$s").val(nilai);
				$("#%9$s").val(id_ujian);
				$("#%10$s").val(id);
				$("#%11$s").text(id);
            }
			',
			$this->get_id_santri_name()	,	$this->get_name_santri_name()	,	$this->get_pelajaran_name()	,	$this->get_session_name(),
			$this->get_event_name()		,	$this->get_pelaksanaan_name()	,	$this->get_kelas_name()		,	$this->get_nilai_name()	,
			$this->get_id_ujian_name()	,	$this->get_id_table_name() , $this->get_id_table_label_name()
		 );
		//@ final
		$js = sprintf(
		'
		<script>	
		%1$s		
		$(function() {
			addTextAreaCallback(document.getElementById("%2$s"), change_santri_handle	, 200 );
			addTextAreaCallback(document.getElementById("%3$s"), change_ujian_handle	, 200 );
			$("#%4$s").click(function(){				
				$("#%5$s").submit();
			});
		})
		</script>
		',$click_function,
		$this->get_id_santri_name()  , $this->get_id_ujian_name(),
		$this->get_submit_button_name() , $this->get_form_name()
		);
		return $js;
	}
	/**
	 *	js function to handle what happened after user click
	 *	return string
	*/
	public function get_click_function_edit($obj){
		$row = sprintf('select_handle_edit(%1$s,\'%2$s\',\'%3$s\',\'%4$s\',\'%5$s\',\'%6$s\',\'%7$s\',\'%8$s\',\'%9$s\',\'%10$s\',\'%11$s\')     ' ,
			//! santri_id 		, 	first_name 	, second_name 	, 	course_name
			//! session_name	,	event_name	, pelaksanaan	,	kelas_name
			//!	id
			$obj->santri_id		,
			$obj->first_name 	,
			$obj->second_name	,	/*3*/
			$obj->course_name	,
			$obj->session_name	,	/*5*/
			$obj->event_name	,
			$obj->pelaksanaan	,	/*7*/
			$obj->kelas_name	,
			$obj->nilai			,	/*9*/
			$obj->id_ujian		,
			$obj->id
		);
		return $row;
	}
	/**
	 *	ajax wil go here , so do what you need
	*/
	public function to_hande_ajax_ujian(){
		$ujian_mdl = Ujian_Model::find(  Input::get($this->get_id_ujian_name()) );
		if($ujian_mdl){
			//@ we will maintain to communicate with get ,
			$to_ajax = array();
			$to_ajax [ $this->get_pelajaran_name() ]  	=	$ujian_mdl->pelajaran->nama;
			$to_ajax [ $this->get_kelas_name() ]  		=	$ujian_mdl->Kelas->nama;
			$to_ajax [ $this->get_event_name() ]  		=	$ujian_mdl->kalender->event->nama;
			$to_ajax [ $this->get_session_name() ]  	=	$ujian_mdl->kalender->session->nama;
			$to_ajax [ $this->get_pelaksanaan_name() ]  =	$ujian_mdl->pelaksanaan;
		}
		else{
			$to_ajax [ $this->get_pelajaran_name() ]  	=	'No Data';
			$to_ajax [ $this->get_kelas_name() ]  		=	'No Data';
			$to_ajax [ $this->get_event_name() ]  		=	'No Data';
			$to_ajax [ $this->get_session_name() ]  	=	'No Data';
			$to_ajax [ $this->get_pelaksanaan_name() ]  =	'No Data';
		}
		echo json_encode( $to_ajax); 
	}
	/**
	 *	ajax wil go here , so do what you need
	*/
	public function to_hande_ajax_santri(){
		//@ gather value
		$id_santri 		= 	Input::get($this->get_id_santri_name()	);
		$session_name 	= 	Input::get($this->get_session_name()	);
		$kelas_name 	= 	Input::get($this->get_kelas_name()		);
		if( !is_numeric($id_santri) ){
			echo json_encode( array( $this->get_name_santri_name() => "There are non numeric id santri ") ); 
			return ;
		}
		$idsession 	= Session_Model::get_id_by_name($session_name);
		$idkelas 	=	Kelas_Model::get_id_by_name($kelas_name);		
		$obj = Class_Model::getobjbysessionnkelassantri( $idkelas , $idsession , $id_santri);
		//$obj = Santri_Model::find(  Input::get( $this->get_id_santri_name()) );		
		if( $obj->first() ){
			$obj = $obj->first();
			//@ name
			$to_ajax = array($this->get_name_santri_name() => $obj->santri->user->first_name ." ".$obj->santri->user->second_name );
		}
		else{
			$to_ajax = array($this->get_name_santri_name() => "There are no santri on that class");
		}
		echo json_encode( $to_ajax); 
	}
	/**
	 *	form to edit ujian santri
	 *	return html
	***/
	public function get_form_to_edit($url){
		//@ additional
		//$hidden = $this->get_additional_hidden_field();
		$form = $this->get_form( $url );
		$result = sprintf('
			<!-- Dialog for editing	-->
			<!-- ---------------------------------------------------------------------------------------------------------------------->						  
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title">Will edit or delete class with id :<span class="label label-info" id="%3$s"></span></h4>
					</div>
					<div class="modal-body">
						%1$s
					</div>
					<div class="modal-footer">
						
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-sm" id="%2$s">Submit Edit</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->' ,
		$form , $this->get_submit_button_name() , $this->get_id_table_label_name());
		return $result;
	}
	/**
	 *	return html form
	**/
	public function get_form($url){
		$ujian_element = $this->get_element_to_ujian();
		//@ id santri
		$name = $this->get_id_santri_name();
		$idsantri	 =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control'));
		$idsantri  = $this->get_group_for_hor_form("Id Santri",$idsantri);
		//@ nama
		$name = $this->get_name_santri_name();
		$nama =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'ReadOnly'=>'' ));
		$nama = $this->get_group_for_hor_form("Nama", $nama);
		//@ nilai
		$name  = $this->get_nilai_name();
		$nilai =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ));
		$nilai = $this->get_group_for_hor_form("Nilai", $nilai);
		//@ id ujian name
		$name  = $this->get_id_ujian_name();
		$id_ujian =	Form::text($name, '' , array('id' => $name , 'class' => 'form-control' ,'title'=>"Type your id ujian here"));
		$id_ujian = $this->get_group_for_hor_form("Id Ujian", $id_ujian);
		//@ id
		$id_table = Form::hidden($this->get_id_table_name() ,'',array('id'=>$this->get_id_table_name()));
		//@ gather all
		$element 	=	$id_ujian.$ujian_element;
		//@ combine
		$ajax_area  = $element.$idsantri.$nama.$nilai.$id_table;
		//@ form 
		$params_default = array
		(
			'url'		=> 	$url									,
			'method'	=>	'post'									,
			'class' 	=>	'form-horizontal'						,
			'name'		=>	$this->get_form_name()		,
			'id'		=>	$this->get_form_name()		,
			'role' 		=> 	'form'
		);
   		$form	= Form::open( $params_default ) ;
			$form .= $ajax_area;
		$form 	.= Form::close();

		return $form;
	}
}
/**
 *	this is class to help main class to delete easy : just support view
*/
class Admin_sarung_ujis_helper_delete{
	protected $input ;
	//@
	public function set_form_name($val){ $this->input ['delete_test'] = $val ;}
	public function get_form_name(){ return $this->input ['delete_test'] ;}
	//@
	public function set_submit_name($val){ $this->input ['submit_btn'] = $val ;}
	public function get_submit_name(){return $this->input['submit_btn'];}
	//@
	public function set_dialog_name($val){ $this->input ['dialog_name'] = $val; }
	public function get_dialog_name(){ return $this->input ['dialog_name'] ;}
	//@
	public function set_message_name($val) { $this->input ['message_name'] = $val;}
	public function get_message_name() { return $this->input ['message_name'] ;}
	//@
	public function set_id_label_name($val){ $this->input ['id_label'] = $val ;}
	public function get_id_label_name(){ return $this->input ['id_label'];}
	//@
	public function set_id_name($val) { $this->input ['id_name'] = $val;}
	public function get_id_name (){ return $this->input ['id_name'] ;}
	//@
	
	public function __construct(){
		
	}
	public function init(){
		
	}
	public function set_default_value($class_name='delete_'){
		$this->set_dialog_name		('dialog_del_oke' 		. 	$class_name )	;
		$this->set_form_name		('form_name' 		. 	$class_name ) 	;
		$this->set_id_label_name	('id_label_dele' 	. 	$class_name )	;
		$this->set_id_name			('id_name_dele' 	. 	$class_name )	;	
		$this->set_message_name		('message_name' 	. 	$class_name )	;
		$this->set_submit_name		('submit_btn_de'	. 	$class_name )	;
		
	}
	/**
	 *	get form
	*/
	public function get_form($url){
		$form_content = "";
		$form_content 	= 	Form::hidden($this->get_id_name() , '' , array('id' => $this->get_id_name()) );
		$form_content 	.=	sprintf('<div id="%1$s" ></div>' , $this->get_message_name());
		$params_default = array
		(
			'url'		=> 	$url									,
			'method'	=>	'post'									,
			'class' 	=>	'form-horizontal'						,
			'name'		=>	$this->get_form_name()		,
			'id'		=>	$this->get_form_name()		,
			'role' 		=> 	'form'
		);
   		$form	= Form::open( $params_default ) ;
			$form .= $form_content;
		$form 	.= Form::close();
		return $form;
	}
	/**
	 *	get dialog
	*/
	public function get_dialog($url){
		$form = $this->get_form($url);
		$hasil = sprintf('
			<!-- Dialog for deleteing	-->
			<!------------------------------------------------------------------------------------------------------------------------->
			<div class="modal fade" id="%1$s" name="%1$s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span>
								<span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title">Will Delete class with id : <span class="label label-info" id="%2$s"> </span></h4>
						</div>
						<div class="modal-body">
							<p>Below is information about someone who you want to delete, im sorry if it is little messy!</p>
							%4$s
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="%3$s">Save changes</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		' ,
		$this->get_dialog_name()	,
		$this->get_id_label_name() 	,
		$this->get_submit_name() 	,
		$form
		);
		return $hasil;
	}
	/**
	 *	return js function 
	*/
	public function get_js(){
		$js = sprintf(
		'
		<script>	
            function select_handle_delete(	idsantri , first_name , second_name , course_name , session_name , event_name , pelaksanaan,
									kelas_name	,nilai , id_ujian , id ){
				var content = "--------------------------------------------------------------------------------------------------<br>";			
				content += "The name is : " + first_name + " " + second_name +" <br>";
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "his id is 	: " + idsantri + " <br>";
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "id examination is : " + id_ujian + "</br> "
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "the course is " +course_name + "<br>";
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "Session 	: " + session_name + "<br>" ;
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "Event		: " + event_name + "<br>";
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "Pelaksanaan : " + pelaksanaan 	+ "<br>";
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "Kelas Name	: " + kelas_name	+	"<br>";
				content += "--------------------------------------------------------------------------------------------------<br>";
				content += "Nilai		: " + nilai			+	"<br>";		
				$("#%2$s").html(content);
				
				$("#%3$s").html(id);
				$("#%4$s").val(id);
				$("#%1$s").modal({keyboard: true});			
			}
			$(function() {
				$("#%5$s").click(function(){				
					$("#%6$s").submit();
				});
			})		
		</script>' , $this->get_dialog_name() , $this->get_message_name() , $this->get_id_label_name() , $this->get_id_name(),
		$this->get_submit_name() , $this->get_form_name()
		);
		return $js;
	}
	/**
	 *	js function to handle what happened after user click
	 *	return string
	*/
	public function get_click_function_delete($obj){
		$row = sprintf('select_handle_delete(%1$s,\'%2$s\',\'%3$s\',\'%4$s\',\'%5$s\',\'%6$s\',\'%7$s\',\'%8$s\',\'%9$s\',\'%10$s\',\'%11$s\')     ' ,
			//! santri_id 		, 	first_name 	, second_name 	, 	course_name
			//! session_name	,	event_name	, pelaksanaan	,	kelas_name
			//!	id
			$obj->santri_id		,
			$obj->first_name 	,
			$obj->second_name	,	/*3*/
			$obj->course_name	,
			$obj->session_name	,	/*5*/
			$obj->event_name	,
			$obj->pelaksanaan	,	/*7*/
			$obj->kelas_name	,
			$obj->nilai			,	/*9*/
			$obj->id_ujian		,
			$obj->id
		);
		return $row;
	}
}
/**
 *	this class will be filter result table , and it will be used by view class only (not add)
*/
class Admin_sarung_ujis_helper_filter{
	private $input ;
	/**
	 *	for session name
	*/
	public function set_session_select_name($val){
		$this->input ['filter_session_'] = $val;
	}
	public function get_session_select_name(){
		return $this->input ['filter_session_'];
	}
	/**
	 *	for kelas name
	*/
	public function set_kelas_select_name($val){
		$this->input ['filter_sessi_'] = $val;
	}
	public function get_kelas_select_name(){
		return $this->input ['filter_sessi_'];
	}
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
	public function set_pelajaran_select_name($val){
		$this->input ['filter_pelajaran'] = $val;
	}
	public function get_pelajaran_select_name(){
		return $this->input ['filter_pelajaran'];
	}
	/**
	 *	for event name
	*/
	public function set_event_select_name($val){
		$this->input ['filter_event'] = $val;
	}
	public function get_event_select_name(){
		return $this->input ['filter_event'];
	}
	private function get_value($name){
		return Input::get($name);
	}
	public function set_url($val){		$this->input ['url_this_'] = $val;	}
	public function get_url(){			return $this->input ['url_this_'] ;	}
	/**
	 *	filter result by session`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_session( & $where  , & $where_to_filter ,  $where_query ){
		$selected_session = $this->get_value( $this->get_session_select_name() );
		if($selected_session != "" && $selected_session !="All" ){
			$where [$this->get_session_select_name()] = $selected_session ;
			$where_to_filter [] = $selected_session;
			$where_query .= " and ses.nama = ? ";
		}
		return $where_query;
	}	
	/**
	 *	filter result by pelajaran`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_pelajaran( & $where ,  & $where_to_filter ,  $where_query  ){
		$selected_session = $this->get_value( $this->get_pelajaran_select_name() );
		if($selected_session != "" && $selected_session !="All"){
			$where [$this->get_pelajaran_select_name()] = $selected_session ;
			$where_to_filter [] = $selected_session;
			$where_query .= " and pel.nama = ? ";
		}
		return $where_query;				
	}
	/**
	 *	filter result by kelas`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_kelas( & $where , & $where_to_filter , $where_query  ){
		$selected_session = $this->get_value( $this->get_kelas_select_name() );
		if($selected_session != "" && $selected_session !="All"){			
			$where [$this->get_kelas_select_name()] = $selected_session ;
			$where_to_filter [] = $selected_session;
			$where_query .= " and kel.nama = ? ";
		}
		return $where_query;				
	}	
	/**
	 *	filter result by event`s name
	 *	return additonal string
	 **/
	public function set_get_filter_by_event( & $where , & $where_to_filter ,  $where_query   ){
		$selected_session = $this->get_value( $this->get_event_select_name() );
		if($selected_session != "" && $selected_session !="All"){
			$where [$this->get_event_select_name()] = $selected_session ;
			$where_to_filter [] = $selected_session ;
			$where_query .= " and eve.nama = ? ";
		}
		return $where_query;				
	}	

	/**
	 *	filter result by name`s name
	 *	return obj 
	 **/
	public  function set_get_filter_by_name( & $where , & $where_to_filter ,  $where_query ){
		$selected = $this->get_value( $this->get_name_filter_name() );
		if($selected != "" ){
			$where [ $this->get_name_filter_name()] = $selected;
			$where_to_filter [] = "%".$selected."%" ;
			$where_to_filter [] = "%".$selected."%" ;
			$where_query .= " and (first_name LIKE ? or second_name LIKE ?) ";
		}
		return $where_query;
	}
	/**
	 *	filter result by name`s name
	 *	return obj 
	 **/
	public function set_default_value(){
		$this->set_session_select_name('select_filter_name_session');
		$this->set_name_filter_name('select_filter');
		$this->set_kelas_select_name('kelas_filter');
		$this->set_pelajaran_select_name('pelajaran_filter');
		$this->set_event_select_name('event_filter');		
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
		//@ kelas
		$tmp = array( 'class' => 'selectpicker col-md-12' , 'name' => $this->get_kelas_select_name() ,'selected' => $this->get_value($this->get_kelas_select_name()));
        $kelas = FUNC\get_kelas_select( $tmp , array("All") );
		$kelas = FUNC\get_form_group( $kelas );
		//@ pelajaran
		$tmp = array( 'class' => 'selectpicker col-md-12' ,'name'=>$this->get_pelajaran_select_name(),'selected' => $this->get_value($this->get_pelajaran_select_name()));
        $pelajaran = FUNC\get_pelajaran_select( $tmp , array("All"));
		$pelajaran = FUNC\get_form_group( $pelajaran );
		//@ session
		$tmp = array( 'name' => $this->get_session_select_name(), 'id' => $this->get_session_select_name(),
					 'class' => 'selectpicker col-md-12' ,'selected' => $this->get_value($this->get_session_select_name()));
        $sessions = FUNC\get_session_select( $tmp , array("All") );
		$sessions = FUNC\get_form_group( $sessions );
		//@ event
		$tmp = array( 'class' => 'selectpicker col-md-12' , 'name' => $this->get_event_select_name()  ,'selected' => $this->get_value($this->get_event_select_name()));		
        $event = FUNC\get_event_ujian_select( $tmp , array("All") );
		$event = FUNC\get_form_group( $event );
		
		//@
		$tmp  = Form::text( $this->get_name_filter_name()  , '', array( 'class' => 'form-control input-sm' ,
                                                                       'placeholder' => 'Name' ,
                                                                       'Value' =>  $this->get_value($this->get_name_filter_name() ) ));
		$name_filter = FUNC\get_form_group( $tmp );		
		//@ form 
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .= $name_filter . $sessions.$kelas.$pelajaran.$event;
    		$hasil .= '<div class="form-group">';
        		$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    		$hasil .= '</div>';
        $hasil .= Form::close();
		return $hasil;
	}

}
/**
 *	main class function for this file
 *	this class focus on view , edit and delete
**/
class Admin_sarung_ujis_view extends Admin_sarung_ujis_support{
	private $helper_ajax , $helper_delete;
	private $filter ;
	public function __construct(){		parent::__construct();	}
	/**
	 *	url to ajax request
	 **/
	private function set_url_this_ajax($val){
		$this->input ['ajax_url'] = $val;
	}
	private function get_url_this_ajax(){
		return $this->input['ajax_url'];
	}
	/**
	 *	get button for delete
	 *	return button html
	*/
	protected function get_button($val , $title){
		 return sprintf('<button title="%2$s" class="btn btn-default btn-xs mar-rig-lit disabled">%1$s</button>' , $val , $title);
	}
	/**
	 * 	give information about examination
	 * 	return none
	 */
	private function get_user_data_ujian($model){
		$hasil = "";
		$hasil .= $this->get_button($model->event_name			 	, 'Event');
		$hasil .= $this->get_button($model->session_name			, 'Session');
		$hasil .= $this->get_button($model->course_name	 			, 'Pelajaran');		
		$hasil .= $this->get_button($model->kelas_name 				, 'Kelas');
		$hasil .= $this->get_button($model->kalinilai				,'Kelipatan');
		$hasil .= $this->get_button($model->pelaksanaan				,'Pelaksanaan');		
		return $hasil;
	}
	/**
	 * update total score from start of session until end of session or the date
	 * where examination is held
	 * i Think it is too complicated , abandon this function 
	 * return none
	**/
	protected function update_total_nilai_santri(){
		return 0;
		//@ you must have id santri and id ujian
		
		//@ find start of session for that ujian 
		
		//@ find end of session or the date where examination is held(in pelaksanaan in ujian`s table)
		
		//@	right now you should have list of ujian in particulat session
		
		//@ get ujian id and update it , of course for that santri
		
	}
	
	/**
	 * 	give information about santri score
	 * 	return none
	 */
	private function get_user_data_nilai($model){
        $hasil  = sprintf('<b>%1$s</b>', $model->nilai );
		return $hasil;
	}
    /**
     * this will display all user information
     * Return string
    */
    protected function get_user_data_view($model , $col_array = array( "col-md-2" , "col-md-10 x-small-font" )){
        $date = new DateTime($model->awal);
        $nis = $date->format("y").str_pad($model->nis,$model->perkiraansantri,"0", STR_PAD_LEFT);
        $nis   = sprintf('<span><span class="glyphicon glyphicon-certificate"></span> Nis: %1$s</span>' , $nis);
        $nama = sprintf('<span><span class="glyphicon glyphicon-user"></span> Nama: %1$s %2$s</span>  %3$s' ,
                        $model->first_name 	,
                        $model->second_name 	,
                        $nis);
        $foto  = sprintf('<img src="%1$s" class="small-img my-thumbnail">', $this->get_foto_file( $model ) );
        $jenis = sprintf('<span>%1$s</span>', $model->jenis);
        $email  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> Id: %1$s</span>', $model->santri_id);

		$created_at  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> %1$s</span>', $model->created_at);
		$updated_at  = sprintf('<span><span class="glyphicon glyphicon-envelope"></span> %1$s</span>', $model->updated_at);
        //$id = 5;
        $nama = sprintf('<div class="row">
	                        <div class="%6$s">%1$s</div>                        
	                        <div class="%7$s"><div class="inline">%2$s %3$s %4$s %5$s</div></div>
	                        
                        </div>' , $foto  , $nama, $email, $created_at , $updated_at  ,
						$col_array [0] , $col_array[1] 
                        );
        return $nama;
	} 
	/**
	 **	automatic executed by Admin_sarung`s contructor
	 **	return none
	 **/
	public function set_default_value(){
		parent::set_default_value();
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Ujian Santri register');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('ujiansantri');
        //! for url
        $this->set_url_this_dele($this->get_url_admin_sarung()."/ujis/eventdel" );
        $this->set_url_this_edit($this->get_url_admin_sarung()."/ujis/eventedit");
        $this->set_url_this_add ($this->get_url_admin_sarung()."/ujis/eventadd" );
        $this->set_url_this_view($this->get_url_admin_sarung()."/ujis");		
		//@ 
		$this->set_model_obj( new Ujis_Model());
        //! special
        $this->set_foto_folder($this->base_url()."/foto");
	}
	/**
	 *	create class dialog for delete
	 *	return none
	**/
	public function init_dialog_delete(){
		$this->helper_delete = new Admin_sarung_ujis_helper_delete();
		$this->helper_delete->set_default_value();
		$js = $this->helper_delete->get_js();
		$this->set_js($js);

	}
	/**
	 *	created dialog class for editing
	 *	return none
	*/
	private function init_dialog_edit(){
		$this->helper_ajax = new Admin_sarung_ujis_ajax_helper( );
		$this->helper_ajax->set_default_value( $this->get_url_this_ajax()."/ujian" , $this->get_url_this_ajax()."/santri");
		$js = $this->helper_ajax->get_js();
		$this->set_js($js);
	}
	/**
	 *	init class filter for filtering result
	*/
	private function init_filter(){
		$this->filter = new Admin_sarung_ujis_helper_filter();
		$this->filter->set_default_value();
		$this->filter->set_url( $this->get_url_this_view());
	}
	/**
	 *	function that should be set for this class
	*/
	protected function set_default_values_for_view(){
		$this->set_url_this_ajax($this->get_url_admin_sarung()."/ujis/change");
		
		//@ for updating
		$this->init_dialog_edit();
		//@ for deleting
		$this->init_dialog_delete();
		//@ filter
		$this->init_filter();
	}
	/**
	 *	function to handle ajax request	,	will change ujian
	 *	return string
	*/
	public function getChange($to_where){
		$this->set_default_values_for_view();
		if( $to_where == "santri")
			$this->helper_ajax->to_hande_ajax_santri();
		else
			$this->helper_ajax->to_hande_ajax_ujian();

	}
	/**
	 *	function to handle ajax request , will change santri
	 *	return string
	*/
	public function getChangesantri(){
		$this->set_default_values_for_view();
	}
	
	/**	remember this is global variabel */
	private function add_fake_get($key , $val){		FUNC\add_fake_get($key , $val);	}
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
	 *	table for this 
     *  @params:  model
     *  return table html
    */
    private function get_table_view($model ){
        $row = "";
        $count = 0 ; 
        foreach($model as $obj){
            $row .= sprintf('<div id="row_%1$s" class="row like-table" >', $count);
                $row .= sprintf('
					<div class="col-xs-2 col-md-1 ">
						<div class="btn-group-vertical">
							<button class="btn btn-primary btn-xs" onclick="%1$s">Edit</button>
							<button class="btn btn-primary btn-xs" onclick="%2$s">Delete</button>
						</div>
                    </div>' ,
					$this->helper_ajax->get_click_function_edit($obj) ,
					$this->helper_delete->get_click_function_delete($obj) ,
					$obj->id
					);
                $row .= sprintf('<div class="col-xs-4 col-md-4">%1$s</div>' , $this->get_user_data_view($obj , array( "col-md-3" , "col-md-9 x-small-font" )) );
				$row .= sprintf('<div class="col-xs-4 col-md-5">%1$s</div>' , $this->get_user_data_ujian($obj) );				
				$row .= sprintf('<div class="col-xs-2 col-md-2">%1$s</div>' , $this->get_user_data_nilai($obj) );
            $row .= "</div>";
            $count++;
        }
        $hasil = sprintf('
                	%1$s	
            ',
                $row                
            );
        return $hasil ; 
    }
	/**
	 *	form to edit 
	 *	return html dialog
	***/
	private function get_form_edit(){		return $this->helper_ajax->get_form_to_edit( $this->get_url_this_edit());	}
	/**
	 *	form to delete
	 *	return html dialog
	***/
	private function get_form_delete(){		return $this->helper_delete->get_dialog( $this->get_url_this_dele());	}	
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
     *  @override
     *  default view for get methode
     *  return  @index()
    **/
    public final function getIndex(){
		parent::getIndex();
		//!
		$this->set_default_values_for_view();
		//! init form for filter
		$this->use_select();
        $form = $this->filter->get_form_filter_for_view(   );
        $wheres = $where_filter = array();
		$where_query = "" ;
		//@ filter by session
		$where_query = $this->filter->set_get_filter_by_session		($wheres , $where_filter	, $where_query );
		$where_query = $this->filter->set_get_filter_by_pelajaran	($wheres , $where_filter	, $where_query 	);
		$where_query = $this->filter->set_get_filter_by_kelas		($wheres , $where_filter	, $where_query 	);
		$where_query = $this->filter->set_get_filter_by_event		($wheres , $where_filter	, $where_query 	);
		$where_query = $this->filter->set_get_filter_by_name		($wheres , $where_filter	, $where_query 	);
        //@ model without limit
        $events = $this->get_model_obj();
        $events = $events->get_raw_query( $where_filter , $where_query);
		$this->pagenation = Paginator::make($events, count($events),  10 );
		//@ filter page
		$from = $this->get_value('page');
		if( $from == "" )
			$from = 0 ;
		//@ new model with limit 		
		$event = new Ujis_Model();
		$events = $event->get_raw_query( $where_filter, $where_query , sprintf(' limit %1$s , 10 ', $from));
				
        $information  = $form ;
        $information .= sprintf('<div class="navbar-text navbar-right information-box medium-font">
                                <span class="glyphicon glyphicon-info-sign "></span> Show %1$s of %2$s</div>',
								$this->pagenation->getFrom() , $this->pagenation->count()	);
        $table = $this->get_table_view($events);
		//@ dialog
		$dialog = $this->get_form_edit().$this->get_form_delete();
        //!
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			<div> %5$s </div>
            <div class="table_div like-table-pagination">
				<div class="row">
					%2$s
				</div>
				<div class="row like-table-header">
					<div class="col-xs-2 col-md-1 ">Id</div>
					<div class="col-xs-4 col-md-4 ">Santri</div>
					<div class="col-xs-4 col-md-5 ">Keterangan</div>
					<div class="col-xs-2 col-md-2 ">Nilai</div>
				</div>
                %3$s
            </div>
			%4$s',
			 	$this->get_text_on_top()            ,
   				$information                        ,
                $table.$dialog    ,
				FUNC\get_pagenation_link($this->pagenation , $wheres),
				$this->get_error_message()
			 	//$this->get_pagination_link($events  , $wheres)
			);
        $this->set_content(  $hasil );
		
        return $this->index();
	}
    /**
     *  @override
     *  first html if you want to edit from database
     *  return  getIndex()
    **/
    public final function getEventedit($id , $values = array() , $message = ""){		return $this->getIndex();	}
    /**
     *  @override
     *  first html if you want to delete 
     *  return  getIndex()
    **/
	public function getEventDel($id , $message){	return $this->getIndex();	}
    /**
      *  after you click submit from delete from , you will go to here in order to delete from database
      *  return  will_dele_to_db if success and blank() if fail
    **/
    public function postEventdel(){
		$this->set_purpose( self::DELE);
		$this->init_dialog_delete();
		//@ we should override this
		$id = Input::get($this->helper_delete->get_id_name());
        if($id > 0 ){
			$data = Input::all();
			$data ['id'] = $id;
			return $this->will_dele_to_db($data);
        }
        else{
            echo "You tried to put non positif id ";
        }
    } 
	/**
	 **	function to get column which will edit db
	 **	return @ Sarung_db_about
	**/	
	protected final function Sarung_db_about_edit($data , $values = array() ){
		//! data
        $idujian    	=   $data [ $this->helper_ajax->get_id_ujian_name()  ]   ;
        $idsantri   	=   $data [ $this->helper_ajax->get_id_santri_name() ]   ;
        $nilai      	=   $data [ $this->helper_ajax->get_nilai_name()]        ;
        $pelajaran	=   $data [ $this->helper_ajax->get_pelajaran_name()]       ;
		$obj_pel	=	new Pelajaran_Model();
		$idpelajaran	=	$obj_pel->get_id_by_name($pelajaran);
        $obj = $this->get_model_obj()->find($data ['id']);
        $obj->idujian       	=   $idujian        ;
        $obj->idsantri      	=   $idsantri       ;
        $obj->nilai        		=   $nilai       ;
        $obj->idpelajaran       =   $idpelajaran       ;
        return $obj;		
	}	
	/**
	 *	return array
	 *	will be called in add , edit function 
	*/
    protected final function get_rules($with_id = false){
		$this->set_default_values_for_view();
		$rules = array();
        $rules  [$this->helper_ajax->get_id_santri_name()	] = "required|numeric" ;
		$rules  [$this->helper_ajax->get_id_ujian_name()	] = "required|numeric" ;
		$rules  [$this->helper_ajax->get_nilai_name()		] = "required|numeric" ;
        $rules ['id'] = "required|numeric" ; 
        return $rules;
    }
	
}

