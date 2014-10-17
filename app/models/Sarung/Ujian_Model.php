<?php
class Ujian_Model extends Sarung_Model_Root{
	protected $table = 'ujian';
	
    public function Kalender(){
       return $this->belongsTo('Kalender_Model' ,'idkalender');
    }    
    public function Pelajaran(){
       return $this->belongsTo('Pelajaran_Model' ,'idpelajaran');
    }
    public function Kelas(){
        return $this->belongsTo('Kelas_Model' ,'idkelas');
    }
	/**
	 *	get all name of event which is exist in ujian
	 *	return obj
	*/
	public function get_names_of_ujian(){
			$sql = " select eve.nama as name
			from event eve , ujian uji , kalender kal 
			where eve.id = kal.idevent
			and kal.id = uji.idkalender
			group by name
		";
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ));
		return (object)$kelas;	
	}
	/**
	 *	get all name of pelajaran which is exist in ujian
	 *	return obj
	*/
	public function get_names_of_pelajaran(){
			$sql = " select pel.nama as name
			from ujian uji , pelajaran pel 
			where uji.idpelajaran = pel.id
			group by name
		";
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ));
		return (object)$kelas;	
	}
}
class Ujis_Model extends Sarung_Model_Root{
	protected $table = 'ujiansantri';
	
    public function Ujian(){
       return $this->belongsTo('Ujian_Model' ,'idujian');
    }    
    public function Santri(){
       return $this->belongsTo('Santri_Model' ,'idsantri');
    }
    public function Kelas(){
        return $this->belongsTo('Kelas_Model' ,'idkelas');
    }
	public function scopeBypelajaran($query , $nama_session){
		//@ prepare
		$ujian_obj = new Ujian_Model();
		$result = array() ;
		//@ find id of session
		$session 	= new Session_Model();
		$id_session = $session->getfirst($nama_session)->id;
		//@ find ids of kalender whose ids are match with id session
		$kalender	=	new Kalender_Model();
		$kalenders	=	$kalender->where('idsession' ,'=' , $id_session)->get();
		//@ find ids of ujian according to ids kalender
		foreach($kalenders as $kal){
			$ujian_obj = $ujian_obj->orwhere('idkalender' , '=' , $kal->id );
		}
		foreach($ujian_obj->get() as $post){
			$result [] = $post->id ;
		}
		//@ final
		return $query->whereIn('idujian',$result);
	}
	/**
	 *	query for view
	**/
	public function get_raw_query($wheres , $wherequery  , $limit = ""){
		$sql = sprintf('select pel.nama as course_name, ses.nama as session_name  , kel.nama as kelas_name	,
		ses.perkiraansantri perkiraansantri, ses.awal as awal	,	ujis.created_at as created_at	,
		ujis.updated_at as updated_at	,	uji.id as id_ujian	,
		adm.first_name as first_name , adm.second_name as second_name , adm.foto as foto 		,
		san.id as santri_id , 	san.nis as nis , 	eve.nama as event_name						,
		adm.id as id_user 	,	uji.pelaksanaan as pelaksanaan , uji.kalinilai as kalinilai		,
		adm.jenis as jenis	,	ujis.id as id 	,	ujis.nilai as nilai
		
		from pelajaran pel , santri san , admind adm , kelas kel , session ses ,
		ujian uji , ujiansantri ujis , event eve , kalender kal 
		where
		san.idadmind = adm.id
		and san.id = ujis.idsantri
		and ujis.idujian = uji.id
		and uji.idpelajaran = 	pel.id
		and uji.idkelas		=	kel.id
		and uji.idkalender	=	kal.id
		and kal.idsession	=	ses.id
		and kal.idevent		=	eve.id
		%1$s
		order by ujis.created_at DESC
		%2$s
		',$wherequery,$limit);
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) , $wheres  );
		return $kelas;
	}
	/**
	 *	query for add
	 *	will find santri who dont insert into ujian id
	 *	return obj
	*/
	public function get_raw_query_add($model_ujian  , $limit = "" ){
		if( !$model_ujian)
			return array();
		$array = array() ;
		$array [] = $model_ujian->idkelas  ;
		$array [] = $model_ujian->kalender->idsession;
		$array [] = $model_ujian->id;
		$sql = sprintf('
			select adm.first_name as first_name , adm.second_name as second_name , adm.foto as foto,
			adm.jenis as jenis ,	adm.created_at , adm.updated_at	,
			san.idsession as idsession , san.nis as nis , san.id as santri_id			,	ses.nama as session_name,
			ses.awal , ses.perkiraansantri as perkiraansantri	,	adm.id as id_user 	,			
			kel.nama as kelas_name , concat (%1$s) as id_from_outside_db
			from santri san
			JOIN admind adm 				ON adm.id	=	san.idadmind
			LEFT JOIN ujiansantri ujis		ON san.id	=	ujis.idsantri
			JOIN kelasisi keli  			ON san.id  	= 	keli.idsantri ,
			kelas kel, session ses 
			where 
			ses.id = keli.idsession 
			and keli.idkelas = ?
			and ses.id = ?
			and san.id NOT IN (select ujis.idsantri from ujiansantri ujis where ujis.idujian = ?)
			and kel.id = keli.idkelas

		' , $model_ujian->id);
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) , $array  );
		return $kelas;
	}	
	
}

/**
 *  below is columns which is has by ujian tableaddon
 *  id
 *  idujian
 *  file
*/
class Ujian_Model_AddOn extends Sarung_Model_Root{
	protected $table = 'ujianaddon';
    public function Ujian(){
       return $this->belongsTo('Ujian_Model' ,'idujian');
    }    
}


/**
			pel.nama as course_name , kel.nama as kelas_name	, uji.kalinilai as kalinilai	,	uji.pelaksanaan as pelaksanaan ,
			eve.nama as event_name
	


			select adm.first_name as first_name , adm.second_name as second_name , adm.foto,
			adm.jenis as jenis ,	adm.created_at , adm.updated_at	,
			san.idsession as idsession , san.nis as nis , san.id as santri_id		,		
			ses.awal , ses.perkiraansantri as perkiraansantri	,	adm.id as id_user
			from santri san , admind adm , session ses , ujian uji , ujiansantri ujis
			
			where san.idadmind = adm.id
			and ses.id	=	san.idsession
			and ses.nama = "14-15"
			and uji.id	 = 155
*/