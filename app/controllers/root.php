<?php
/**
*	All class will be sub class to this class
* this is just definition , you can`t instant this class 
**/
abstract class root_depreated extends Controller{
	private $js , $css  , $header , $content , $footer , $side;
	private $title = "" , $value = array( 'jump' => 15  );
	protected $category = "";
	private $body_attribute = "";
	
	abstract public function index( $param = array() ) ; 
	protected function get_additional_css(){}
	
	protected function get_additional_js(){}
	public function __construct(){}
	protected function  set_title($val){		$this->title = $val;	}
	protected function get_title(){ 		return $this->title;	}
	protected function  set_category($val){ 		$this->category = $val;	}
	protected function get_category(){ 		return $this->$this->category;	}
	protected function set_content($val){ $this->content = $val ;}
	protected function get_content() { return $this->content;}
	protected function set_header ($val) { $this->header = $val ;}
	protected function get_header ()	{ return $this->header ; }
	protected function set_footer ($val) { $this->footer = $val ;}
	protected function get_footer () { return $this->footer ; }
	protected function set_css ($val) { $this->css .= $val;}
	/**
	 *	Will add js
	 *	return none
	*/
	protected function set_js  ($val) { $this->js .= $val ; }
	/**
	 *	return side html
	*/		
	protected function get_side(){ return $this->side;}
	/**
	 *	set html of side
	 *	return none
	*/	
	protected function set_side($val) { $this->side = $val;}
	/**
	 *	Will get css that you choosed / additional css
	 *	return your css
	*/
	protected function get_css_only(){ return $this->css;}
	/**
	 *	Will get js that you choosed / additional js
	 *	return your js
	*/
	protected function get_js_only (){ return $this->js;}
	/**
	 *	Will get css
	 *	Deprecated
	 *	return css
	*/	
	protected function get_css(){
		return sprintf('
			<link href="%1$s" rel="stylesheet" type="text/css"/>
			<link href="%2$s" rel="stylesheet" type="text/css"/>			
			%3$s
			%4$s
			' ,
			URL::to('/').'/asset/bootstrap/css/bootstrap.css'	 	, 
			URL::to('/').'/asset/bootstrap/css/bootstrap-theme.css'	,
			$this->css , 
			$this->get_additional_css()
			);
	}
	/**
	 *	Will get js 
	 *	Deprecated
	 *	return js
	*/
	protected function get_js(){
		return sprintf('
			<script type="text/javascript" src="%1$s" ></script>
            <script type="text/javascript" src="%2$s" ></script>
            <script type="text/javascript" src="%3$s" ></script>
			<script type="text/javascript" src="%4$s" ></script>
            %5$s
			%6$s
			' ,
			URL::to('/').'/asset/js/jquery-1.11.min.js'		,
			URL::to('/').'/asset/js/jquery-ui.js'			,
			URL::to('/').'/asset/bootstrap/js/bootstrap.js' ,
			URL::to('/').'/asset/js/sarung.js' 	,
			$this->js ,
			$this->get_additional_js()
			);
	}
	/**
	 *	it will be need by pagination
	 *	Deprecated
	 *	return jump value
	*/	
	protected function get_total_jump(){		return $this->value ['jump'];	}
	/**
	 *	it will be need by pagination
	 *	Depreced
	*/	
	protected function set_total_jump($val) { $this->value ['jump'] = $val ; }
	/**
	 *	in order to make as close as possible to codeigniter
	 *	return string 
	*/	
	public static  function base_url(){		return URL::to('/');	}
	/**
	 *	folder in which js laid
	 *	Depreced
	 *	return string 
	*/	
	protected function get_url_js(){		return $this->base_url()."/asset/js";	}
	/**
	 *	value and text is differect
	 *		 *	Depreced
	 *	return html select 
	*/	
    protected function get_select_by_key ( $items  , $array = array() , $disabled = ""){
		$attribute_select ="" ;
		foreach($array as $key => $val){
			if( $key != "selected")
				if($key != "disabled"){
					$attribute_select .= sprintf( ' %1$s = "%2$s" ' , $key , $val );
				}
		}
		$select = sprintf('<select %1$s %2$s>' , $attribute_select , $disabled);
        foreach ( $items as $key => $value) {
        	$selected = "";
        	if($key == $array ['selected']){
        		$selected = ' selected="selected" ' ;
        	}
            $select .= sprintf('<option value="%1$s" %3$s >%2$s</option>',$key,$value , $selected );
        }
        $select .= "</select>";
        return $select;
    }
	/**
	 *	value and text is same
	 *	return html select 
	*/	
    protected function get_select( $items  , $array = array() , $disabled = ""){
		$attribute_select ="" ;
		foreach($array as $key => $val){
			if( $key != "selected")
				if($key != "disabled"){
					$attribute_select .= sprintf( ' %1$s = "%2$s" ' , $key , $val );
				}
		}
		$select = sprintf('<select %1$s %2$s>' , $attribute_select , $disabled);
        foreach ( $items as $key => $value) {
        	$selected = "";
        	if($value == $array ['selected']){
        		$selected = ' selected ' ;
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
	/*
		If you wanna use another select  which is not same with default select in html , you just call this function
		@variable = js , css
		return none
	*/
	protected function use_ckEditor( $input = '.ckeditor' , $with_jquery_ui = true){
		$this->js  .= sprintf('<script type="text/javascript" src="%1$s/asset/ckEditor/ckeditor.js"></script>',$this->base_url()); 
	}	
	/*
		If you wanna use another select  which is not same with default select in html , you just call this function
		@variable = js
		return none 
	*/
	protected function use_select( $input = '.selectpicker' , $with_jquery_ui = true){
		if($with_jquery_ui){
			$this->css .= sprintf('<link href="%1$s" rel="stylesheet" type="text/css"/>',URL::to('/').'/asset/bootstrap/css/bootstrap-select.css');
			$this->js  .= sprintf('<script type="text/javascript" src="%1$s/asset/bootstrap/js/bootstrap-select.js"></script>',$this->base_url()); 
		}
		$this->js .= sprintf(
				'<script type="text/javascript">
					$(function() { $("%1$s").selectpicker("show");	});
				</script>',$input);
		
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
		Queue::push(function($job) use ($data , $view){
			Mail::send( $view, $data, function($message) {
				//$message->to('zizoumgs@gmail.com' , 'Zizou Mgs Sakip ')->subject( 'Assalamu alaikum' );
				$message->subject( 'Assalamu alaikum');
				$message->to('zizoumgs@gmail.com' , 'Zizou Mgs Sakip ') ;
			});
			$job->delete();
		});
	}	
}
abstract class root extends root_depreated {
	protected function get_rupiah_root( $angka){
		return number_format($angka,0,',','.');
	}
	/*the name who will be sent email */
	protected function get_nama_to_email(){
		return "Syafii";
	}
	protected function get_current_page(){
       $page = Input::get( 'page') ; 
        if( $page > 0)
            return (Input::get( 'page')-1)* $this->get_total_jump();  
        return 0;  		
	}
	protected function get_link_must_root(){
		$pertama = sprintf(
			'<div class="bg-warning col-md-3 col-md-offset-1"><h2>Uang</h2>
			<p>Uang adalah applikasi untuk mengetahui keluar masuknya uang Fatihul Ulum</p>
			<a href="#">Go to here </a></div>
			');
		$sarung = sprintf(
			'<div class="bg-info col-md-3"><h2>Sarung</h2>
			<p>Sarung adalah applikasi yang dikhususkan untuk sekolah Fatihul Ulum</p>
			<a href="#">Go to here </a></div>
			');
		$iman = sprintf(
			'<div class="col-md-3 bg-danger"><h2>Iman</h2>
			<p>Iman adalah applikasi yang dikhususkan untuk pesantrennya</p>
			<a href="#">Go to here </a></div>
			');		
		return sprintf('<div class="container"><div class="row link_must">%1$s %2$s %3$s</div></div>',$pertama , $sarung , $iman);
	}
	//! about auth
	protected function get_user_id(){ return Auth::id() ; }
	protected function get_user_name() { return Auth::user()->email;}
	protected function get_user_email() { return Auth::user()->email;}
	protected function get_user_names() { return Auth::user()->first_name ." ".Auth::user()->second_name;}
	/**
	 *	take user power
	 *	return user power or 0;
	*/
	public static function get_user_power() {
		if(Auth::user())
			return	Auth::user()->admindgroup->power;
		return 0;
	}
	protected function get_user_name_group() {return Auth::user()->admindgroup->nama;}
	/**
	 *	get url_admind uang
	 *	You should set up anymore on routes.php in order to make laravel know where it should be routed
	 *	And finally you should write it on Admin_sarung.php in order to make link on side of admin panel
	*/
	protected function get_url_admin_iman   	()   { 		return sprintf('%1$s/admin_iman' , $this->base_url());}
	//protected function get_url_uang				()	 {       return sprintf('%1$s/uang' , $this->base_url()); }
	/* Use this function to get pagination , you should use clas which is inheritanced by eloquent as an obj */
	protected function get_pagination_link($obj , $wheres = array()){
		return $obj->appends( $wheres )->links();
	}
	/*Compare selected date with current data*/
	protected function get_datediff($choice , $selected_date){
		$date1 = $selected_date;
		$date2 = date('Y-m-d h:i:s ', time());
		$diff = abs(strtotime($date2) - strtotime($date1));
		$diff = abs(strtotime($date2) - strtotime($date1));
		//! return day
		if($choice == 0 )
			return floor($diff/86400);
		return "Please Insert 0 as a first parameter";
	}
	/*		all static link	*/
	public static function get_url_klasement(){		return url('klasement');	}
	public static function get_url_score(){		return url('score');	}
	public static function get_url_home(){		return url('/');	}
	public static  function get_url_logout(){		return url('login/logout');	}
	public static  function get_url_admind(){		return url('sarung_admin');	}
	public static  function get_url_login(){		return url('trylogin');	}
	public static  function get_url_backup(){		return url('backupdb');	}
	public static  function get_url_uang	($add=""){		return url('uang'.$add);	}
	public static  function get_url_admin_event	( $add=""){		return url("sarung_admin/event/".$add);	}
	public static  function get_url_admin_session	($add=""){		return url("sarung_admin/session/".$add);	}
	public static  function get_url_admin_kalender	($add=""){		return url("sarung_admin/kalender/".$add);	}
	public static  function get_url_admin_ujian		($add=""){		return url("sarung_admin/ujian/".$add);	}
	public static  function get_url_admin_kelas_isi	($add=""){		return url("sarung_admin/kelas_isi/".$add);	}
	public static  function get_url_admin_user		($add=""){		return url("sarung_admin/user/".$add);	}
	public static  function get_url_admin_santri	($add=""){		return url("sarung_admin/santri/".$add);	}
	public static  function get_url_admin_ujis		($add=""){		return url("sarung_admin/ujian_santri/".$add);	}
	public static  function get_url_admin_nama_pelanggaran		($add=""){		return url("sarung_admin/nama_pelanggaran/".$add);	}
	public static  function get_url_admin_larangan_meta		($add=""){		return url("sarung_admin/larangan_meta/".$add);	}
	public static  function get_url_admin_larangan_kasus		($add=""){		return url("sarung_admin/larangan_kasus/".$add);	}

	public static  function get_url_profile		($add=""){		return url("profile/".$add);	}
	
	public static function get_url_base(){ return URL::to('/') ;}
	public static function get_path_base(){ return public_path()  ;}
	
	private static function get_old_or_future( $diffday){
		if( $diffday >= 0 ){
			return " Ago ";
		}
		return " Left ";
	}
	public static  function get_diff_date	($time_){
		$datediff = time() - strtotime ($time_);
		$total = floor($datediff/(60*60*24));
		$future_or_no = self::get_old_or_future( $total );
		//$future_or_no = $total;
		if( ($total < 1) && ($total) > -7 ){
			return "Just Now" . $future_or_no;
		}
		$total = abs ($total );
		if( $total < 7){
			return $total ." Days ".$future_or_no ;
		}
		elseif($total < 30){
			return floor($total/7) ." weeks ".$future_or_no ; 
		}
		elseif($total < 365){
			return floor($total/30) ." Months ".$future_or_no ; 
		}
		else{
			return floor($total/365) ." Years ".$future_or_no ; 
		}
	}

	/**
	 *	To back up 
	*/
	public static function anyBackupdb(){
		root::backup_tables('localhost',Config::get("database.main_db"));
		return;
		//$backup = new BACKUP\Backup();
		try {
			$date = date("d_M_Y_h_i_s");
			$path = public_path()."\backup";
		    $dump = new Ifsnop\Mysqldump\Mysqldump('mgscom_ngoos', Config::get("database.connections.fusarung.username"),
												   Config::get("database.connections.fusarung.password") );
			if(!File::exists($path)) {
				File::makeDirectory( $path );
			}
			foreach( Config::get('database.backupdb') as $db ){
			    $dump->start( $path . "\\$db-$date.sql");				
			}
		} catch (\Exception $e) {
		    echo 'mysqldump-php error: ' . $e->getMessage();
		}
	    return Redirect::to( root::get_url_admind());
	}
	/* backup the db OR just a table */
	public static function backup_tables($host,$name,$tables = '*')	{
		$user = Config::get("database.connections.fusarung.username");
		$pass = Config::get("database.connections.fusarung.password");
		//$link = mysql_connect($host,$user,$pass);
		//$link = DB::connection("database.main_db")->getPdo();
		//mysql_select_db($name,$link);
	
		//get all of the tables
		if($tables == '*')	{
			$tables = array();
			//$result = mysql_query('SHOW TABLES');
			$result = DB::connection($name)->select( DB::raw("select * from information_schema.tables where table_schema='mgscom_ngoos'"));
			foreach($result as $row){
				$tables[] = $row->TABLE_NAME;
			}
		}
		else{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//cycle through
		foreach($tables as $table){
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE IF EXISTS '.$table.' IF;';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
		
			for ($i = 0; $i < $num_fields; $i++) 		{
				while($row = mysql_fetch_row($result))			{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 				{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		//save file
		$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
		fwrite($handle,$return);
		fclose($handle);
	}	
}
