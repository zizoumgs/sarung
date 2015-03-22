<?php
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
