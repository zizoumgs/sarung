<?php
abstract class Admin_root extends root {
	protected $values  = array('min_power' => 1000 , 'id' => -1 , 'table_name' => "" ); 
	private $view = "";
    public function __construct(){
		$this->beforeFilter('auth');
    }
	abstract public function getIndex();
	//! you should override this class , because this will check admin`s power
	abstract protected function check_power_admin();
	/* override this if you are disagree with me*/
	//! if you dont disagree , please override this function on its child
	public function index( $param = array()){
		$content = "<h1>Welcome Admind </h1>";
        $data = array(
        	'body_attr'    => $this->get_body_attribute() , 
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $this->get_content()     ,
            'side'  => $this->get_side()
        );
        return View::make( $this->get_view() , $data);
	}
    protected function get_side(){}
    protected function get_footer(){ return " Powered By Itofu Manggisan ";}
    protected function get_additional_js(){}	
    protected function get_header(){}
	protected function set_view( $val ) { $this->view = $val;}
	protected function get_view() {return $this->view;}
	protected final function set_min_power($val){ $this->values ['min_power']  = $val ;}
	protected final function get_min_power() { return $this->values ['min_power'];}
	/**
	 *	This class should be used when you want id to your table
	 *	return integer id from selected table
	**/
	protected function get_id_from_save_id( $name_table  , $max_id){
		$id = 0 ;
		$result = SaveId::NamaTable( $name_table )->first();
		if ( $result ){
			$id =  $result->idtable;
		}
		else{
			$id = $max_id;
			$id++;
		}
		return $id;
	}
	/**
	 ** 	return object , you should do $obj->save inside transaction , see Admin_sarung_event on add Section
	***/
	protected function del_item_from_save_id( $table_name , $id_table){
   		$saveId = new SaveId();
        return $saveId->where('namatable' , '=' , $table_name)->where('idtable' ,'=' , $id_table )->first();
	}
	/**
	 * return object , you should do $obj->save inside transaction , see Admin_sarung_event on add Section
	**/
	protected function del_item_from_save_nis($session_name){
   		$saveId = new SaveId();
        return $saveId->where('namatable' , '=' , $table_name)->where('idtable' ,'=' , $id_table )->first();
	}
	/**
	 *	Call this everythime you have succeded to delete item
	 *	return obj
	*/
	protected function delete_db_admin_root($nama_table , $id_table){
		$user = new SaveId();
		$user->namatable = $nama_table;
		$user->idtable = $id_table;
		return $user;
		//$user->save();

	}
	/**
	 *	debreced
	 *	i will remove this
	*/
    protected function get_current_page( $name = "page"){
        $page = Input::get($name) ; 
        if( $page > 0)
            return ($page-1)* $this->get_total_jump();  
        return 0;  
    }

}
