<?php
/**
*	All class will be sub class to this class
* this is just definition , you can`t instant this class 
**/
abstract class root extends Controller {
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
			' ,
			URL::to('/').'/asset/css/normalize.css'					,
			URL::to('/').'/asset/css/reset.css'						,
			URL::to('/').'/asset/bootstrap/css/bootstrap.css'	 	, 
			URL::to('/').'/asset/bootstrap/css/bootstrap-theme.css'	,
			$this->get_additional_css()
			);
	}
	protected function get_js(){
		return sprintf('
			<script type="text/javascript" src="%1$s" ></script>
            <script type="text/javascript" src="%2$s" ></script>
            <script type="text/javascript" src="%3$s" ></script>
            %4$s
			' ,
			URL::to('/').'/asset/js/jquery-1.11.min.js'		,
			URL::to('/').'/asset/js/jquery-ui.js'			,
			URL::to('/').'/asset/bootstrap/js/bootstrap.js' , 
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
}
