<?php
class Admin_sarung extends Admin_root{
	protected function set_id($val) {$this->values['id'] = $val;}
	protected function get_id(){ return $this->values['id'];}
	protected function set_table_name($val){$this->values ['table_name'] = $val ;}
	protected function get_table_name(){ return $this->values ['table_name'] ;}
	//! message make , as you can see that message is array
	public function make_message($messages){
		$message_outputs  = "";
		foreach( $messages as $message):	
			$message_outputs .= $message ;
		endforeach;
		return $message;
	}
    public function __construct(){
        parent::__construct();
		$this->set_default_value();
    }
    protected final function get_edit_delete_row($additional = ""){
        /*
        $edi = sprintf('<a href="%1$s/%2$s" class="btn btn-primary btn-xs" >Edit</a>'    , $this->get_url_admin_sarung()."/eventedit" , $additional );
        $del = sprintf('<a href="%1$s/%2$s" class="btn btn-info btn-xs">Delete</a>'      , $this->get_url_admin_sarung()."/eventdel" , $additional );
        */
        $edi = sprintf('<a href="%1$s/%2$s" class="btn btn-primary btn-xs" >Edit</a>'    , $this->get_url_this_edit() , $additional );
        $del = sprintf('<a href="%1$s/%2$s" class="btn btn-info btn-xs">Delete</a>'      , $this->get_url_this_dele() , $additional );
        return $edi."  ".$del;
    }
	
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 200 );
		$this->set_title('Admin Sarung Fatihul Ulum');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
    }
    /*All of */
    public function getIndex(){
		$content = "<h1>Assalamu alaikum Admin</h1>";
		$this->set_content($content);
        $this->set_default_value();
        return $this->index();
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
                    <a class="navbar-brand" href="#">Sarung | <small>Admin Sarung</small> </a>
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
		$this->get_url_admin_sarung()
		);
		return $hasil;
    }
	/*Header is important to decide which class should be entered by php*/
	protected function get_side(){
        $list_menu = "";
        $list_menu .=  sprintf('<li><a href="%1$s" rel="nofollow" class="title"><span class="glyphicon glyphicon-dashboard"></span> %2$s</a></li>',
							   $this->get_url_admin_sarung(),"Dashboard");
		$url = $this->get_url_admin_sarung();
        $list = array(
	        array('Event' 		,'<span class="glyphicon glyphicon-refresh"></span>'    , sprintf('%1$s'          		, $this->get_url_admin_event() )  ) ,
            array('Session'  	,'<span class="glyphicon glyphicon-tower"></span>'      , sprintf('%1$s'  	    		, $this->get_url_admin_session() ) ) ,
            array('Kalender'	,'<span class="glyphicon glyphicon-expand"></span>'     , sprintf('%1$s' 				, $this->get_url_admin_kalender() ) ),
			array('Divisi'		,'<span class="glyphicon glyphicon-user"></span>'       , sprintf('%1$s/divisi_crud'    , $this->get_url_admin_sarung() ) )
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
    protected function check_power_admin(){        return true;    }
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

	/* This class should be used when you want id to your table*/
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
	 * this function will combine two array which has same key
	*/
	protected function make_one_two_array( $ori_array , $mod_array){
        foreach ($ori_array as $key => $val ){
            if(array_key_exists ( $key , $mod_array )){
                $ori_array [$key] = $mod_array [$key] ;
            }
        }
		return $ori_array;
	}
}

