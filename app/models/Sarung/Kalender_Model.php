<?php
/**
 *		Below is column which is has by kalender table
 *		idevent
 *		idsession
 *		rating
 *		awal
 *		akhir
 *		aktif
 *		money
*/
class Kalender_Model extends Sarung_Model_Root{
	protected $table = 'kalender';
	/*
    public function Event(){
        return $this->belongsToMany('event' , 'idevent');
    }
    public function Session(){
       return $this->belongsToMany('Session_Model' ,'kalender' , 'idsession' , 'idevent');
    }
	*/
    public function Session(){
       return $this->belongsTo('Session_Model' ,'idsession');
    }    
    public function Event(){
       return $this->belongsTo('Event_Model' ,'idevent');
    }
	/**
	 *	Get id kalender by session and event name
	 *	return id
	*/
    public function scopeGet_id($query , $session , $event){
		$session_ = new Session_Model();
		$idSession = $session_->where('nama' , '=' , $session )->firstOrfail();
		$event_   = new Event_Model();
		$idEvent = $event_->where('nama' , '=' , $event )->firstOrfail();
		//return $idEvent;
		return $query->where('idsession' , '=' , $idSession->id)->where('idevent' ,'=' , $idEvent->id);
    }    

}
