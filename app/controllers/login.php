<?php
/**
 **	 kelas ini akan menunjukkan login form
***/
abstract class login_main extends root{
	protected $layout = 'main';
    public function __construct(){
        parent::__construct();
    }
	/**
	 *	To logout
	*/
	public function anyLogout(){
	    Auth::logout();
	    return Redirect::to('login');		
	}
	/**
	 *	get form login
	 *	return html login
	**/
	protected function getformlogin(){
		$url = url('login');
		$open_form = Form::open(array('url' => $url )) ;
		$hasil = sprintf('
			<div class="container">
				<div class="center">
					<img src="%4$s" alt="Sarung Icon" width=128 height=128 >
				</div>
				<div class="login">
				%5$s
					<div class="form-group">
						<label for="user_name">User Name</label>
						<input name="%1$s" type="text" class="form-control"  id="user_name" placeholder="User Name"  required>
					</div>
					<div class="form-group">
						<label for="password_name">Password</label>
						%2$s
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="%3$s" > <span class="item">Remember Me</span>
						</label>
					</div>
					<input type="submit" class="btn btn-primary" Value ="Login">
				%6$s
				<a href="'.URL::to('/').'" class="item">Back to Home</a>
				</div>
		    </div>
		',
		'username' 	,
		Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password'))	,
		'' 	,
		URL::to('/').'/asset/images/fatihulUlum1.gif' , 
		$open_form ,
		Form::close()
		);
		return $hasil ;
	}		
	/**
	*/
	public function index( $param = array() ){
		
	}
}
class login extends login_main {
	//! must be override
    public function __construct(){
        parent::__construct();
		$this->set_title('Login');
		//$this->set_body_attribute( " class='login_body' " );
    }
	protected function get_user_name(){ 		return Input::get('username'); 	}
	protected function get_password (){ 		return Input::get('password'); 	}
	protected function get_status(){
        $userdata = array(
            'email' 		=> 	 $this->get_user_name(),
            'password' 		=>  $this->get_password()
        );
		return (string) Auth::attempt($userdata);
	}
	public function anyLogin(){				return $this->anyIndex();	}
	/**
	 *	Default index for anything , post, get , etc
	 *	return login or welcome
	*/
    public function anyIndex( ){
		$content ;
		if( ! $this->get_status() ){
			$content = $this->getformlogin();
		}
		else{
			$content = $this->showWelcome();
		}
        $data = array(
        	'body_attr'    => $this->get_body_attribute() , 
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $content     ,
            'side'  => $this->get_side()
                        )    ;		
        return View::make('uang/index' , $data);
    }
	//! if succeded will take content in this function 
	private function showWelcome(){
		$content = "";
		$this->get_user_id();
		$power = $this->get_user_power();
		if($power == 1) {
			$content = sprintf ('<h1>Welcome %1$s </h1>' , $this->get_user_name() );
		}
		elseif($power < 1 && $power > 100) {
			$content = sprintf ('<h1>Welcome Admind %1$s </h1>' , $this->get_user_name() );
			$content .= $this->get_list_of_admin_url();
		}
		elseif( $power >= 1000) {
			$content = sprintf ('<h1>Welcome Super Admind %1$s  , You can do anything s in this application </h1>' , $this->get_user_name() );
			$content .= $this->get_list_of_admin_url();
		}
		else{
			//! we should send email to developer
			$content = sprintf ('<h1>There is error with this application </h1>' );
			$content .= $this->get_list_of_admin_url();
		}
		return $content;
		
	}
	/**
	 *	this will be welcome for our guest
	**/
	public function anyHome(){
		$content = "";
		$this->get_user_id();
		$power = $this->get_user_power();
		$content = sprintf('
			<h1 class="page-header text-center bold-font">Salam kaum bersarung</h1>
			<img class="thumbnail pull-left" src="%1$s" weight=150 height=150 style="margin:6px 15px 0px 0px">
			<p style="text-align:justify">Sarung adalah sebuah applikasi yang dibuat untuk pondok pesantren Fatihul Ulum Manggisan Tanggul Jember
			baik diniyah atau non diniyah(meskipun pada kenyataanya keduanya sama-sama diniyah).
			Kami memilih nama sarung dikarenakan beberapa alasan
			Pertama: sarung merupakan tradisi pondok pesantren dan merupakan tradisi indonesia yang tidak perlu untuk dihilangkan!.
			Titik berat pada applikasi ini adalah klasement yang sangat menentukan siapa yang naik dan siapa yang tidak di pondok pesantren ini.
			akan tetapi dalam applikasi ini juga ada fungsi-fungsi lain yang juga tidak kalah penting .
			Harapan dari applikasi ini adalah guru dan pengurus bisa dengan mudah meng-akses siapa yang perlu bimbingan lebih banyak dan
			dari sini guru bisa melihat kemampuan siswa dalam segala pelajaran dan bisa juga melihat tract record
			nilai siswa atau nilai kelas secara umum. kami sudah lelah menjadi sekolah <b>antah berantah</b>.</p>
		' , URL::to('/')."/asset/images/fatihulUlum1.gif");
        $data = array(
        	'body_attr'    => $this->get_body_attribute() , 
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $content     ,
            'side'  => $this->get_side()
                        )    ;		
        return View::make('main' , $data);
	}
	protected function get_list_of_admin_url(){
		$hasil = sprintf('<br>
		<p>Please click below link to send you to place where you have right to access it </p>
		<div class="list-group">
			<a href="%1$s" class="list-group-item">Uang</a>
			<a href="%2$s" class="list-group-item">Sarung</a>
			<a href="%3$s" class="list-group-item">Iman</a>
		</div>		
		' , helper_get_url_admin_uang() , helper_get_url_admin_sarung() , $this->get_url_admin_iman());
		return $hasil ;
	}
    protected function get_side(){}
    protected function get_footer(){}
    protected function get_additional_js(){}
	protected function get_additional_css(){
		return sprintf('
			   			<link href="%1$s/asset/css/fudc.css" rel="stylesheet" type="text/css"/>
						<style>
						.navbar-nav li a {
							line-height: 125px;
						}
						.page-header {
							border-bottom: none !important;
						}
						
						</style>
					   ' , $this->base_url() );
	}
	protected function get_header(){
		$menu_log = "";		
		if( ! Auth::check() ) {
			$menu_log = '<a href="#">Login</a>';
		}
		else{
			$url = url('login/logout');
			if($this->get_user_power()>10){
				$url = url('sarung_admin');
				$menu_log .= sprintf('<li><a href="%1$s" >Dashbord</a></li>' , $url);
			}
			$menu_log .= sprintf('<li><a href="%1$s" >LogOut</a></li>' , $url);
		}
		$hasil = sprintf('
		<div class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="page-header ">
						<h1>Fatihul Ulum Manggisan</h1>
						<p class="lead bold-font"><span class="glyphicon glyphicon-flash"></span>Nothing special with this boarding school.</p>
					</div> 			
				</div>
				<div class="navbar-collapse collapse menu2">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="%2$s">Home</a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Contact</a></li>
						%1$s
					</ul>
				</div><!--/.nav-collapse -->
			</div>			
		</div>						 
		' , $menu_log , url('home') );
		return $hasil;
	}
}