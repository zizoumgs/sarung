<?php
/**
 *  parent for ujian    :   Admin_sarung_support.php
 *  parent for dialog   :   Admin_sarung_ujian_crud_dialog.php 
*/
/**
 *	this is just for support
*/
class Admin_sarung_ujian_support extends Admin_sarung_support{
	public $filter ;
    /**
     *  priority 1 
	 *	@override
     *  return none
     *  set up everything
    **/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Ujian');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('ujian');		
		//!
		$this->set_url_this_add($this->get_url_admin_sarung()."/ujian/eventadd");
		$this->set_url_this_edit($this->get_url_admin_sarung()."/ujian/eventedit");
		$this->set_url_this_dele($this->get_url_admin_sarung()."/ujian/eventdel");
		//@
		$this->set_purpose(parent::VIEW);
    }
	protected function get_text_on_top($additonal_button = array()){
		$href= "";
		foreach($additonal_button as $button ){
			$href .= $button;
		}
        $aba 	= 	sprintf('<span class="glyphicon glyphicon-inbox"> </span> Ujian Table ').$href;
		return $aba;
	}
    public function __construct(){
        parent::__construct();
    }

	/**
	 *	During changing select html
	 *	return redirect::to()
	*/
	public function getKalenderselect(){
		$go_where = Input::get( $this->get_redirect_name()  );
	}
    /**
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
}

/**
 *	for add
*/
class Admin_sarung_ujian_add extends Admin_sarung_ujian_support{
	public function __construct(){
		parent::__construct();
	}
	protected $dialog , $dialog_edit , $dialog_del;
    /**
     *  no override
     *  url to catch post add submit
    */
    public final function postEventadd(){
		$this->set_purpose(parent::ADDI);
        //@ important
		$this->init_dialog_add();
        //@
		$data = Input::all();
		$rules = array(
					   $this->dialog->get_id_kalender_name() 	=> 'required|numeric',
					   $this->dialog->get_kali_nilai_name()		=>	'required|numeric'
		);
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			$this->set_error_message($message);
			return $this->getIndex();
		}
        else{
           return $this->will_insert_to_db($data);
        }            
    }
	/*
	 *	@override
	 *	no child can override this function anymore
	 *	return postEventaddsucceded if succeded , getEventadd otherwise
	*/
	protected final  function Sarung_db_about_add($data , $edit = false , $values = array() ){
		//@ find minimum class
		$min_nilai	=	$data [ $this->dialog->get_min_nilai_name()] ;
		if($min_nilai == ""){
			$min_nilai = 0 ; 
		}
		//@ find id kelas
		$kelas = new Kelas_Model();
		$kelas_id = $kelas->getid( $data [$this->dialog->get_kelas_name()]);
		//@ find id pelajaran
		$pelajaran = new Pelajaran_Model();
		$pelajaran_id = $pelajaran->get_id_by_name( $data [$this->dialog->get_pelajaran_name()] );
		//@	main
		$event = $this->get_model_obj();
		$event->id					= $data ['id'] ;
       	$event->idkelas         = $kelas_id;
		$event->idpelajaran		= $pelajaran_id;
		$event->idkalender		= $data [$this->dialog->get_id_kalender_name()] ;
		$event->kalinilai       = $data [$this->dialog->get_kali_nilai_name()] ;
		$event->minnilai		= $min_nilai ;
		$event->pelaksanaan     = $data [$this->dialog->get_pelaksanaan_name()] ;		
		$event->catatan			= $data [$this->dialog->get_catatan_name() ] ;		
        return $event;
	}
	/**
	 *	will handle ajax change in add section
	*/
	public function getHandlechangeadd(){
		$this->init_dialog_add();
		return $this->dialog->get_handle_change();
	}	
	/**
	 *	init class for add 
	*/
	protected function init_dialog_add(){
		$this->dialog = new Admin_sarung_ujian_dialog_add();		
		$this->dialog->set_default_value("_add");
		//! we will take input if not from add
		$data = Input::all();
		if($this->get_purpose() != parent::ADDI){
			$data = array();
		}
		$this->dialog->set_default_value_for_input( $data );
			
		$this->dialog->set_url_cha_id_kal( $this->get_url_admin_sarung()."/ujian/handlechangeadd" );
		$js = $this->dialog->set_get_js();
		$this->set_js($js);
	}
	/**
	 *	for editing
	*/
	public final function getEventadd($message = ""){
		return $this->getIndex();
	}
}

/**
 *	for edit
*/
class Admin_sarung_ujian_edit extends Admin_sarung_ujian_add{
	public function __construct(){
		parent::__construct();
	}
    /**
     *  no override
     *  url to catch post add submit
    */
    public final function postEventedit(){
		$this->set_purpose(parent::EDIT);
        //@ important
		$this->init_dialog_edit();
        //@
		$data = Input::all();
		$rules = array(
						
						$this->dialog_edit->get_id_kalender_name() 	=> 'required|numeric',
						$this->dialog_edit->get_kali_nilai_name()	=>	'required|numeric'
		);
    	$validator = Validator::make($data, $rules);
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			$this->set_error_message($message);
			return $this->getIndex();
		}
        else{
			$data ['id'] = $data [$this->dialog_edit->get_id_ujian_name()];
           return $this->will_edit_to_db($data);
        }            
    }
	/*
	 *	@override
	 *	no child can override this function anymore
	 *	return postEventaddsucceded if succeded , getEventadd otherwise
	*/
	protected final  function Sarung_db_about_edit($data , $edit = false , $values = array() ){
		$dialog = $this->dialog_edit;
		//@ find minimum class
		$min_nilai	=	$data [ $dialog->get_min_nilai_name()] ;
		if($min_nilai == ""){
			$min_nilai = 0 ; 
		}
		//@ find id kelas
		$kelas = new Kelas_Model();
		$kelas_id = $kelas->getid( $data [$dialog->get_kelas_name()]);
		//@ find id pelajaran
		$pelajaran = new Pelajaran_Model();
		$pelajaran_id = $pelajaran->get_id_by_name( $data [$dialog->get_pelajaran_name()] );
		//@	main
		$this->set_model_obj( new Ujian_Model() );
		$event = $this->get_model_obj();
		$event 					= $event->find( $data ["id"] );
		$event->idpelajaran		= $pelajaran_id;
		$event->idkelas			=	$kelas_id;
		$event->idkalender		= $data [$dialog->get_id_kalender_name()] ;
		$event->kalinilai       = $data [$dialog->get_kali_nilai_name()] ;
		$event->minnilai		= $min_nilai ;
		$event->pelaksanaan     = $data [$dialog->get_pelaksanaan_name()] ;		
		$event->catatan			= $data [$dialog->get_catatan_name() ] ;
		//@ lastly we must unset obj
		unset($this->dialog_edit);

        return $event;
	}
	/**
	 *	init class for edit
	*/
	protected function init_dialog_edit(){
		$this->dialog_edit = new Admin_sarung_ujian_dialog_edit();		
		$this->dialog_edit->set_default_value("edit");
		$data = Input::all();
		if($this->get_purpose() != parent::EDIT){
			$data = array();
		}
		$this->dialog_edit->set_default_value_for_input( $data);
		$this->dialog_edit->set_url_cha_id_kal( $this->get_url_admin_sarung()."/ujian/handlechangeedit" );
		$this->dialog_edit->set_url( $this->get_url_this_edit());
		$js = $this->dialog_edit->set_get_js();
		$this->set_js($js);
	}
	/**
	 *	for editing
	*/
	public final function getEventedit($id , $values = array() , $message = ""){
		return $this->getIndex();
	}
	/**
	 *	will handle ajax change in add section
	*/
	public function getHandlechangeedit(){
		$this->init_dialog_edit();
		return $this->dialog_edit->get_handle_change();
	}
}
/**
 *	for edit
*/
class Admin_sarung_ujian_dele extends Admin_sarung_ujian_edit{
	public function __construct(){
		parent::__construct();
	}
    /**
     *  no override anymore
     *  url to catch post add submit
    */
    public final function postEventdel(){
		$this->set_purpose( self::DELE);
        $this->init_dialog_delete();
		$id = Input::get( $this->dialog_del->get_id_ujian_name());
        if($id >= 0 ){
			$data = Input::all();
            $data ['id'] = $id ; 
			return $this->will_dele_to_db($data);
        }
        else{
            echo "You tried to put non positif id ";
        }
       
    }
	/**
	 *	init class for edit
	*/
	protected function init_dialog_delete(){
		$this->dialog_del = new Admin_sarung_ujian_dialog_delete();		
		$this->dialog_del->set_default_value("delete");
		$this->dialog_del->set_default_value_for_input( array());
		$this->dialog_del->set_url( $this->get_url_this_dele());
		$js = $this->dialog_del->set_get_js();
		$this->set_js($js);
	}
	/**
	 *	for editing
	*/
	public final function getEventdele($id , $values = array() , $message = ""){
		return $this->getIndex();
	}
}
