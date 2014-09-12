<?php
/**
 *	This class will be parent for every administrator uang
*/
class Admin_uang extends Admin_root{
    protected $name_division , $name_division_sub ;
	protected function set_name_division($val) {$this->name_division = $val;}
	protected function set_name_division_sub($val) {$this->name_division_sub = $val;}
    protected function get_name_division(){ return $this->name_division ; }
    protected function get_name_division_sub(){ return $this->name_division_sub ; }
    protected function get_selected_division(){        return Input::get( $this->name_division );    }
    protected function get_selected_division_sub(){    return Input::get( $this->name_division_sub );  }
	public function getIndex(){}
	
	private function set_attribute_on_select( $from , $to ){
        foreach ( $from as $key => $value) {
            if( ! array_key_exists( $key , $to )){
                $to [$key] = $value;
            }
        }
		return $to;
	}
    protected function get_select_divisi( $array = array() , $items = array()){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'divisi');
        foreach ( $default as $key => $value) {
            if( array_key_exists($key , $array)){
                $default [$key] = $array [$key] ;
            }
        }
		$array = $this->set_attribute_on_select( $default , $array );
        $this->name_division = $default ['name'] ; 
        $array ['selected'] = $this->get_selected_division();
		if( count ($items) <= 0 ):
        $posts = DB::select(DB::raw('
            select divi.id as id , divi.nama as nama_div
            from divisi divi 
            order by nama_div')
        );
        $items = array("All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama_div ; 
        }
		endif;
        return $this->get_select( $items , $array ) ;
    }
    protected function get_select_divisi_sub( $array = array() , $items = array() ){
        $default = array( "class" => "selectpicker" ,
							"id" => "" ,
							"name" => "divisi_sub"  
						 );
		$array = $this->set_attribute_on_select( $default , $array );
        $this->name_division_sub = $array ['name'] ; 		
		$array ["selected"] = $this->get_selected_division_sub();
        //! for selected item
		if( count ($items) <= 0 ):
        $posts = DB::select(DB::raw('
            select divis.id as id , divis.nama as nama_div 
            from divisisub divis 
            group by nama_div
            order by divis.id DESC')
        );
        $items = array( '' => "All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama_div ; 
        }
		endif;
        return $this->get_select( $items , $array) ;
    }
	
    public function __construct( $params = array( 'min_power' => 1000  )){
        parent::__construct( $params);
		$this->after_construct();
		$this->beforeFilter(function(){
			return $this->check_power_admin();
		});		
		
		$this->set_title('Admin Uang Fatihul Ulum');
		$this->set_body_attribute( " class='admin admin_uang_body' " );
		$this->set_view ('uang/admin/index'); 
    }
	//! you can override this if you wanna something different
	//! @ see constructor function from Admin_root
	protected function check_power_admin(){
		if( $this->get_user_power() < $this->get_min_power()){
			return Redirect::to('/login');			
		}
	}
	protected function get_content(){
		$hasil = '<div class="thumbnail">
		<h2>Welcome %1$s</h2>
		<p><b>Your Last Login was</b> %2$s</p>
		<p><b>Your Power is </b> %3$s</p>
		<p><b>Your group is </b> %4$s</p>
		</div>';
		return sprintf( $hasil ,
					   $this->get_user_name()	,
					   Auth::user()->last_login ,
					   $this->get_user_power()  ,
					   $this->get_user_name_group());
		
	}
	protected function get_header(){
		$hasil = sprintf('
		<nav class="navbar navbar-inverse top-header" role="navigation">
            <div class="container-fluid">
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
	                    <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Sarung | <small>Admin Uang</small> </a>
                </div>
                <div class="collapse navbar-collapse">
	                <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="%4$s" rel="nofollow" target="_blank">Visit Site</a></li>
                        <li><a href="#" rel="nofollow">Back up Database</a></li>
                        <li><a href="#" rel="nofollow">%2$s | %3$s</a></li>
		                <li><a href="%1$s" rel="nofollow">Log out</a></li>
                    </ul>
                </div>
			</div>
		</nav>',
		URL::to('/')."/logout" ,
		$this->get_user_power() ,
		$this->get_user_name_group(),
		$this->get_url_uang()
		);
		return $hasil;
	}

	/*Header is important to decide which class should be entered by php*/
	protected function get_side(){
        $list_menu = "";
        $list_menu .=  sprintf('<li><a href="%1$s" rel="nofollow" class="title"><span class="glyphicon glyphicon-dashboard"></span> %2$s</a></li>',
							   $this->get_admin_url(),"Dashboard"); 
        $list = array(
	        array('Outcome' 	,'<span class="glyphicon glyphicon-refresh"></span>'    , sprintf('%1$s/outcome' , $this->get_admin_url() )  ) ,
            array('Income'  	,'<span class="glyphicon glyphicon-cutlery"></span>'    , sprintf('%1$s/income'  	, $this->get_admin_url() ) ) ,
            array('Subdivisi'	,'<span class="glyphicon glyphicon-expand"></span>'     , sprintf('%1$s/subdivisi_crud' , $this->get_admin_url() ) ),
			array('Divisi'		,'<span class="glyphicon glyphicon-user"></span>'       , sprintf('%1$s/divisi_crud' , $this->get_admin_url() ) )
                      );
        foreach($list as $key => $val ){
           $list_menu .= sprintf('<li><a href="%1$s" rel="nofollow"> %2$s    %3$s</a></li>', $val [2] , $val [1] ,$val[0]) ;
        }
        $menu  = '
            <a id="element" href="#" tabindex="0" 
                data-toggle="popover" 
                data-trigger="focus"
                data-html="true"
                title="<span class=\'title_side_content\'>Dismissible popover</span>" 
                data-content="
                    <a class=\'inside_side_content\' href=\'#\'>Fudc</a>
                    <a class=\'inside_side_content\' href=\'#\'>Fudc</a>
                    <a class=\'inside_side_content\' href=\'#\'>Fudc</a>
                "
                >Dismissible popover</a>

        ';
        $list_menu .= sprintf('<li>%1$s</li>', $menu) ;
		$side = sprintf('
				<ul>%1$s</ul>
		',$list_menu);
		return $side;
	}
	protected function get_additional_css(){
		return sprintf(
		'
		<!-- additional css -->
		<link href="%1$s" rel="stylesheet" type="text/css"/>
		',
		URL::to('/').'/asset/css/admin.css'
		);
	}
    protected function get_additional_js(){
		$js = sprintf('
			<!-- additional css -->
            <script>
	            $("#element").popover();
            </script>
			',
			$this->base_url()
			);
		return $js;
    }
	
	//! penting
	protected function get_admin_url(){		return sprintf('%1$s/admin_uang' , $this->base_url() ) ;	}
	//! message make , as you can see that message is array
	public function make_message($messages){
		$message_outputs  = "";
		foreach( $messages as $message):	
			$message_outputs .= $message ;
		endforeach;
		return $message;
	}	
}

