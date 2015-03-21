<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
class AdmindGroup_Model extends Sarung_Model_Root {
	protected $table = 'admindgroup';
    public function User()
    {
        return $this->hasOne('User_Model');
    }
	/**
	 *  get id of lesser power
	 *	return model
	*/
    public function scopeGet_lesser_power($query, $current_power)
    {
		return $query->where('power' , '<' , $current_power );
    }	
	/**
	 *	return obj
	*/
	public function scopeGet_first($query,$admind_nama){
        return $query->where('nama' , '=' , $admind_nama )->first();
	}

}
/**
 *	This class will be model for user which will login into this application
 *	the configuration is in app/config/auth.php
*/
class User_Model extends Sarung_Model_Root implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'admind';

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = array('password');
	/**
	 *	return object of admind_group
	 **/
	public function Admindgroup(){
		return $this->belongsTo('AdmindGroup_Model' , 'idgroup' , 'id');
	}
	/**
	 *	return object of Desa_Model
	 **/
	public function Desa(){
		return $this->belongsTo('Desa_Model' , 'iddesa' , 'id');
	}
	/**
	 *	return object of Kabupaten_Model
	 **/
	public function Tempat(){
		return $this->belongsTo('Kabupaten_Model' , 'idtempat' , 'id');
	}

	/**
	 * get userr which has lesser power 
	 *return obj
	*/
	public function scopeGetlesserpowerid($query,$current_power){
        return $query->whereHas('admindgroup', function($q) use ($current_power){
            $q->where('power', '<', $current_power );
        });
	}
	/**
	 *	return object of Kabupaten_Model
	 **/
	public function Santri(){
		return $this->hasOne('Santri_Model' , 'idadmind' , 'id');
		//return $this->belongsTo('Santri_Model' , 'idadmind');
	}
	/**
	 *	Depreceated
	 * 	get userr which has no id in santri
	 * 	parameter is 0 or 1
	 *	return obj
	*/
	public function scopeGetstatussantri($query, $status = 0){
		return $query->has('santri' , '=', $status );
	}
	public function scopeStatusLimitation($query, $status){
		return $query->where('status', '=', $status );
	}	
}
