<?php
/**
 *	root of dialog
*/
abstract class Admin_sarung_ujian_dialog{
	//@ escape from single quote
	protected function get_escape($val){
		return htmlentities(str_replace("'","\'",$val));
	}	
	protected $input  , $default_value;
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
	public function set_id_label_name($val) { $this->input ['id_name'] = $val;}
	public function get_id_label_name (){ return $this->input ['id_name'] ;}
	//@
	public  function set_url($val) { $this->input ['url_name_name'] = $val;}
	public function get_url(){ return $this->input ['url_name_name'] ;}
	//@
	protected  function set_button_name($val) { $this->input ['button_show_name'] = $val;}
	protected function get_button_name(){ return $this->input ['button_show_name'] ;}
	//@
	/**
	 *	name for class name
	*/
	public function set_kelas_name($val) { $this->input['kelas'] = $val ; }
	public function get_kelas_name(){ return $this->input['kelas'];}
	public function get_kelas_selected(){ return Input::get( $this->get_kelas_name() ) ;}
	/**
	 *	name for catatan text area
	*/
	public function set_catatan_name($val) { $this->input['catatan'] = $val ; }
	public function get_catatan_name(){ return $this->input['catatan'];}
	public function get_catatan_selected(){ return Input::get( $this->get_catatan_name()  ) ;}	
	/**
	 *	name for input id kalender
	*/
	public function set_id_kalender_name($val){$this->input ['kalender_name'] = $val ;}
	public function get_id_kalender_name(){ return $this->input ['kalender_name'] ;}
	/**
	 *	name for input session
	*/
	public function set_session_name($val){$this->input ['session_name_ujian'] = $val ;}
	public function get_session_name(){ return $this->input ['session_name_ujian'] ;}
	/**
	 *	name for input event
	*/
	public function set_event_name($val){$this->input ['event_name_ujian'] = $val ;}
	public function get_event_name(){ return $this->input ['event_name_ujian'] ;}
	/**
	 *	name for input session
	*/
	public function set_pelaksanaan_name($val) 	{ $this->input['pelaksanaan'] = $val ; }
	public function get_pelaksanaan_name()		{ return $this->input['pelaksanaan'];}
	public function get_pelaksanaan_selected()	{ return $this->get_value( $this->get_pelaksanaan_name() ) ;}
	/**
	 *	name for input nilai
	*/
	public function set_min_nilai_name($val) { $this->input['min_nilai'] = $val ; }
	public function get_min_nilai_name(){ return $this->input['min_nilai'];}
	public function get_min_nilai_selected(){ return $this->get_value( $this->get_min_nilai_name() ) ;}
	/**
	 *	name for input pelajaran
	*/
	public function set_pelajaran_name($val) { $this->input['pelajaran'] = $val ; }
	public function get_pelajaran_name(){ return $this->input['pelajaran'];}
	/**
	 *	name for id ujian , it is needed by ujian
	*/
	public function set_id_ujian_name($val) { $this->input['id_ujian_name_eidt'] = $val ; }
	public function get_id_ujian_name(){ return $this->input['id_ujian_name_eidt'];}

	/**
	 *	name for input score mutiplycation
	*/
	public function set_kali_nilai_name($val) { $this->input['kali_nilai'] = $val ; }
	public function get_kali_nilai_name(){ return $this->input['kali_nilai'];}
	public function get_kali_nilai_selected(){ return $this->get_value( $this->get_kali_nilai_name() ) ;}
	
	/**
	 *	get dialog
	*/
	protected function get_dialog($url){
		$form = $this->get_form();
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
							<h4 class="modal-title">%2$s</span></h4>
						</div>
						<div class="modal-body">
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
		$this->get_text_on_top() 	,
		$this->get_submit_name() 	,
		$form
		);
		return $hasil;
	}
	/**
	 *	set default value , init array
	*/
	public function set_default_value($class_name='delete_'){
		$this->set_dialog_name		('dialog_del_oke' 		. 	$class_name )	;
		$this->set_form_name		('form_name' 		. 	$class_name ) 	;
		$this->set_id_label_name	('id_label_dele' 	. 	$class_name )	;
		$this->set_submit_name		('submit_btn_de'	. 	$class_name )	;		
	}
	/**
	 *	Default value for input , because user will be lazy to type something from the beginning again
	 *	usually the value is from get or post
	*/
	public function set_default_value_for_input($data = array() ){
		$default = array($this->get_pelaksanaan_name() , $this->get_catatan_name() , $this->get_id_kalender_name(),
						 $this->get_session_name() 		,
						 $this->get_kelas_name()   		,
						 $this->get_pelajaran_name() 	, $this->get_kali_nilai_name(),
						$this->get_min_nilai_name()		,$this->get_event_name());
		//! if exist
		if(count($data) > 0){
			$this->default_value = $data ; 			
		}
		else{			
			foreach($default as $val){
				$this->default_value [$val] = "";
			}
		}

	}	
	/**
	 *	@parameter is array
	 *	form fr our project
	 *	return html form
	**/
	protected function get_form( $hidden = array() , $disable = ""){
		$hidden_result = "";
		foreach($hidden as $key => $val){
			$hidden_result .= Form::hidden( $key , $val  , array("id"=>$key) );
		}
		//@ id kalender
		$name = $this->get_id_kalender_name();
		$tmp = Form::text( $name , $this->default_value[$name] ,
						   array( 'id'=> $name , 'placeholder' => "Id kalender" ,'class'=>'form-control' , $disable => '' )
		);
		$id_kalender = FUNC\get_form_group($tmp);
		//@ session
		$name = $this->get_session_name();
		$tmp = Form::text( $name , '' , array( 'id'=> $name, 'placeholder' => "Session" ,'class'=>'form-control' , 'readonly' => '' ,
											  'selected'=>$this->default_value[$name] ));
		$session = FUNC\get_form_group($tmp);
		//@ event
		$name = $this->get_event_name();
		$tmp = Form::text( $name , '' , array( 'id'=> $name, 'placeholder' => "Event" ,'class'=>'form-control ' , 'readonly' => '' ,
											  'selected'=>$this->default_value[$name]));
		$event = FUNC\get_form_group($tmp);
		//@ pelajaran
		$name = $this->get_pelajaran_name();
		$tmp = FUNC\get_all_pelajaran_select(array( 'id'=> $name, 'class' => "selectpicker cold-md-6 " ,'name'=> $name ,
											   'selected' => $this->default_value[$name] ));
		$pelajaran = FUNC\get_form_group($tmp);
		//@ kelas
		$name = $this->get_kelas_name();
		$tmp = FUNC\get_kelas_select(array( 'id'=> $name, 'class' => "selectpicker cold-md-6 " ,'name'=> $name ,
										   'selected' => $this->default_value[$name] ));
		$kelas = FUNC\get_form_group($tmp);
		//@ minimum nilai
		$name = $this->get_min_nilai_name();
		$tmp = Form::text( $name , $this->default_value[$name] , array( 'id'=> $name, 'placeholder' => "Min Nilai" ,
                                                                       'class'=>'form-control '  , $disable => ''));
		$minimum = FUNC\get_form_group($tmp);
		//@ kali nilia
		$name = $this->get_kali_nilai_name();
		$tmp = Form::text( $name , $this->default_value[$name] , array( 'id'=> $name, 'placeholder' => "Kelipatan" ,
                                                                       'class'=>'form-control '  , $disable => ''));
		$kali_nilai = FUNC\get_form_group($tmp);
		//@ pelaksanaan
		$name = $this->get_pelaksanaan_name();
		$tmp = Form::text( $name , $this->default_value[$name] , array( 'id'=> $name, 'placeholder' => "Tanggal : Jam " ,
                                                                       'class'=>'form-control '  ,
                                                                       'title'=> 'Format date : 2015-01-31 jam:menit' , $disable => ''));
		$pelaksanaan = FUNC\get_form_group($tmp);
		
		//@ Catatan
		$name = $this->get_catatan_name();
		$tmp = sprintf('<textarea class="form-control" rows="2" id="%1$s" name="%1$s" placeholder="Catatan" %2$s  > </textarea>' , $name , $disable);
		$catatan = FUNC\get_form_group($tmp);
		$params_default = array(
			'url'		=> 	$this->get_url()			,
			'method'	=>	'post'						,
			'class' 	=>	'form-horizontal'			,
			'name'		=>	$this->get_form_name()		,
			'id'		=>	$this->get_form_name()		,
			'role' 		=> 	'form'
		);
		$form = Form::open( $params_default );			
			$form .= $id_kalender . $session . $event . $pelajaran.$kelas.$kali_nilai.$minimum .$pelaksanaan. $catatan.$hidden_result;
		$form .= Form::close();
		return $form;
	}
	/**
	 *	handle for changing ajax , it will be used both with add and delete
	**/
	public function get_handle_change(){
		$ujian_mdl = Kalender_Model::where('id','=',  Input::get($this->get_id_kalender_name()) );
		if($ujian_mdl->first()){
			$ujian_mdl = $ujian_mdl->first();
			$to_ajax = array( $this->get_session_name() => $ujian_mdl->session->nama ,
						 $this->get_event_name() => $ujian_mdl->event->nama);			
		}
		else{
			$to_ajax = array( $this->get_session_name() => "There are no id" ,
						 $this->get_event_name() => "There are no id");						
		}
		echo json_encode( $to_ajax); 
	}    
	/**
	 *	You have to overrride this
	*/
	abstract protected function get_text_on_top();
}
/**
 *	this class will show dialog to add , edit kalender
*/
class Admin_sarung_ujian_dialog_add extends Admin_sarung_ujian_dialog{
	protected function get_text_on_top(){
		return sprintf('Will add ujian');
	}
	/**
	 *	default values
	 *	return none
	*/
	public function set_default_value($class_name='add'){
		parent::set_default_value($class_name);
		$this->set_pelaksanaan_name	('pelaksanaan_name' . $class_name);
		$this->set_pelajaran_name	('pelajaran_name'	. $class_name);
		$this->set_event_name		('kelas'			. $class_name);
		$this->set_session_name('session_name'			. $class_name);
		$this->set_min_nilai_name('min_nilai'			. $class_name);
		$this->set_kali_nilai_name('kali_nilai'			. $class_name);
		$this->set_kelas_name('kelas_name'				. $class_name);
		$this->set_catatan_name('catatan'				. $class_name);
		$this->set_button_name("dialog_button_show"		. $class_name);
		$this->set_id_kalender_name('id_kalender_name'	. $class_name);
	}
	/**
	 *	button for showing dialog
	**/
	public function get_dialog_button($url){
		$this->set_url($url);
		$href 	=   sprintf('<input type="button" class="btn btn-primary btn-xs" name="%1$s" id="%1$s" Value="Add" >' , $this->get_button_name());
		return $href;
	}
	/**
	**/
	public function get_dialog_html(){
		return $this->get_dialog($this->get_url());
	}
	/**
	 *	url for changing id kalender
	*/
	public function get_url_cha_id_kal(){
		return $this->input ['jtkrueiruemn'];
	}
	public function set_url_cha_id_kal($val){
		$this->input ['jtkrueiruemn'] = $val;
	}
	/**
	 *	setting js for this dialog , we need it , of course
	 *	return js;
	*/
	public function set_get_js(){
		//@
		$change_function = sprintf('
		<script>
		//! for typing on santri field
        function change_kalender_add(){
			var url 		= 	"%1$s";
			var postData = $("#%2$s").serializeArray();
            $.ajax({
			    url:url,
                data : postData,
				dataType: "json",
                success:function(result){
					$("#%3$s").val(result.%3$s);
					$("#%4$s").val(result.%4$s);
				}
			}); // end of ajax
			event.preventDefault(); // disable normal form submit behavior
			return false; // prevent further bubbling of event        
        }
		</script>
		',$this->get_url_cha_id_kal() ,$this->get_form_name(), $this->get_session_name() , $this->get_event_name()
		);
		$js = $change_function;
		$js .= sprintf(
		'
		<script>			
			$(function() {
				addTextAreaCallback(document.getElementById("%5$s"), change_kalender_add	, 200 );
				$("#%1$s").click(function(){
					$("#%2$s").modal({keyboard: true});	
				});
				$("#%4$s").click(function(){
					$("#%3$s").submit();	
				});
				
			})		
		</script>' , $this->get_button_name() , $this->get_dialog_name() , $this->get_form_name(),$this->get_submit_name(),
		$this->get_id_kalender_name()
		);		
		return $js;		
	}
}

/**
 *	dialog for editing
*/
class Admin_sarung_ujian_dialog_edit extends Admin_sarung_ujian_dialog_add {
	protected function get_text_on_top(){
		return sprintf('Will edit ujian <span id="%1$s"></span>' , $this->get_id_label_name());
	}
	public function set_default_value($class_name = "edit"){
		$this->set_id_ujian_name	('id_ujian_name'	. $class_name);
		parent::set_default_value($class_name);
	}
	/**
	 *	@ overrride
	*/
	protected function get_form($hidden = array() , $disable  = ""){
		$params = array( $this->get_id_ujian_name() => "" );
		return parent::get_form($params);
	}
	/**
	 *	this button is not same with dialog add button
	 *	return button 
	*/
	public function get_dialog_button_edit($model){
		return sprintf('<button class="btn btn-primary btn-xs" onclick="show_edit_dialog(%1$s,%2$s,\'%3$s\',\'%4$s\',\'%5$s\',\'%6$s\'
					   ,\'%7$s\',\'%8$s\',\'%9$s\',\'%10$s\');">Edit</button> ' ,
							$model->id,
							$model->idkalender ,
							$model->kalender->session->nama	,
							$model->kalender->event->nama	,
							$model->pelajaran->nama			,
							$model->kelas->nama				,
							$model->kalinilai				,
							$model->minnilai				,
							$model->pelaksanaan				,
							$this->get_escape($model->catatan)
							);
	}
	/**
	 *	setting js for this dialog , we need it , of course
	 *	return js;
	*/
	public function set_get_js(){
		$function = sprintf('
				function show_edit_dialog(id , idpelajaran , session , event , pelajaran , kelas , kalinilai, minnilai,pelaksanaan,catatan){
					$("#%1$s").html(id);
					$("#%2$s").val(idpelajaran);
					$("#%3$s").val(session);
					$("#%4$s").val(event);
					
	                $("#%5$s").selectpicker("val", pelajaran );
	                $("#%6$s").selectpicker("val", kelas );
					$("#%7$s").val(kalinilai);
					$("#%8$s").val(minnilai);
					$("#%9$s").val(pelaksanaan);
					$("#%10$s").val(catatan);
					$("#%11$s").modal({keyboard: true});
					$("#%12$s").val(id);
				}
		',$this->get_id_label_name(),$this->get_id_kalender_name() , $this->get_session_name() , $this->get_event_name(),
		$this->get_pelajaran_name() , $this->get_kelas_name(),	$this->get_kali_nilai_name() , $this->get_min_nilai_name(),
		$this->get_pelaksanaan_name() , $this->get_catatan_name(),
		$this->get_dialog_name() , $this->get_id_ujian_name());
		$ajax = sprintf('
			//! for typing on santri field
			function change_kalender_edit(){
				var url 		= 	"%1$s";
				var postData = $("#%2$s").serializeArray();
			    $.ajax({
				    url:url,
			        data : postData,
					dataType: "json",
			        success:function(result){
						$("#%3$s").val(result.%3$s);
						$("#%4$s").val(result.%4$s);
					}
				}); // end of ajax
				event.preventDefault(); // disable normal form submit behavior
				return false; // prevent further bubbling of event        
			}
		',$this->get_url_cha_id_kal() , $this->get_form_name() , $this->get_session_name() , $this->get_event_name());
		$js = sprintf(
		'
		<script>
			%1$s
			%2$s
			$(function() {
				addTextAreaCallback(document.getElementById("%3$s"), change_kalender_edit	, 200 );
				$("#%4$s").click(function(){
					$("#%5$s").submit();
				});
			})
		</script>' , $function , $ajax ,$this->get_id_kalender_name(), $this->get_submit_name() , $this->get_form_name());
		return $js;		
	}
}
/**
 *	dialog for editing
*/
class Admin_sarung_ujian_dialog_delete extends Admin_sarung_ujian_dialog_add {
	protected function get_text_on_top(){
		return sprintf('Will delete ujian <span id="%1$s"></span>' , $this->get_id_label_name());
	}
	public function set_default_value($class_name = "edit"){
		$this->set_id_ujian_name	('id_ujian_name'	. $class_name);
		parent::set_default_value($class_name);
	}
	/**
	 *	@ overrride
	*/
	protected function get_form($hidden = array() , $disable = ""){
		$params = array( $this->get_id_ujian_name() => "" );
		return parent::get_form($params , "readonly");
	}
	/**
	 *	this button is not same with dialog add button
	 *	return button 
	*/
	public function get_dialog_button_delete($model){
		return sprintf('<button class="btn btn-danger btn-xs" onclick="show_delete_dialog(%1$s,%2$s,\'%3$s\',\'%4$s\',\'%5$s\',\'%6$s\'
					   ,\'%7$s\',\'%8$s\',\'%9$s\',\'%10$s\');">Delete</button> ' ,
							$model->id,
							$model->idkalender ,
							$model->kalender->session->nama	,
							$model->kalender->event->nama	,
							$model->pelajaran->nama			,
							$model->kelas->nama				,
							$model->kalinilai				,
							$model->minnilai				,
							$model->pelaksanaan				,
							$this->get_escape($model->catatan)
							);
	}
	/**
	 *	setting js for this dialog , we need it , of course
	 *	return js;
	*/
	public function set_get_js(){
		$function = sprintf('
				function show_delete_dialog(id , idpelajaran , session , event , pelajaran , kelas , kalinilai, minnilai,pelaksanaan,catatan){
					$("#%1$s").html(id);
					$("#%2$s").val(idpelajaran);
					$("#%3$s").val(session);
					$("#%4$s").val(event);

					
	                $("#%5$s").selectpicker("val", pelajaran );
	                $("#%6$s").selectpicker("val", kelas );
					$("#%7$s").val(kalinilai);
					$("#%8$s").val(minnilai);
					$("#%9$s").val(pelaksanaan);
					$("#%10$s").val(catatan);
					$("#%11$s").modal({keyboard: true});
					$("#%12$s").val(id);
				}
		',$this->get_id_label_name(),$this->get_id_kalender_name() , $this->get_session_name() , $this->get_event_name(),
		$this->get_pelajaran_name() , $this->get_kelas_name(),	$this->get_kali_nilai_name() , $this->get_min_nilai_name(),
		$this->get_pelaksanaan_name() , $this->get_catatan_name(),
		$this->get_dialog_name() , $this->get_id_ujian_name());
		$js = sprintf(
		'
		<script>
			%1$s
			$(function() {
				$("#%2$s").click(function(){
					$("#%3$s").submit();
				});
			})
		</script>' , $function ,  $this->get_submit_name() , $this->get_form_name());
		return $js;		
	}
}
