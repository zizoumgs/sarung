<?php
class Event_Model extends Sarung_Model_Root{
	protected $table = 'event';
    public function kalender(){
        return $this->belongsToMany('Kalender_Model' ,'session_tag' , 'idsession' , 'idevent');
    }
}
