<?php
/**
**	kelasisi
**/
class Class_Model extends Sarung_Model_Root{
    protected $table = 'kelasisi';
	/**
	 *
	 */
	public function Santri(){
		return $this->belongsTo('Santri_Model', 'idsantri');
	}
	/**
	 *
	 */
	public function Session(){
		return $this->belongsTo('Session_Model', 'idsession');
	}
	/**
	 *
	 */
	public function Kelas(){
		return $this->belongsTo("Kelas_Model" , 'idkelas');
	}
	/**
	***	function to get kelas according to id santri
	***	return obj
	**/
	public static function scopeSantriid( $query , $santri_id){
		return $query->where('idsantri' , '=' , $santri_id);
		/*
		$sql = " select kel.nama as kelas_name, ses.nama as session_name  , keli.id as id ,kel.id as idkelas
		from kelasisi keli , santri san , admind adm , kelas kel , session ses
		where san.idadmind = adm.id 
		and keli.idsession = ses.id
		and keli.idsantri  = san.id 
		and keli.idkelas   = kel.id
		and san.id         = ?
		";
		$kelas = DB::connection( parent::get_db())->select( DB::raw( $sql ) 	 , array($santri_id)  );
		return (object)$kelas;
		*/
	}
    /**
    ** this function should be called everytime you wanna delete  item from kelasisi`s table
    ** return object
    **/
    public static function getidujiansantri($idkelas , $idsantri , $nama_session){
		$sql = " 
			select count(*) as total
			from ujian uji , santri san , ujiansantri ujis , kalender kal , session ses
			where uji.id = ujis.idujian
			and uji.idkalender = kal.id
			and ujis.idsantri = san.id
			and ses.id = kal.idsession			
			and uji.idkelas = ? and san.id = ?
			and ses.nama = ?
		";
		$kelas = DB::connection( parent::get_db())->select( DB::raw( $sql ) 	 , array( $idkelas , $idsantri , $nama_session)  );
		return (object)$kelas;
    }
    /**
    ** this function should be called everytime you wanna delete  item from kelasisi`s table
    ** return 
    **/
    public function scopeGetobjbysessionnkelassantri( $query, $idkelas , $idsession , $idsantri){
    	return $query->where('idsession' ,'=' , $idsession)->where('idkelas','=' , $idkelas )->where('idsantri','=',$idsantri);
    }

    
}