<?php
/**
 **	 kelas ini akan menunjukkan login form
 **	
***/
abstract class login_main extends root{
	protected $layout = 'main';
    public function __construct(){        parent::__construct();    }
	/**
	 *	get header
	 *	return html form
	**/
	public function get_header(){	return root::get_common_menu();}
	/**
	*/
	public function index( $param = array() ){	}
}
/**
 *	class login
 *	parent class : klasement.php
 *	To do: protect from brute force	: https://laracasts.com/forum/?p=2268-brute-force-attacks/0
*/
class login extends klasement {
	//! must be override
    public function __construct(){
        parent::__construct();
		$this->set_title('Login');
		//$this->set_body_attribute( " class='login_body' " );
    }

	protected function get_user_name(){ 		return Input::get('username'); 	}
	protected function get_password (){ 		return Input::get('password'); 	}
	/**
	 *	get form login
	 *	return html login
	**/
	protected function getformlogin(){
		$open_form = Form::open(array('url' => $this->get_url_login() )) ;
		$hasil = sprintf('
		<div class="container">
			<div class="row">	
				<div class="col-md-3 col-md-offset-4 login-area">
				%5$s
				<!--
				<div class="col-md-4">
					<img src="%4$s" alt="Sarung Icon" width=128 height=128 >
				</div>
				-->
					<div class="form-group">
					</div>
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
		</div>
		'												,
		'username' 										,
		Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password'))	,
		'' 												,
		URL::to('/').'/asset/images/fatihulUlum1.gif' 	, 
		$open_form 										,
		Form::close()
		);
		return $hasil ;
	}
	/**
	 **	try to login
	 **	return false or true
	 **/
	public function anyTrylogin(){
        $userdata = array(
            'email' 		=> 	 $this->get_user_name(),
            'password' 		=>  $this->get_password()
        );
		$result =  (string) Auth::attempt($userdata);
		return Redirect::to( "/login" )->with('message', 'Login Failed');
		if ( ! $result ){
			return Redirect::to( root::get_url_login());//->with('message', 'Login Failed');
		}
		else{
			return $this->anyLogin();
		}
	}
	/**
	 *	login view
	 *	return ?
	**/	
	public function anyLogin(){
		$content ;
		if( ! Auth::check() ){			
			$content = $this->getformlogin();
		}
		else{
			$content = $this->showWelcome();
		}
		return $this->show($content);
	}
	/**
	 *	get view and show
	 *	return view
	*/
	protected function show($content){
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
	/**
	 *	Default index for anything , post, get , etc
	 *	return login or welcome
	*/
    public function anyIndex( ){
		//# side
        $outcome = Outcome_Model::sum('jumlah');
        $income  = Income_Model::sum('jumlah');
        $side = '
		<div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-info disable"><b>Budget Information</b></a></li>
                <a href="#" class="list-group-item">Total Pengeluaran : <span class="pull-right">'.$this->get_rupiah_root($outcome).'</span></a>
                <a href="#" class="list-group-item">Total Pemasukan :<span class="pull-right">'.$this->get_rupiah_root($income).'</span></a>
                <a href="#" class="list-group-item">Uang Sekarang : <span class="pull-right">'.$this->get_rupiah_root($income-$outcome).'</span></a>                
            </div>
		</div>
        ';
		//! contents
		$content = "";
		$this->get_user_id();
		$power = $this->get_user_power();
		$content = sprintf('

			<hr>
			<h1 class="page-header text-center bold-font">Salam kaum bersarung</h1>
			<hr>
			<div class="row"><div class="col-md-9">
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
			</div>%2$s</div>
		' , URL::to('/')."/asset/images/fatihulUlum1.gif" , $side);
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
		elseif( $power == 100) {
			
			$title = sprintf ('Welcome Admind <small>%1$s</small> ' , $this->get_user_names() );
			$content = FUNC\make_title($title);
			$content .= $this->get_list_of_admin_url();
		}
		else{
			//! we should send email to developer
			$content = FUNC\make_title('There is error with this application');
			$content .= $this->get_list_of_admin_url();
		}
		return $content;
		
	}
	/**
	 *	list of admind
	 *	return html list
	*/
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
	protected function get_additional_css(){	}

}