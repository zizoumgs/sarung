<?php
/**	
	Many to Many
	Three database tables are needed for this relationship: users, roles, and role_user.
	The role_user table is derived from the alphabetical order of the related model names,
	and should have user_id and role_id columns.
*/
//class Session extends Sarung_Model_Root{
class Session_Model extends Sarung_Model_Root{
    protected $table = 'session';
    public function kalender(){
       return $this->belongsToMany('Session_Model' ,'Kalender' , 'idsession' , 'idevent');
    }
}