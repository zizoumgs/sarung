<?php
/**	
	Many to Many
	Three database tables are needed for this relationship: users, roles, and role_user.
	The role_user table is derived from the alphabetical order of the related model names,
	and should have user_id and role_id columns.
*/
class Session_Model extends Sarung_Model_Root{
    protected $table = 'session';
	/*
	public function Santri(){
		return $this->hasOne('Santri_Model', 'idsession');
	}
	*/
	/*
    public function kalender(){
       return $this->belongsToMany('Session_Model' ,'Kalender' , 'idsession' , 'idevent');
    }
	*/
    public function scopeGetfirst($query , $namasession){
        return $query->where( 'nama', '=', $namasession)->first();
    }
    public function scopeGetfirstbyid($query , $idsession){
        return $query->where( 'id', '=', $idsession)->first();
    }
	
}







