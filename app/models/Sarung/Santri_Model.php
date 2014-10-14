<?php
class Santri_Model extends Sarung_Model_Root{
	protected $table = 'santri';
	/**
	*	Session
	**/
    public function Fusip(){
		return $this->belongsTo('Session_Model' , 'id');
    }
	/**
	 *	parent table
	*/
    public function User(){
		return $this->belongsTo('User_Model', 'id');
    }
	/**
	 *	child table
	*/    
    public function Kelasisi(){
    	return $this->hasMany('Class_Model' , 'idsantri');
    }
	/**
	*/
	public static function get_santri_raw(){
			return DB::connection('fusarung')->table('santri')        
            ->leftJoin('session'		, 	'santri.idsession'	, 	'=',	'session.id')
		    ->leftJoin('admind'			, 	'santri.idadmind'	, 	'=',	'admind.id')
			->Join('admindgroup'	, 	'admind.idgroup'	, 	'=',	'admindgroup.id')
			->select("santri.id as id ", "admind.first_name", "admind.second_name",
					 "session.nama as nama " , "santri.created_at" 	, "santri.updated_at",
					 "admind.status"		, 	"admind.id as id_user"	,	"admind.foto" 	,
					 "admind.lahir as ttl"	,	"admind.jenis"			,	"admind.email"	,
					 "santri.nis"			,	'santri.catatan'		,
					 "session.awal"			,	"session.perkiraansantri"
					 
			);
			
		$sql = sprintf('select  *
					   from santri san, session ses , admind adm , desa des , kecamatan kec
				where san.idsession = ses.id and san.idadmind= adm.id and
				des.idkecamatan = kec.id and adm.iddesa = des.id
				order by san.updated_at DESC','fusarung');
		$sel = DB::connection( 'fusarung' )->select(DB::raw($sql));
		return $sel;
		return json_decode($sel, true);
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

}
class Save_Nis_Model extends Sarung_Model_Root{
    //! we are no need to use table created_at and update_at for this table
    public $timestamps = false;
	//!
	protected $table = 'savenis';
    /**
     *  get first row according to session name
     *  return obj or null 
    */
    public function scopeGetfirst($query , $namasession){
		$session = new Session_Model();
		$there = $session->getfirst($namasession);
	    return $query->where('idsession', '=', $there->id)->first();
    }
	/**
	 *	get session id
	 *	return first row
	*/
    public function scopeGetfirstbyid($query , $idsession){
	    return $query->where('idsession', '=', $idsession)->first();
    }
	/**
	 *	get obj by name
	 *	return obj or null 
	*/
    public function scopeGetobj($query , $namasession){
		$session = new Session_Model();
		$there = $session->getfirst($namasession);
	    return $query->where('idsession', '=', $there->id);
    }
	/**
	 *	get obj by session id
	 *	return obj or null
	*/
    public function scopeGetobjbyid($query , $idsession){
	    return $query->where('idsession', '=', $idsession);
    }

}
