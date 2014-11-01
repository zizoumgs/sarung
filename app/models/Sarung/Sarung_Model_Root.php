<?php
/* All model from sarung database will follow this class , so that we just change
  change here to impact to another class
*/
class Sarung_Model_Root extends Eloquent{
	protected $connection = 'fusarung';
	/*If you decided to use raw query , use below*/
	protected function get_db(){
		return "fusarung";
	}
	protected function get_db_name(){
		return "mgscom_ngoos";
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
