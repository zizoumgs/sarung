<?php
//! kelas ini akan menunjukkan login form
class login extends root {
	//! must be override
    public function __construct(){
        parent::__construct();
		$this->set_title('Login');
		$this->set_body_attribute( " class='login_body' " );
    }
	private function get_login(){
		$open_form = "<form class='form-inline' name='' methode = 'post' action= 'login' role='form' > ";
		$open_form = Form::open(array('url' => '/login' )) ;
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
	protected function get_user_name(){ 		return Input::get('username'); 	}
	protected function get_password (){ 		return Input::get('password'); 	}
	protected function get_status(){
        $userdata = array(
            'email' 		=> 	 $this->get_user_name(),
            'password' 		=>  $this->get_password()
        );
		return (string) Auth::attempt($userdata);
        //return Auth::attempt($userdata);
		/*
		dd(Input::all());		
		dd( Auth::attempt($userdata) );
		*/
	}
	
	
    public function index( $param = array() ){
		$content ;
		if( ! $this->get_status() ){
			$content = $this->get_login();
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
		$content .= "<a href='logout' >LogOut</a>";
		return $content;
		
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
    protected function get_header(){        return '';    }
    protected function get_side(){}
    protected function get_footer(){}
    protected function get_additional_js(){}
	protected function get_additional_css(){
		return sprintf('
			   			<link href="%1$s/asset/css/fudc.css" rel="stylesheet" type="text/css"/>
					   ' , $this->base_url() );
	}
}