<?php
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
}
