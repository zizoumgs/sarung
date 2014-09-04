<?php
abstract class Admin_root extends root {
	private $view = "";
    public function __construct(){
        
    }
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
	
	abstract protected function get_content();
	abstract protected function get_admin_url();
}
