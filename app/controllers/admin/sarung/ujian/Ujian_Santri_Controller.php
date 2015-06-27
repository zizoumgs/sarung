<?php
/*
 *		This class will suport add and delete , no edit option for this class instead , .
 *		you just delete that item and begin to edit
 *		database table name: kelasisi
*/
class Ujian_Santri_Controller extends admin{
    public function __construct(){
		parent::__construct(1);
		admin::init_helper(new Ujian_Santri_Helper);
	}
	private static function get_db_name(){	return Config::get('database.default'); }
	
    public function getIndex(){
		$limit = 10;
        $datas = array();
        $datas ['wheres']  	=	array();//admin::get_helper()->get_values_for_pagenation();
		$null = array();
        $datas ["items"] 	= 	admin::get_helper()->get_the_obj_find(  $null , '' );
		$datas ["pagination"] 	= 	admin::get_helper()->get_pagination( $datas ["items"]   , $limit );
		
		$datas ["items"] 	= 	admin::get_helper()->get_the_obj_find(
																  $datas ['wheres'] ,
																  Ujian_Santri_Helper::get_limit_text($limit)  );
		$datas ["info"]     = 	admin::get_helper()->get_info( $datas ["pagination"]  );
		$datas ['helper'] 	= 	admin::get_helper();
        return View::make( "sarung.admin.ujian_santri.index" , $datas);
    }	
	public function anyChangeujianajax(){
		$ujian_mdl = Ujian_Model::find(  Input::get('dialog_edit_id_ujian_name') );
		if($ujian_mdl){
			//@ we will maintain to communicate with get ,
			$to_ajax = array();
			$to_ajax [ 'dialog_edit_pelajaran_name' ]  	=	$ujian_mdl->pelajaran->nama;
			$to_ajax [ 'dialog_edit_kelas_name' ]  		=	$ujian_mdl->Kelas->nama;
			//$to_ajax [ $this->get_event_name() ]  		=	$ujian_mdl->kalender->event->nama;
			$to_ajax [ 'dialog_edit_session_name'  ]  	=	$ujian_mdl->kalender->session->nama;
			$to_ajax [ 'dialog_edit_pelaksanaan_name' ] =	$ujian_mdl->pelaksanaan;
		}
		else{
			$to_ajax [ 'dialog_edit_pelajaran_name' ]  	=	'No Data';
			$to_ajax [ 'dialog_edit_kelas_name'  ]  	=	'No Data';
			//$to_ajax [ $this->get_event_name() ]  		=	'No Data';
			$to_ajax [ 'dialog_edit_session_name' ]  	=	'No Data';
			$to_ajax [ 'dialog_edit_pelaksanaan_name' ] =	'No Data';
		}		
		echo json_encode( $to_ajax); 
	}
	public function anyChangesantriajax(){
		//@ gather value
		$id_santri 		= 	Input::get('dialog_edit_id_santri_name');
		$target_div 	= 	'dialog_edit_santri_name';
		if( !is_numeric($id_santri) ){
			echo json_encode( array( $target_div => "There are non numeric id santri ") ); 
			return ;
		}
		$obj = Santri_Model::find( $id_santri );
		if( $obj->first() ){
			//$obj = $obj->first();
			//@ name
			$to_ajax = array( $target_div => $obj->user->first_name ." ".$obj->user->second_name );
			//$to_ajax = array( $target_div => $id_santri);
		}
		else{
			$to_ajax = array( $target_div => "There are no santri on that class");
		}
		echo json_encode( $to_ajax); 
	}	
	public function getIndexadd(){
		$id_ujian		  	=	Input::get('find_id_ujian_name');
		if( Session::has('id_kelas') ){
			$id_ujian = Session::get('id_kelas');
		}
		$limit = 10;
        $datas = array();
        $datas ['wheres']  		=	array();//admin::get_helper()->get_values_for_pagenation();
		$null = array();
        $datas ["items"] 		= 	admin::get_helper()->get_the_obj_find_add(  $null , ''  , $id_ujian);
		$datas ["pagination"] 	= 	admin::get_helper()->get_pagination( $datas ["items"]   , $limit );
		
		$datas ["items"] 	= 	admin::get_helper()->get_the_obj_find_add(
																  $datas ['wheres'] ,
																  Ujian_Santri_Helper::get_limit_text($limit)  ,
																  $id_ujian);
		$datas ["id_ujian"] = $id_ujian;
		$datas ['ujian_ket'] 	= Ujian_Model::find( $id_ujian);
		
		$datas ["info"]     = 	admin::get_helper()->get_info( $datas ["pagination"]  );
		$datas ['helper'] 	= 	admin::get_helper();
        return View::make( "sarung.admin.ujian_santri.index_add" , $datas);		
	}
    public function getAdd(){
		$datas = array();
		$datas ['helper'] = admin::get_helper();
        return View::make( "sarung.admin.ujian_santri.add" , $datas);
    }
	private function get_validator(){
   		$rules = array( 'dialog_add_nilai_name' => 'required|numeric' );
    	return Validator::make(Input::all(), $rules);
	}
    public function postAdd(){
		$validator = self::get_validator();
		if ($validator->fails())    {
			$message = implode ( "<br>",$validator->messages()->all() ) ;
	        return Redirect::to( root::get_url_admin_ujis() )
				->with('message',  $message );			
		}
	    elseif($this->insert_to_db()){
	        return Redirect::to( root::get_url_admin_ujis('indexadd') )
				->with('id_kelas',  Input::get("dialog_add_id_ujian_name") );
		}
        else{
			return Redirect::to( root::get_url_admin_ujis() )
				->with('message',  admin::get_error_message() );
		}
    }
	public function postEdit(){
	    if( $this->edit_to_db( Input::get('id_name') ) ){
	        return Redirect::to( root::get_url_admin_ujis() )
				->with('message',  "Berhasil merubah ke database");
		}
        else{
			return Redirect::to( root::get_url_admin_ujis() )
				->with('message',  admin::get_error_message() );
		}
	}
	private function edit_to_db( $id ){
		$save_objects [] = admin::get_helper()->get_the_obj( false , $id);
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , array() );		
	}	
    public function postDelete(){
        $url  = root::get_url_admin_ujis();
        if($this->delete_to_db( Input::get('dialog_delete_id_name') )){
            return Redirect::to( $url )->with('message',  "Berhasil Menghapus database");
        }
        else{
            return Redirect::to( $url )->with('message',  admin::get_error_message() );
        }
    }
    private function delete_to_db($id){
		$del_objects  [] = admin::get_helper()->get_create_model()->find( $id );
		$save_objects [] = admin::get_saveid_obj( admin::get_helper()->get_table_name() , $id ) ;
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
	
    private function insert_to_db(){
        $id 				= 	admin::get_id( admin::get_helper()->get_table_name() , admin::get_helper()->get_max_id() );
		$save_objects = array(admin::get_helper()->get_the_obj( true , $id ));
		$del_objects  = array(SaveId::nameNid( admin::get_helper()->get_table_name() , $id ));
		return admin::multi_purpose_db( self::get_db_name() , $save_objects , $del_objects );
    }
    
}