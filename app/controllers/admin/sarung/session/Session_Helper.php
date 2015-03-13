<?php
class Session_Helper {
    const table_name = 'session' ;
    const get_session_name = "session_name";
    const get_nilai_name = "nilai_name";
    const get_perkiraan_santri_name = "perkiraan_santri";
    const get_awal_name = "awal_name";
    const get_akhir_name = "akhir_name";
    const get_up_model_name = "model_name";
    public static function get_max_id(){   return Session_Model::max('id') ;   }
    public static function get_validator(){
        $rules = array(
            Session_Helper::get_session_name   => 'required' ,
            Session_Helper::get_nilai_name     => 'required' ,
            Session_Helper::get_perkiraan_santri_name => "required|numeric" ,
            Session_Helper::get_awal_name      => 'required' ,
            Session_Helper::get_akhir_name     => 'required'
        ); 
        return Validator::make(  Input::all() , $rules);
    }
    
    public static function get_the_session_obj( $add , $id ){
        $event = new Session_Model ();
        if( $add )
            $event->id = $id;
        else
            $event = Session_Model::find( $id );
       	$event->nama                = Input::get(    self::get_session_name	    )	    ;
   		$event->perkiraansantri     = Input::get(    self::get_perkiraan_santri_name	)   ;
        $event->awal                = Input::get(    self::get_awal_name	)   ;
        $event->akhir               = Input::get(    self::get_akhir_name	)   ;
        return $event;
    }

    public static function get_the_addon_session_obj( $mode , $idsession ){
        $the_ses_addon = Session_Addon_Model::where("idsession","=", $idsession);
        if( $mode === "delete" ){
            if( $the_ses_addon->first()){
                return Session_Addon_Model::find( $the_ses_addon->first()->id );
            }
            return null;
        }
        //!
        if( $mode === "edit") {
            //@ there are idsession 
            if( $the_ses_addon->first() ){
               $ses_addon = Session_Addon_Model::find( $the_ses_addon->first()->id );
            }
        }
        else{
            $ses_addon = new Session_Addon_Model();
            $id_session    = admin::get_id ( self::table_name ,self::get_max_id() );
            $ses_addon->id = admin::get_id ( Session_Addon_Model::get_table_name() , Session_Addon_Model::max('id') );
        }
        //@ inti
        $ses_addon->nilai = Input::get( self::get_nilai_name  );
        $ses_addon->model = Input::get( self::get_up_model_name );
        $ses_addon->idsession = $idsession ;
        return $ses_addon;
    }

    public static function get_values( $obj , $id ){
		$obj_addon = Session_Addon_Model::sessionid($id)->first();
        $datas  ['session_value']  				=   $obj->nama;
        $datas  ['awal_value']  				=   $obj->awal;
		$datas  ['akhir_value']  				=   $obj->akhir;
		$datas  ['perkiraan_santri_value']		=   $obj->perkiraansantri;
		$datas  ['tidak_naik_value']			=    $obj_addon->nilai;
		$datas  ['selected']					=    $obj_addon->model;
        $datas  ['id'] 	             			=   $id ;
		$datas ['models'] = Session_Helper::get_up_model();
        return $datas;
    }

    public static function get_up_model(){ return array("Position" , "Persen"); }
}
