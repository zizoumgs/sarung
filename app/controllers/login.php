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
			$content = "<h1>Welcome Admind </h1>";
			$content .= "<a href='logout' />LogOut</a>";
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
    protected function get_header(){        return '';    }
    protected function get_side(){}
    protected function get_footer(){}
    protected function get_additional_js(){}
}