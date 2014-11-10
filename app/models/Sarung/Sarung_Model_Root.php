<?php
/* All model from sarung database will follow this class , so that we just change
  change here to impact to another class
*/
class Sarung_Model_Root extends Eloquent{
	protected $connection = 'fusarung';
	/*If you decided to use raw query , use below*/
	public static function get_db(){
		return Config::get('database.main_db');
		//return "fusarung";
	}
	public static function get_db_name(){
		return Config::get('database.connections.fusarung.database');
		//return "mgscom_ngoos";
	}	
	/**
	*	will check and return valid value
	*	return -1 if null , id number otherwise
	**/
	protected function check_and_get_id($obj){
		if( $obj->first()){
			return $obj->first()->id;
		}
		return -1;
	}
}
