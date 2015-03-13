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
    public function scopeGet_id_by_name($query , $name){
		$result =  $query->where('nama' , '=' , $name);
		return $this->check_and_get_id($result);
    } 
}
/**
 *	Additional data for session
*/
class Session_Addon_Model extends Sarung_Model_Root{
    protected $table = 'sessionaddon';
	public static function get_table_name(){
		return 	'sessionaddon';
	}

    public function Session(){
       return $this->belongsTo('Session_Model' ,'idsession');
    }
	public function scopeSessionname($query , $name){
		return $query->whereHas('session',function($q) use( $name) {
			$q->where('nama', '=', $name);
		});
	}
	public function scopeSessionid($query , $idsession){
		return $query->where('idsession', '=', $idsession);
	}
	
}







