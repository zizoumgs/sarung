<?php
class Kalender_Helper {
    const table_name = 'kalender' ;
    const get_session_name = "session_name_hoho";
    const get_event_name = "nilai_name";
    const get_rating_name = "rating_santri";
	const get_aktif_name = "aktif_name";
    const get_money_name = "model_name";
    const get_awal_name = "awal_name";
    const get_akhir_name = "akhir_name";
	
	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return Kalender_Model::max('id') ;   }
	
	private static function get_create_model() { return new Kalender_Model; }
	
	/**
	 *	return array
	*/
    public static function get_validator(){
        $rules = array(
            self::get_session_name   	=> 	'required' ,
            self::get_event_name     	=> 	'required' ,
            self::get_rating_name 		=> 	"required|numeric" ,
			self::get_money_name 		=> 	"required|numeric" ,
            self::get_awal_name      	=> 	'required' ,
            self::get_akhir_name     	=> 	'required'
        ); 
        return Validator::make(  Input::all() , $rules);
    }
    
	/**
	 *	return integer 0 , 1 
	*/
	private static function get_active_value(){
		$aa = Input::get(    self::get_aktif_name	) ;
		if( ! $aa )
			return 0 ;
		return $aa;
	}
	/**
	 *	return particular object
	*/	
    public static function get_the_obj( $add , $id ){
        $obj = self::get_create_model();
        if( $add )
            $obj->id = $id;
        else
            $obj = $obj->find( $id );
       	$obj->idsession				= Session_Model::get_id_by_name( Input::get(    self::get_session_name	    ) )	    ;
   		$obj->idevent     			= Event_Model::get_id_by_name(   Input::get(    self::get_event_name		) )		;
		$obj->rating     			= Input::get(    self::get_rating_name	)   ;
		$obj->aktif     			= self::get_active_value() ;
		$obj->money     			= Input::get(    self::get_money_name	)   ;
        $obj->awal                	= Input::get(    self::get_awal_name	)   ;
        $obj->akhir               	= Input::get(    self::get_akhir_name	)   ;
        return $obj;
    }
	/**
	 *	You will need this to get data from db and display it to form
	 *	return array
	*/
    public static function get_values( $obj , $id ){
        $datas  [ 'session' ]  		=   Session_Model::find($obj->idsession)->nama;
		$datas  [ 'event' ]  		=   Event_Model::find($obj->idevent)->nama;
		$datas  [ 'money' ]  		=   $obj->money;
		$datas  [ 'rating' ]  		=   $obj->rating;	
        $datas  [ 'aktif' ]  		=   $obj->aktif;
		$datas  [ 'akhir' ]  		=   $obj->akhir;
		$datas  [ 'awal'  ]			=   $obj->awal;
        $datas  ['id']				=   $id ;
        return $datas;
    }
	
	public static function get_obj_find(){
		$kalender = new Kalender_Model ;
		$event 		= 	Input::get('find_event_name');
		$session 	= 	Input::get('find_session_name');
		if( $event  !== "All" && $event != "" ){
			$id = Event_Model::where('nama' , '=' , $event )->first()->id;
			$kalender 	= 	$kalender->where("idevent" , "=" , $id );
		}
		if( $session  !== "All" && $session != ""  ){
			$id 		= 	Session_Model::where('nama' , '=' , $session )->first()->id;
			$kalender 	= 	$kalender->where("idsession" , "=" , $id );
		}
		return $kalender;
	}
	public static function get_table_filter(){
		$where = array () ;
		if( Input::get('find_event_name') !== "All"){
			$where ['find_event_name'] = Input::get('find_event_name');
		}
		if( Input::get('find_session_name') !== "All"){
			$where ['find_session_name'] = Input::get('find_session_name');
		}
		return $where;
	}
	
	public static function get_table_info( $obj ){
		return sprintf('Show %1$s of %2$s', $obj->getFrom() , $obj->getTotal()) ;
	}
}
