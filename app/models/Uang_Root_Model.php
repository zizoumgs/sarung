<?php
/**
 *  this class will be root for every uang model
**/
class Uang_Root_Model extends Eloquent {
	protected $connection = 'uang';
	protected $db_name = "test_1";
	protected static function get_db_name(){
		return "uang";
	}
}