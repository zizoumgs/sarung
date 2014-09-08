<?php
abstract class Admin_root extends root {
	protected $values  = array('min_power' => 1000 ); 
	private $view = "";
    public function __construct(){
		$this->beforeFilter('auth');
		$this->beforeFilter(function(){
			//! you should override this class , because this will check admin`s power
			return $this->check_power_admin();
		});		
    }
	public function getIndex($param = array()){ return $this->index( $param); }
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
	protected  function set_view( $val ) { $this->view = $val;}
	public function get_view() {return $this->view;}
	protected final function set_min_power($val){ $this->values ['min_power']  = $val ;}
	protected final function get_min_power() { return $this->values ['min_power'];}
	
	abstract protected function get_admin_url();
	//! you should override this class , because this will check admin`s power
	abstract protected function check_power_admin();
	/* Call this everythime you have succeded to delete item*/
	public function delete_db_admin_root($nama_table , $id_table){
		$user = new SaveId;
		$user->namatable = $nama_table;
		$user->idtable = $id_table;
		$user->save();

	}
	//! about auth
	protected function get_user_id(){ return Auth::id() ; }
	protected function get_user_name() { return Auth::user()->email;}
	protected function get_user_power() {return Auth::user()->admindgroup->power;}
	protected function get_user_name_group() {return Auth::user()->admindgroup->nama;}
}
