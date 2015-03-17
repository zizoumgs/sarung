<?php
class Ujian_Helper {
    const table_name = 'ujian' ;
    const get_session_name = "session_name_hoho";
    const get_event_name = "nilai_name";
	
    const get_kalender_name = "akhir_name";
	const get_pelajaran_name = "pelajaran_name";
	const get_kelas_name = "kelas_name";
    const get_kelipatan_name = "kelipatan_santri";
	const get_nilai_name = "nilai_name";
    const get_date_name = "date_name";
    const get_time_name = "time_name";
	
	public function get_table_name(){ return self::table_name;}
    public static function get_max_id(){   return self::get_create_model()->max('id') ;   }
	
	public static function get_create_model() { return new Ujian_Model; }
	
	/**
	 *	return array
	*/
    public static function get_validator(){
        $rules = array(
            self::get_kelipatan_name	=> 	"required|numeric" ,
			self::get_nilai_name 		=> 	"required|numeric" ,
            self::get_date_name      	=> 	'required' ,
            self::get_time_name     	=> 	'required'
        ); 
        return Validator::make(  Input::all() , $rules);
    }
    
	/**
	 *
	*/
	public static function get_date_and_time(){
		$tanggal = Input::get(    self::get_date_name	) 	;
		$waktu   = Input::get(    self::get_time_name	).":00" 	;
		return sprintf('%1$s %2$s ', $tanggal , $waktu )	;
	}
	public static function get_date( $obj ){
		$date = date_create($obj->pelaksanaan);
		return date_format($date	,"Y/m/d") ;
	}
	public static function get_time( $obj ){
		$date = date_create($obj->pelaksanaan);
		return date_format($date	,"H:i") ;
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
       	$obj->idkalender	= Input::get(    self::get_kalender_name	 )	    ;
   		$obj->idpelajaran	= Input::get(self::get_pelajaran_name);
		$obj->idkelas		= Input::get(self::get_kelas_name);
		$obj->pelaksanaan	= self::get_date_and_time();
		Log::info(self::get_date_and_time());
		$obj->minnilai 		= Input::get(    self::get_nilai_name	)   ;
        $obj->kalinilai    	= Input::get(    self::get_kelipatan_name	)   ;
        return $obj;
    }
	/**
	 *	You will need this to get data from db and display it to form
	 *	return array
	*/
    public static function get_values( $obj , $id ){
        $datas  [ 'session' ]  		=   $obj->kalender->session->nama;
		$datas  [ 'event' ]  		=   $obj->kalender->event->nama;
		$datas  [ 'id_pelajaran']		=	$obj->pelajaran->id;
		$datas  [ 'id_kelas']		=	$obj->kelas->id;
		$datas  [ 'nilai' ]  		=   $obj->minnilai;
		$datas  [ 'kelipatan' ]  	=   $obj->kalinilai;	
        $datas  [ 'aktif' ]  		=   $obj->aktif;
		$datas  [ 'date' ]			=	self::get_date( $obj );
		$datas  [ 'time' ]			=	self::get_time( $obj );
        $datas  ['id']				=   $id ;
		$datas   ['id_kalender']		=	$obj->kalender->id;
        return $datas;
    }
	
	public static function get_obj_find(){
		$main   	= 	self::get_create_model() ;
		$event 		= 	Input::get('find_event_name');
		$session 	= 	Input::get('find_session_name');
		$pelajaran  =	Input::get('find_pelajaran_name');
		$kelas	  	=	Input::get('find_kelas_name');
		if( $event  !== "All" && $event != "" ){
			$main 	= 	$main->eventname($event);
		}
		if( $session  !== "All" && $session != ""  ){
			$main 	= 	$main->sessionname($session);
		}
		if( $pelajaran !== "All" && $pelajaran != ""  ){
			$main 	= 	$main->pelajaranname($pelajaran);
		}
		if( $kelas !== "All" && $kelas != ""  ){
			$main 	= 	$main->kelasname($kelas);
		}		
		return $main;
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
