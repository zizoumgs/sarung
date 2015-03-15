<?php 
abstract class admin extends Controller {
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
	
   	public static function get_saveid_obj( $table_name , $id_table){
		$user = new SaveId();        
		$user->namatable = $table_name;
		$user->idtable = $id_table;
		return $user;
    }

	public static function will_change_to_db( $db_name ){
		$pdo = DB::connection( $db_name )->getPdo();
		$pdo->beginTransaction();
		//DB::beginTransaction();
		$status = false;
		try {
			//! for saving
			foreach( $this->get_obj_save_db() as $obj){
				if($obj == null) {
					throw new Exception("There are non object");
				}
				$obj->save();
			}
			foreach( $this->get_obj_dele_db() as $obj){
				if($obj == null) {
					throw new Exception("There are non object");
				}
				$obj->delete();
			}		    
		    //DB::commit();
			$pdo->commit();
			$status = true;
		    // all good
		}
		catch (\Exception $e) {
			$this->set_pdo_exception($e);
			$this->set_error_message($e->getMessage()) ;
		    //DB::rollback();
			$pdo->rollback();
		}
		return $status;
	}    
}