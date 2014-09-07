<?php
/**
*	All class will be sub class to this class
* this is just definition , you can`t instant this class 
**/
abstract class root extends Controller {
	private $js , $css;
	private $title = "";
	protected $category = "";
	private $body_attribute = "";
	
	abstract protected function get_header();
	abstract protected function get_footer();
	abstract public function index( $param = array() ) ; 
	abstract protected function get_additional_js();
	
	public function __construct(){}
	protected function  set_title($val){		$this->title = $val;	}
	protected function get_title(){ 		return $this->title;	}
	protected function  set_category($val){ 		$this->category = $val;	}
	protected function get_category(){ 		return $this->$this->category;	}	
	protected function get_css(){
		return sprintf('
			<link href="%1$s" rel="stylesheet" type="text/css" />
			<link href="%2$s" rel="stylesheet" type="text/css"	/>
			<link href="%3$s" rel="stylesheet" type="text/css"/>
			<link href="%4$s" rel="stylesheet" type="text/css"/>
			%5$s
			%6$s
			' ,
			URL::to('/').'/asset/css/normalize.css'					,
			URL::to('/').'/asset/css/reset.css'						,
			URL::to('/').'/asset/bootstrap/css/bootstrap.css'	 	, 
			URL::to('/').'/asset/bootstrap/css/bootstrap-theme.css'	,
			$this->css , 
			$this->get_additional_css()
			);
	}
	protected function get_js(){
		return sprintf('
			<script type="text/javascript" src="%1$s" ></script>
            <script type="text/javascript" src="%2$s" ></script>
            <script type="text/javascript" src="%3$s" ></script>
            %4$s
			%5$s
			' ,
			URL::to('/').'/asset/js/jquery-1.11.min.js'		,
			URL::to('/').'/asset/js/jquery-ui.js'			,
			URL::to('/').'/asset/bootstrap/js/bootstrap.js' ,
			$this->js ,
			$this->get_additional_js()
			);
	}
	protected function get_additional_css(){
		return sprintf(
		'<link href="%1$s" rel="stylesheet" type="text/css"/>',
		URL::to('/').'/asset/css/fudc.css'
		);
	}
	protected function get_total_jump(){		return 15;	}
	protected function base_url(){		return URL::to('/');	}
    protected function get_select( $items  , $array = array() ){
		$attribute_select ="" ;
		foreach($array as $key => $val){
			if( $key != "selected")
				$attribute_select .= sprintf( ' %1$s = "%2$s" ' , $key , $val );
		}
		$select = sprintf('<select %1$s >' , $attribute_select);
        foreach ( $items as $key => $value) {
        	$selected = "";
        	if($value == $array ['selected']){
        		$selected = ' selected="selected" ' ;
        	}
            $select .= sprintf('<option value="%2$s" %3$s >%2$s</option>',$key,$value , $selected );
        }
        $select .= "</select>";
        return $select;
    }	
    protected function set_body_attribute($attr){		$this->body_attribute = $attr;    }
    protected function get_body_attribute(){return $this->body_attribute ; }
	/*IF you wanna use input with date , call this function to include required file , both js and css */
	protected function set_input_date( $input , $with_jquery_ui = true){
		if($with_jquery_ui):
			$this->css  .= sprintf('<link rel="stylesheet" 			href="%1$s/asset/jquery/jquery_ui/themes/smoothness/jquery-ui.css">',	URL::to('/') );
			$this->js	.= sprintf('<script type="text/javascript" 	src="%1$s/asset/jquery/jquery_ui/jquery-ui.js"></script>' 			, 	URL::to('/') );
		endif;

		$this->js .= sprintf('
		<script>$(function() {
			$( "%1$s" ).datepicker(
			{
				changeMonth: true,changeYear: true ,
				dateFormat: "yy-mm-dd",
			}
			);
			//! prevent from click
			$(".disabled").click(function(e){e.preventDefault();return false;});
		});
		</script>' ,$input );
	}
	/**
	 *	You should setting on app.config/mail.php like following 
		return array('driver' => 'smtp','host' => 'smtp.gmail.com', 'port' => 587,
			'from' => array('address' => 'authapp@awesomeauthapp. com', 'name' => 'Awesome Laravel 4 Auth App'),
		    'encryption' => 'tls', 'username' => 'your_gmail_username', 'password' => 'your_gmail_password',
		    'sendmail' => '/usr/sbin/sendmail -bs', 'pretend' => false, 
		);
	*/
	protected function send_email( $data , $view = 'emails/info'){
		Mail::send( $view, $data, function($message) {
			//$message->to('zizoumgs@gmail.com' , 'Zizou Mgs Sakip ')->subject( 'Assalamu alaikum' );
			$message->subject( 'Assalamu alaikum');
			$message->to('zizoumgs@gmail.com' , 'Zizou Mgs Sakip ') ;
		});		
	}
	protected function get_rupiah_root( $angka){
		return number_format($angka,2,',','.');
	}
	/*Nama yang akan dikirimi email*/
	protected function get_nama_to_email(){
		return "Syafii";
	}
	
}
