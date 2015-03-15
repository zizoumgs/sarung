<?php
class Event_Model extends Sarung_Model_Root{
	protected $table = 'event';
    public function Kalender(){
        //return $this->belongsToMany('Kalender_Model' ,'session_tag' , 'idsession' , 'idevent');
		return $this->hasOne('Kalender_Model', 'idevent');
    }
    public function scopeGet_id_by_name($query , $name){
		$result =  $query->where('nama' , '=' , $name);
		return $this->check_and_get_id($result);
    } 
    public function scopeGet_name_by_id($query , $id){
		$result =  $query->where('id' , '=' , $id);
		return $this->check_and_get_id($result);
    }	
}
