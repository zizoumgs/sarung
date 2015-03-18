<?php 
abstract class admin extends Controller {
	private $value ;
	protected $helper ;
    public function __construct($min_power){
		$this->value = new stdClass();
		$this->set_error_message("Unknow Error");
    }
	protected function set_error_message( $message ){
		$this->value->error_db = $message ; 
	}
	public function get_error_message() {
		return $this->value->error_db;
	}
	
	public static function get_user_power() {
		if(Auth::user())
			return	Auth::user()->admindgroup->power;
		return 0;
	}
	public static function get_user_name_group() {
		if(Auth::user())
			return Auth::user()->admindgroup->nama;
		return 0;		
	}
	
    public static function get_id( $table_name , $max_id ){
		$id = 0 ;
		$result = SaveId::NamaTable( $table_name  )->first();
		if ( $result )
			return $result->idtable;
		else
			return $max_id + 1;
    }
	
   	protected function get_saveid_obj( $table_name , $id_table){
		$user = new SaveId();        
		$user->namatable = $table_name;
		$user->idtable = $id_table;
		return $user;
    }
	
	protected function multi_purpose_db($db_name , $save_objects , $del_objects){
		$pdo = DB::connection( $db_name )->getPdo();
		$pdo->beginTransaction();
		$status = false;
		try {
			//! for saving
			foreach( $save_objects as $obj){
				if($obj == null) {
					throw new Exception("There are non object");
				}
				$obj->save();
			}
			foreach( $del_objects as $obj){
				if($obj == null) {
					throw new Exception("There are non object");
				}
				$obj->delete();
			}		    
			$pdo->commit();
			$status = true;
		    // all good
		}
		catch (\Exception $e) {
			//$this->set_pdo_exception($e);
			$this->set_error_message($e->getMessage()) ;
		    //DB::rollback();
			$pdo->rollback();
		}
		return $status;		
	}
}