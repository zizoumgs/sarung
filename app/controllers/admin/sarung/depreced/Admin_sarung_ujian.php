<?php
/**
 *  This class is for examination
 *  parent of class:
 *  	Admin_sarung_ujian_crud.php
 *  
*/
/**
 *	this class will be filter result table , and it will be used by view class only (not add)
*/
class Admin_sarung_ujian_filter{
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
	public function set_url($val){		$this->input ['url_this_bla'] = $val;	}
	public function get_url(){			return $this->input ['url_this_bla'] ;	}
	/**
	 *	filter result by session`s name
	 *	return new or old model
	 **/
	public function set_get_filter_by_session( & $where  , $model){
		$selected_session = $this->get_value( $this->get_session_select_name() );
		$where [$this->get_session_select_name()] = $selected_session ;
		if($selected_session != "" && $selected_session !="All" ){			
			return $model->sessionname($selected_session);
		}
		return $model;
	}	
	/**
	 *	filter result by pelajaran`s name
	 *	return new or old model
	 **/
	public function set_get_filter_by_pelajaran( & $where ,  $model ){
		$selected_session = $this->get_value( $this->get_pelajaran_select_name() );
		$where [$this->get_pelajaran_select_name()] = $selected_session ;
		if($selected_session != "" && $selected_session !="All"){			
			return $model->pelajaranname($selected_session);
		}
		return $model;				
	}
	/**
	 *	filter result by kelas`s name
	 *	return new or old model
	 **/
	public function set_get_filter_by_kelas( & $where , $model  ){
		$selected_session = $this->get_value( $this->get_kelas_select_name() );		
		$where [$this->get_kelas_select_name()] = $selected_session ;
		if($selected_session != "" && $selected_session !="All"){
			return $model->kelasname($selected_session);
		}
		return $model;				
	}	
	/**
	 *	filter result by event`s name
	 *	return new or old model
	 **/
	public function set_get_filter_by_event( & $where , $model  ){
		$selected_session = $this->get_value( $this->get_event_select_name() );
		$where [$this->get_event_select_name()] = $selected_session ;
		if($selected_session != "" && $selected_session !="All"){						
			return $model->eventname($selected_session);
		}
		return $model;				
	}	
	/**
	 *	filter result by name`s name
	 *	return obj 
	 **/
	public function set_default_value($name = "_fil_"){
		$this->set_session_select_name('session' . $name);
		$this->set_kelas_select_name('kelas' . $name);
		$this->set_pelajaran_select_name('mapel' . $name);
		$this->set_event_select_name('event' . $name);
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
		//@ form 
   		$hasil  = Form::open( $new_params_form) ;
            $hasil .=  $sessions.$kelas.$pelajaran.$event;
    		$hasil .= '<div class="form-group">';
        		$hasil .= Form::submit('Filter' , array( 'class' => 'btn btn-primary btn-sm' ) );
    		$hasil .= '</div>';
        $hasil .= Form::close();
		return $hasil;
	}

}
/**
 *	this class is just for view
*/
class Admin_sarung_ujian extends Admin_sarung_ujian_dele{
	public function __construct(){
		parent::__construct();
	}
	/**
	 *	init class filter for filtering result
	*/
	private function init_filter(){
		$this->filter = new Admin_sarung_ujian_filter();
		$this->filter->set_default_value();		
		$this->filter->set_url( $this->get_url_admin_sarung()."/ujian" );
	}		
    /**
	 * 	@override
     *  priority 1 
     *  Default view for this class
     *  return @index()
    */    
    public function getIndex(){
		//@ init all dialog
		$this->init_all_dialog();
		//@ dialog button
		$dialog_button 		= 	$this->dialog->get_dialog_button( $this->get_url_this_add() );
		$dialog_button_edit = 	$this->dialog_edit->get_dialog_button( $this->get_url_this_edit() );
		//@
		$this->use_select();
		$this->init_filter();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $row = "";
        $session = $this->get_model_obj();
        $wheres = array();
		$session = $this->filter->set_get_filter_by_session		($where , $session);
		$session = $this->filter->set_get_filter_by_kelas		($where , $session);
		$session = $this->filter->set_get_filter_by_pelajaran	($where , $session);
		$session = $this->filter->set_get_filter_by_event		($where , $session);
        $sessions = $session->orderBy('updated_at','DESC')->paginate(15);
        foreach($sessions as $event){
            $row .= "<tr>";
                $row .= sprintf('<td>%1$s</td>' , $event->id);
                $row .= sprintf('<td>%1$s%2$s</td>', $this->dialog_edit->get_dialog_button_edit($event),
								$this->dialog_del->get_dialog_button_delete( $event));
                $row .= sprintf('<td>%1$s</td>' , $event->pelajaran->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->kalender->event->nama);
                //$row .= sprintf('<td>%1$s%2$s</td>',$event->kelas->kelasRoot->tingkat , $event->kelas->nama);
				$row .= sprintf('<td>%1$s</td>' , $event->kelas->nama);
				$row .= sprintf('<td>%1$s</td>' , $event->kalender->session->nama);
                $row .= sprintf('<td>%1$s</td>' , $event->pelaksanaan);
                $row .= sprintf('<td>%1$s</td>' , $event->updated_at);
                $row .= sprintf('<td>%1$s</td>' , $event->created_at);
            $row .= "</tr>";
        }
		$hasil = sprintf(
			'
			<h1 class="title">%1$s</h1>
			%5$s
            <div class="table_div">
				%2$s
    			<table class="table table-striped table-hover" >
    				<tr class ="header">
    					<th>Id</th>
                        <th>Edit/Delete</th>
    					<th>Pelajaran</th>
    					<th>Kalender</th>
                        <th>Kelas</th>
						<th>Session</th>
                        <th>Pelaksanaan</th>
    					<th>Updated_at</th>
    					<th>Created_at</th>
    				</tr>
    				%3$s				
    			</table>
            </div>%4$s',
			$this->get_text_on_top( array($dialog_button) ) 		,
   			$this->filter->get_form_filter_for_view()               ,
            $row                									,
			FUNC\get_pagenation_link($sessions , $where) 		,
			$this->get_error_message()
		);
		
		//@ insert all dialog
		$hasil .= $this->get_all_dialog_form();
        $this->set_content($hasil);
        return $this->index();       
    }
	/**
	 *	init all dialog
	*/
	public function init_all_dialog(){
		$this->init_dialog_add();
		$this->init_dialog_edit();
		$this->init_dialog_delete();		
	}
	/**
	 *	get all dialog form
	 *	return all form
	*/
	protected function get_all_dialog_form(){
		$hasil  = $this->dialog->get_dialog_html();
		$hasil .= $this->dialog_edit->get_dialog_html();
		$hasil .= $this->dialog_del->get_dialog_html();
		return $hasil ;
	}
}