<?php
/**
 *  This class is for examination
 *  Do not inherite this class  , you have been warned
*/
class Admin_sarung_ujian extends Admin_sarung_kalender{
	private $input;
    public function __construct(){
        parent::__construct();
    }
	
	protected function set_kalender_name($val) { $this->input['kalender'] = $val ; }
	protected function get_kalender_name(){ return $this->input['kalender'];}
	protected function get_kalender_selected(){ return $this->get_value( $this->get_kalender_name() ) ;}

	protected function set_kelas_name($val) { $this->input['kelas'] = $val ; }
	protected function get_kelas_name(){ return $this->input['kelas'];}
	protected function get_kelas_selected(){ return $this->get_value( $this->get_kelas_name() ) ;}

	protected function set_pelaksanaan_name($val) 	{ $this->input['pelaksanaan'] = $val ; }
	protected function get_pelaksanaan_name()		{ return $this->input['pelaksanaan'];}
	protected function get_pelaksanaan_selected()	{ return $this->get_value( $this->get_pelaksanaan_name() ) ;}

	protected function set_min_nilai_name($val) { $this->input['min_nilai'] = $val ; }
	protected function get_min_nilai_name(){ return $this->input['min_nilai'];}
	protected function get_min_nilai_selected(){ return $this->get_value( $this->get_min_nilai_name() ) ;}

	protected function set_kali_nilai_name($val) { $this->input['kali_nilai'] = $val ; }
	protected function get_kali_nilai_name(){ return $this->input['kali_nilai'];}
	protected function get_kali_nilai_selected(){ return $this->get_value( $this->get_kali_nilai_name() ) ;}

	protected function set_redirect_name($val) { $this->input['go_where'] = $val ; }
	protected function get_redirect_name(){ return $this->input['go_where'];}
	protected function get_redirect_selected(){ return $this->get_value( $this->get_redirect_name()  ) ;}

	protected function set_catatan_name($val) { $this->input['catatan'] = $val ; }
	protected function get_catatan_name(){ return $this->input['catatan'];}
	protected function get_catatan_selected(){ return $this->get_value( $this->get_catatan_name()  ) ;}
	
	/*
	 *	To make different between submit with button or with select
	*/
	protected function set_signal_name($val) { $this->input['form_ujian'] = $val;}
	protected function get_signal_name(){ return $this->input ['form_ujian'] ; }
    /**
     *  priority 1 
	 *	@override
     *  return none
     *  set up everything
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('Ujian');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_name_for_text('Ujian_Filter');
        $this->set_table_name('ujian');
		//!
		$this->set_pelaksanaan_name('pelaksanaan_name');
		$this->set_pelajaran_name('pelajaran_name');
		$this->set_kalender_name('kalender');
		$this->set_event_name('kelas');
		$this->set_session_name('session_name');
		$this->set_min_nilai_name('min_nilai');
		$this->set_kali_nilai_name('kali_nilai');
		$this->set_kelas_name('kelas_name');
		$this->set_redirect_name('go_where');
		$this->set_catatan_name('catatan');
		
		$this->set_signal_name( 'form_id' );
		$this->set_js_to_submit();
    }
	/**
	 *	Set js to submit
	*/
	private function set_js_to_submit(){
		$js = sprintf('
		<script type="text/javascript">
			$(function() {
				$( "select" ).change(function () {
					$("#%1$s").val("1");
					$("form").submit();
				});
			});
		</script>' ,
		$this->get_signal_name()
		);
		$this->set_js( $js );
	}
	/**
	 *	During changing select html
	 *	return redirect::to()
	*/
	public function getKalenderselect(){		$go_where = Input::get( $this->get_redirect_name()  );	}
	/**
	 *	@override
	 *	Default view for add form
	 *	return add html form
	*/
    public function getEventadd($messages = ""){
		$values = $this->set_values_to_input_with_select();
		$heading    = 'Add Ujian';
        $body       = $this->get_form_cud( $this->get_url_this_add() , $values ) ;
		$content    = sprintf('<div class="col-md-8"> <div class="row"> %1$s </div></div> ',$this->get_panel($heading , $body , $messages )) ;
		//$content   .= sprintf('<div class="col-md-4"> %1$s </div> ',$this->get_panel("Information" , '' )) ;
        $this->set_content( $content);
        return $this->index();
    }
	
	/**
	 *	@override
	 *	priority 1
	 *	return form html for add , edit and delete
	**/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
		$this->use_select();
        $array = array(
					$this->get_pelajaran_name() 		=> 	'' ,
					$this->get_event_name()				=> 	'' ,
					$this->get_kalender_name()			=> 	'' ,
					$this->get_kali_nilai_name()		=>	'' ,
					$this->get_kelas_name()				=>	'' ,
					$this->get_pelaksanaan_name()		=> 	'' ,
					$this->get_catatan_name()			=> 	'' ,
					$this->get_session_name()			=>	'' 
        );
        $array = $this->make_one_two_array($array , $values);
        $kali_nilai = sprintf('<input type="text" name="%1$s" class="%1$s form-control" Value="%2$s" %3$s  >',
                                    $this->get_kali_nilai_name()              , 
                                    $array [ $this->get_kali_nilai_name()]    ,
                                    $disabled );
        $pelaksanaan = sprintf('<input type="text" name="%1$s" class="%1$s form-control" Value="%2$s" %3$s  title="form:2014-12-31 jam:menit">',
                                    $this->get_pelaksanaan_name()              , 
                                    $array [ $this->get_pelaksanaan_name()]    ,
                                    $disabled );
		$catatan     = sprintf('<textarea class="form-control" rows="5" name="%1$s">%2$s</textarea>' ,
							   $this->get_catatan_name(),
							   $array [ $this->get_catatan_name() ]
							   );
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' => 'form-horizontal')) ;
				$hasil .= $this->get_input_cud_group( 'Pelajaran'  , $this->get_pelajaran_select($array[$this->get_pelajaran_name()] ) ) ;
				$hasil .= $this->get_input_cud_group( 'Event'      , $this->get_event_select($array[$this->get_event_name()] )) ;
				$hasil .= $this->get_input_cud_group( 'Session'   , $this->get_session_select($array[$this->get_session_name()]  )) ;
				$hasil .= $this->get_input_cud_group( 'Kelas'     , $this->get_kelas_select($array[$this->get_kelas_name()]) ) ;
		   		$hasil .= Form::hidden('id', $this->get_id() );
				//! to know whether submit with select or button
				$hasil .= Form::hidden( $this->get_signal_name(), '0'  , array('id' => $this->get_signal_name() ) );
				$hasil .= Form::hidden($this->get_redirect_name(), $go_where);
				$hasil .= $this->get_input_cud_group( 'Pelaksanaan'     , $pelaksanaan ) ;
				$hasil .= $this->get_input_cud_group( 'Kali Nilai'   , $kali_nilai) ;
				$hasil .= $this->get_input_cud_group( 'Catatan'   , $catatan , '') ;
		$hasil .= '<div class="form-group"><div class="col-sm-offset-2 col-sm-10">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-sm') );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        return $hasil;
    }
	/**
	 *	Rules for input form
	 *	return array which contains rules
	*/
    protected function get_rules($with_id = false){
        $array = array(
            $this->get_kali_nilai_name()  => 'required|numeric' ,
            $this->get_pelaksanaan_name   ()  => 'required:datetime' 
        ); 
        if($with_id)
            $array ['id'] = "required|numeric" ; 
        return $array;
    }	
	/**
	 *	return select html for pelajaran
	 */
	protected function get_pelajaran_select($selected = ''){
		$session = new Pelajaran_Model();
		$sessions = $session->orderBy('updated_at' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_pelajaran_name() , 'selected' => $selected,
						 'onchange' => 'submit_form_with_select()' );
		return $this->get_select($items , $default);
	}
	/**
	 *	return select html for pelajaran
	 */
	protected function get_event_select($selected = ''){
		$session = new Event_Model();
		$sessions = $session->orderBy('updated_at' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_event_name() , 'selected' => $selected ,
						 'onchange' => 'submit_form_with_select()' );
		return $this->get_select($items , $default);
	}
	/**
	 *	return select html for session
	 */
	protected function get_session_select_ujian($selected = ''){
		$session = new Session_Model();
		$sessions = $session->orderBy('updated_at' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_session_name() , 'selected' => $selected ,
						 'onchange' => 'submit_form_with_select()' );
		return $this->get_select($items , $default);
	}
	
	/**
	 *	return select html for kelas
	 */
	protected function get_kelas_select($selected = ''){
		$session = new Kelas_Model();
		$sessions = $session->orderBy('updated_at' , 'DESC')->get();
		$items = array( "All" => "All" );
		foreach($sessions as $val){
			$items [$val->id] = $val->nama;
		}
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" , "name" => $this->get_kelas_name() , 'selected' => $selected ,
						 'onchange' => 'submit_form_with_select()' );
		return $this->get_select($items , $default);
	}
	

    /**
	 *
	 *	For all input_group , but you should use input as a parameter
	*/
    protected function get_input_cud_group( $label , $input , $add_class= "form-group-sm"){
        return sprintf('
        <div class="form-group %3$s">
            <label class="col-sm-2 control-label" >%1$s</label>
            <div class="col-sm-8">
                %2$s
            </div>
        </div>' , $label , $input , $add_class);
    }
    /**
	 * @override
     *  priority 1 
     *  Default view for this class
     *  return @index()
    */    
    public function getIndex(){
         $find_name = $this->get_name_for_text_selected();
        $href = sprintf('<a href="%1$s" class="btn btn-primary btn-xs" >Add</a>' , $this->get_url_this_add() );        
        $this->set_text_on_top('Ujian Table  '.$href);
        $row = "";
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
			%2$s
            <div class="table_div">
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
			 	$this->get_text_on_top() ,
   				''               ,
                $row                ,
                //$events->appends( array() )->links()
			 	$this->get_pagination_link($sessions , $wheres) 
			);
        $this->set_content($hasil);
        return $this->index();       
    }
    /**
	 *	@override
     *  return depents
    */
	public function postEventedit(){
		$chose = $this->get_value( $this->get_signal_name() );
		if($chose == 1 ){
			$id = Input::get('id');
			$this->getKalenderselect();
			$array = $this->set_values_to_input_with_select();
            $heading    = 'Will edit id ' . $id ;
			$this->set_id( $id 	);
            $body  = $this->get_form_cud( $this->get_url_this_edit() , $array );
            $this->set_content( $this->get_panel($heading , $body ) );
            return $this->index();            

		}
		else{
			$this->Sarung_db_about( Input::all() );
			//return parent::postEventedit();
		}		
	}
    /**
	 *	@override
     *  After_Submit
     *  return depents
    */
	public function postEventadd(){
		$chose = $this->get_value( $this->get_signal_name() );
		if($chose == 1 ){
			$this->getKalenderselect();
			return $this->getEventadd();
		}
		else{
			return parent::postEventadd();
		}
	}
	
	/**
	 *	@override
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
		//! find id kelas by its name
		$kelas = new Kelas_Model();
		$idKelas = $kelas->where('nama' , '=' , $data [$this->get_kelas_name()])->first();
		//! find pelajaran
		$pelajaran = new Pelajaran_Model();
		$idPelajaran = $pelajaran->where( 'nama' , '=' , $data [ $this->get_pelajaran_name()   ] )->first();
		//! find idkalender
		$kalender = new Kalender_Model();
		$idKalender = $kalender->Get_id( $data [$this->get_session_name()] ,$data [$this->get_event_name()] )->firstOrfail() ;
       	$event->idkelas         = $idKelas->id;
		$event->idkalender		= $idKalender->id;
		/* if there are no result you should check whether kalender for that is exist*/
		$event->idpelajaran		= $idPelajaran->id;
		$event->pelaksanaan     = $data [$this->get_pelaksanaan_name()] ;
		$event->kalinilai       = $data [$this->get_kali_nilai_name()] ;
		$event->minnilai		= 0 ;
		$event->catatan			= $data [$this->get_catatan_name() ] ;
		$event->tempat 			=	'';
        return $event;
    }
	/**
	 *  function will be used during changing select 
	 *	set values to input_with_select
	 *	return array 
	 *	
	*/
	protected function set_values_to_input_with_select(){
		return array( $this->get_session_name()   => $this->get_session_selected() 		,
						$this->get_pelajaran_name()  => $this->get_pelajaran_selected() 	,
						$this->get_event_name() 	 => $this->get_event_selected() 		,
						$this->get_kelas_name()		 => $this->get_kelas_selected()			,
						$this->get_pelaksanaan_name()		 => $this->get_pelaksanaan_selected()			,
						$this->get_catatan_name()	=>	$this->get_catatan_selected(), 
						$this->get_kali_nilai_name() => $this->get_kali_nilai_selected()
						);
	}		
	/**
	 *	@override
	 *	will be used just for edit and delete
	 *	return array
	*/
    protected function set_values_to_inputs($model){
		//echo $model->catatan;
			//session->nama
            return array(
						 $this->get_session_name() 	=>	$model->kalender->session->nama ,
						 $this->get_event_name()	=>  $model->kalender->event->nama,
						 $this->get_pelajaran_name() => $model->pelajaran->nama , 
						 $this->get_pelaksanaan_name() => $model->pelaksanaan,
						 $this->get_kali_nilai_name()  => $model->kalinilai,
						 $this->get_kelas_name()		=> $model->kelas->nama,
						 $this->get_catatan_name()		=> $model->catatan 
						 );
    }
	/**
	 *	@override
	 *	priority 1
	 *	return obj of table 
	*/
    protected function get_model_obj(){        return new Ujian_Model();    }
	/**
	 *	We need this url for select
	 *	return text url 
	*/
	protected function get_url_this_select(){return $this->get_url_admin_sarung()."/ujian/kalenderselect" ; }
	/**
	 *	priority 1
	 *	return url string for add 
	*/
    protected function get_url_this_add(){ return $this->get_url_admin_sarung()."/ujian/eventadd" ;}
	/**
	 *	priority 1
	 *	return url string for edit
	*/
    protected function get_url_this_edit(){ return $this->get_url_admin_sarung()."/ujian/eventedit" ;}
	/**
	 *	priority 1
	 *	return url string for delete
	*/
    protected function get_url_this_dele(){ return $this->get_url_admin_sarung()."/ujian/eventdel" ;}	
}