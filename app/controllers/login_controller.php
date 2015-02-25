<?php
class Login_controller extends Controller{
	public function getIndex(){
		$wheres = array ();
        $posts = array ();
		return View::make('login.login', array('posts' => $posts , 'wheres' => $wheres ));
	}
    public function anyLogin(){
        return $this->getIndex();
    }
    public function anyLogout(){
	    Auth::logout();
	    return Redirect::to( URL::to('/login') );
    }
	public function anyTrylogin(){
        $userdata = array(
            'email' 		=> 	Input::get('user_name') ,
            'password' 		=>  Input::get('password')
        );
		if ( ! (string) Auth::attempt($userdata) ){
            return Redirect::to( "/login" )->with('message', 'Login Failed');
		}
		else{
			return Redirect::to( URL::to('/') );
		}
    }    
}