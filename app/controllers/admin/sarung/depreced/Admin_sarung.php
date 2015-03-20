<?php
/**
 *	This class will be removed
*/
abstract class  Admin_sarung_urls extends Admin_root {
	/**
	 *	return none
	 *	Will call @set_default_value()
	*/
    public function __construct(){
        parent::__construct();
	}
	protected function get_url_admind_event     ()   { 		return sprintf('%1$s/sarung_admin/event' , $this->base_url());}
	protected function get_url_admind_session   ()	{ 		return sprintf('%1$s/sarung_admin/session' , $this->base_url());}
	protected function get_url_admin_kalender_  () 	{ 		return sprintf('%1$s/sarung_admin/kalender' , $this->base_url());}
	protected function get_url_admin_pelajaran ()	{ 		return sprintf('%1$s/sarung_admin/pelajaran' , $this->base_url());}

	//protected function get_url_admin_class		()	{ 		return sprintf('%1$s/sarung_admin/class		' , $this->base_url());}
	
	protected function get_url_admin_jurusan   ()	{ 		return sprintf('%1$s/sarung_admin/jurusan' , $this->base_url());}
	protected function get_url_admin_kelas_root   ()	{ 	return sprintf('%1$s/sarung_admin/kelas_root' , $this->base_url());}
	//protected function get_url_admin_kelas		()	{ 		return sprintf('%1$s/sarung_admin/kelas' , $this->base_url());}
	protected function get_url_admin_wali		()	{ 		return sprintf('%1$s/sarung_admin/wali' , $this->base_url());}
	
	//protected function get_url_admin_ujian		()	{ 		return sprintf('%1$s/sarung_admin/ujian' , $this->base_url());}
	protected function get_url_admin_negara		()	{ 		return sprintf('%1$s/sarung_admin/negara' , $this->base_url());}
	protected function get_url_admin_propinsi	()	{ 		return sprintf('%1$s/sarung_admin/propinsi' , $this->base_url());}
	protected function get_url_admin_kabupaten	()	{ 		return sprintf('%1$s/sarung_admin/kabupaten' , $this->base_url());}
	protected function get_url_admin_kecamatan	()	{ 		return sprintf('%1$s/sarung_admin/kecamatan' , $this->base_url());}
	protected function get_url_admin_desa		()	{ 		return sprintf('%1$s/sarung_admin/desa' 	, $this->base_url());}
	//protected function get_url_admin_user		()	{ 		return sprintf('%1$s/sarung_admin/user' 	, $this->base_url());}
	protected function get_url_admin_santri		()	{ 		return sprintf('%1$s/sarung_admin/santri	' , $this->base_url());}
	protected function get_url_admin_ujis		()	{ 		return sprintf('%1$s/sarung_admin/ujis		' , $this->base_url());}
	protected function get_url_admin_sarung		()   { 		return helper_get_url_admin_sarung();}
	//@ larangan
	protected function get_url_admin_larangan_nama	($add="")	{		return URL::to("sarung_admin/tindakan$add");}
	protected function get_url_admin_larangan_meta	($add="")	{		return URL::to("sarung_admin/tindakan_meta$add");}
	protected function get_url_admin_larangan_kasus	($add="")	{		return URL::to("sarung_admin/tindakan_kasus$add");}
	
}
/**
 *	class for side
*/
abstract class  Admin_sarung_side_root extends Admin_sarung_urls{
	/**
	 *	return none
	 *	Will call @set_default_value()
	*/
    public function __construct(){
        parent::__construct();
	}
	/**
	 *	return all side html , will be used by all subclass admin sarung
	*/
	protected function get_side(){
        $list_menu = "";
        $list_menu .=  sprintf('<li><a href="%1$s" rel="nofollow" class="title"><span class="glyphicon glyphicon-dashboard"></span> %2$s</a></li>',
							   $this->get_url_admin_sarung(),"Dashboard");
		$url = $this->get_url_admin_sarung();
        $list = array(
	        array('Event' 		,'<span class="glyphicon glyphicon-refresh"></span>'    , sprintf('%1$s'    , $this->get_url_admin_event() )  ) ,
            array('Session'  	,'<span class="glyphicon glyphicon-tower"></span>'      , sprintf('%1$s'  	, $this->get_url_admin_session() ) ) ,
            array('Kalender'	,'<span class="glyphicon glyphicon-expand"></span>'     , sprintf('%1$s' 	, $this->get_url_admin_kalender() ) ) , 
			array('Pelajaran'	,'<span class="glyphicon glyphicon-copyright-mark"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_pelajaran() ) ) ,
			array('Jurusan'		,'<span class="glyphicon glyphicon-copyright-mark"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_jurusan() ) ) ,
			array('Kelas Root'	,'<span class="glyphicon glyphicon-copyright-mark"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_kelas_root() ) ) ,
			array('Kelas'		,'<span class="glyphicon glyphicon-copyright-mark"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_kelas() ) ) ,
			array('Wali'		,'<span class="glyphicon glyphicon-user"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_wali() ) ) ,
			array('Ujian'		,'<span class="glyphicon glyphicon-glass"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_ujian() ) ) , 
			array('User'		,'<span class="glyphicon glyphicon-user"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_user() ) ),
			array('Santri'		,'<span class="glyphicon glyphicon-user"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_santri() ) ),
			array('Class'		,'<span class="glyphicon glyphicon-inbox"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_class() ) )	,
			array('Ujian Santri','<span class="glyphicon glyphicon-pencil"></span>'   	, sprintf('%1$s'    , $this->get_url_admin_ujis() ) )
        );
		//@ address
        $list_menu .= $this->get_side_of_address();
		//@ iman
		$list_menu .= $this->get_side_of_larangan();
		//@
        foreach($list as $key => $val ){
           $list_menu .= sprintf('<li><a href="%1$s" rel="nofollow"> %2$s    %3$s</a></li>', $val [2] , $val [1] ,$val[0]) ;
        }
		//@
		$side = sprintf('
				<ul>%1$s</ul>
		',$list_menu);
		return $side;
	}
	/**
	 *	return html which contains address 
	*/
	private function get_side_of_address(){
        $menu  = sprintf('
            <a id="element" href="#" tabindex="0" 
                data-toggle="popover" 
                data-trigger="focus"
                data-html="true"
                title="<span class=\'title_side_content\'>Address</span>" 
                data-content="
                    <a class=\'inside_side_content\' href=\'%1$s\'><span class=\'glyphicon glyphicon-map-marker\'></span> Negara</a>
                    <a class=\'inside_side_content\' href=\'%2$s\'><span class=\'glyphicon glyphicon-map-marker\'></span> Propinsi</a>
                    <a class=\'inside_side_content\' href=\'%3$s\'><span class=\'glyphicon glyphicon-map-marker\'></span> Kabupaten</a>
					<a class=\'inside_side_content\' href=\'%4$s\'><span class=\'glyphicon glyphicon-map-marker\'></span> Kecamatan</a>
					<a class=\'inside_side_content\' href=\'%5$s\'><span class=\'glyphicon glyphicon-map-marker\'></span> Desa</a>
                "
                ><span class="glyphicon glyphicon-map-marker"></span>Address</a>
        ',
		$this->get_url_admin_negara()		,
		$this->get_url_admin_propinsi()		,
		$this->get_url_admin_kabupaten() 	,
		$this->get_url_admin_kecamatan() 	,
		$this->get_url_admin_desa()
		);
		//$this->js_additional .= '<script> $("#element").popover(); </script>';
		return sprintf('<li>%1$s</li>',$menu);
	}
	/**
	 *	side for larangan ,there will be there menus , larangan_nama , larangan_meta , larangan_kasus
	**/
	private function get_side_of_larangan(){
        $menu  = sprintf('
            <a id="element_larangan" href="#" tabindex="0" 
            data-toggle="popover" 
            data-trigger="focus"
            data-html="true"
            title="<span class=\'title_side_content\'>Larangan</span>" 
            data-content="
				<a class=\'inside_side_content\' href=\'%1$s\'><span class=\'glyphicon glyphicon-map-marker\'></span>Nama</a>
				<a class=\'inside_side_content\' href=\'%2$s\'><span class=\'glyphicon glyphicon-map-marker\'></span>Larangan</a>
				<a class=\'inside_side_content\' href=\'%3$s\'><span class=\'glyphicon glyphicon-map-marker\'></span>Kasus</a>
                "
            ><span class="glyphicon glyphicon-map-marker"></span>Larangan</a>
        ',
		$this->get_url_admin_larangan_nama(),
		$this->get_url_admin_larangan_meta(),
		$this->get_url_admin_larangan_kasus()
		);
		//$this->js_additional .= '<script> $("#element_larangan").popover(); </script>';
		return sprintf('<li>%1$s</li>',$menu);
		
	}	
    protected function get_additional_js(){
		return '<script> $("#element").popover(); </script> <script> $("#element_larangan").popover(); </script>';
	}
}
/**
 *
**/
class Admin_sarung extends Admin_sarung_side_root{
	protected function set_id($val) {$this->values['id'] = $val;}
	protected function get_id(){ return $this->values['id'];}
	/**
	***	will be used upon deleting
	***/
	protected function set_table_name($val){$this->values ['table_name'] = $val ;}
	protected function get_table_name(){ return $this->values ['table_name'] ;}
    /*
    *   set object of database
    *   this will get table of database
    */
    protected function set_model_obj($val){ $this->values ['model_obj_adm_sar'] = $val ;}
    /**
	 *	this will get table of database
	 *   return object
     **/
    protected function get_model_obj(){        return $this->values ['model_obj_adm_sar'] ;    }	
    /**
     *  return max id for particular table
    **/
    protected function get_max_id(){         return $this->get_model_obj()->max('id');    }	
	/**
	 *	return value from get or post
	*/
	protected function get_value($name){		return Input::get( $name );	}	
	/**
	 *	automatic call in contructor after calling set_defaul_value
	 *	return bool
	*/
	protected function check_power_admin(){
		if( $this->get_user_power() < $this->get_min_power()){
			Auth::logout();
			return Redirect::to('/login');			
		}
	}
	/**
	 * message make , as you can see that message is array
	 * i seldom use this
	 */ 
	public function make_message($messages){
		$message_outputs  = "";
		foreach( $messages as $message):	
			$message_outputs .= $message ;
		endforeach;
		return $message;
	}
	/**
	 *	Will call @set_default_value() and check_power_admind()
	 *	return none
	*/
    public function __construct(){
        parent::__construct();
		$this->set_default_value();
		$this->beforeFilter(function(){
			return $this->check_power_admin();
		});
    }
	/**
	 *	Usually it is used inside table view html
	 *	return add and edit html link
	*/
    protected function get_edit_delete_row($additional = ""){
        $edi = sprintf('<a href="%1$s/%2$s" class="btn btn-primary btn-xs" >Edit</a>'    , $this->get_url_this_edit() , $additional );
        $del = sprintf('<a href="%1$s/%2$s" class="btn btn-danger btn-xs">Delete</a>'      , $this->get_url_this_dele() , $additional );
        return $edi."  ".$del;
    }
	/**
	 *	execute automatically by constructor
	 *	return none
	*/
    protected function set_default_value(){
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 100 );
		$this->set_title('Admin Sarung Fatihul Ulum');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
    }
    /**
	 *	return index() 
	**/
    public function getIndex(){
		$content = "<h1>Assalamu alaikum Admin</h1>";
		$this->set_content($content);        
        return $this->index();
    }
	/**
	 *	return html div on top side of admin panel
	 *	
	*/
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
                        <li><a href="%4$s" rel="nofollow">Visit Site</a></li>
                        <li><a href="%5$s" rel="nofollow">Back up Database</a></li>
                        <li><a href="#" rel="nofollow">%2$s | %3$s</a></li>
		                <li><a href="%1$s" rel="nofollow"><span class="glyphicon glyphicon-log-in"> </span> Log out</a></li>
                    </ul>
                </div>
			</div>
		</nav>',
		root::get_url_logout(),
		$this->get_user_power() ,
		$this->get_user_name_group(),
		url("/"),
		root::get_url_backup()
		);
		return $hasil;
    }
	/**
	 *	return additonal css string
	*/
	protected function get_additional_css(){
		return sprintf(
		'
		<!-- additional css -->
		<link href="%1$s" rel="stylesheet" type="text/css"/>
		',
		$this->base_url().'/asset/css/admin.css'
		);
	}
	/**
	 *	return additional js string
	*/
    protected function get_additional_js(){
		return parent::get_additional_js();//$this->js_additional;
    }
	/**
	 * this function will combine two array which has same key
	 * return combinated arrays
	*/
	protected function make_one_two_array( $ori_array , $mod_array){
        foreach ($ori_array as $key => $val ){
            if(array_key_exists ( $key , $mod_array )){
                $ori_array [$key] = $mod_array [$key] ;
            }
        }
		return $ori_array;
	}
	/*
		return form-group class which will be containter for input html
	*/
    protected function get_input_cud_group( $label , $input ){
        return sprintf('
        <div class="form-group form-group-sm">
            <label class="col-sm-2 control-label " >%1$s</label>
            <div class="col-sm-8 ">
                %2$s
            </div>
        </div>' , $label , $input);
    }
}

