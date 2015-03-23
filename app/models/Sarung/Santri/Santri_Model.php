<?php
class Santri_Model extends Sarung_Model_Root{
	protected $table = 'santri';
	/**
	*	Session
	**/
    public function Session(){
		return $this->belongsTo('Session_Model' , 'idsession');
    }	

	/**
	 *	parent table
	*/
    public function User(){
		return $this->belongsTo('User_Model', 'idadmind');
    }
	/**
	 *	child table
	*/    
    public function Kelasisi(){
    	return $this->hasMany('Class_Model' , 'idsantri');
    }
	public function scopeSessionname($query , $name){
		$session = Session_Model::get_id_by_name($name);
		return $query->whereHas('session',function($q) use( $session) {
			$q->where('idsession', '=', $session);
		});
		//return 	$query->where('idsession' , '=' , $session);
	}
	public static function can_be_deleted( $id ){
		if( Class_Model::santriid( $id )->count() <= 0 )
			return true;
		return false;
	}	
	/**
	 *
	**/
	public static function get_santri_raw(){
			return DB::connection('fusarung')->table('santri')        
            ->leftJoin('session'		, 	'santri.idsession'	, 	'=',	'session.id')
		    ->leftJoin('admind'			, 	'santri.idadmind'	, 	'=',	'admind.id')
			->Join('admindgroup'	, 	'admind.idgroup'	, 	'=',	'admindgroup.id')
			->select("santri.id as id ", "admind.first_name", "admind.second_name",
					 "session.nama as nama " , "santri.created_at" 	, "santri.updated_at",
					 "admind.status"		, 	"admind.id as id_user"	,	"admind.foto" 	,
					 "admind.lahir as ttl"	,	"admind.jenis"			,	"admind.email"	,
					 "santri.nis"			,	'santri.catatan'		,	"santri.keluar"	,
					 "session.awal"			,	"session.perkiraansantri"
					 
			);
	}
    /**
     *  get max += 1
     *  return obj or null 
    */
    public function scopeGetnis($query , $namasession){
		$session = new Session_Model();
		$there = $session->getfirst($namasession);
		//! if not exist , return
		if( !$there )
			return null;
        //! take nis
        $nis = new Save_Nis_Model();
        $nis_number = $nis->getfirstbyid( $there->id )->nis;
		if ( $nis_number ){
			return $nis_number; 
		}
		$max = $this->where('idsession' , '=' , $there->id )->max('nis');
		return $max + 1 ;
    }
    /**
     *  get max += 1
     *  return obj or null 
    */
    public function scopeGetmaxnisplus($query , $namasession){
		$session = new Session_Model();
		$there = $session->getfirst($namasession);
		//! if not exist , return
		if( !$there )
			return null;
		$max = $this->where('idsession' , '=' , $there->id )->max('nis');
		return $max + 1 ;
    }    
	public static function getHisClass($idSantri) {
		return Class_Model::santriid ( $idSantri );
	}
}

