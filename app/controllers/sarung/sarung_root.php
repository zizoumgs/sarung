<?php
/**
 *  I get this css from http://www.bootply.com/render/69913
    http://bootstrapzero.com/
*/
abstract class sarung_root extends root {
    public function __construct(){
		parent::__construct();
	}
	protected $pagination_data = array();
	protected $default = array();
	protected function set_session_name($val) { $this->default ['session_name'] = $val ;}
	protected function get_session_name() { return $this->default ['session_name'];}
	protected function get_session_selected() { return Input::get( $this->get_session_name() ) ;}
	/*this will be default for filter table */
	protected function get_form_filter_default( $go_where , $method , $additional){
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' =>'form-inline form-default')) ;
		$hasil .= $additional ;
		$hasil .= '<button type="submit" class="btn btn-success submit-filter" ><span class="glyphicon glyphicon-search"></span></button>';
		$hasil .= Form::close();
		return $hasil;
	}
	/*Useful for saving additional data in pagination , so that data will not be dissapear when pagination is not clicked*/
	protected function set_pagination_where_data($key , $val){ $this->pagination_data [$key] = $val ;}
	protected function get_pagination_where_data(){ return $this->pagination_data;}
    protected final function get_default_folder_foto_santri(){
        return sprintf('%1$s/foto/santri/',$this->base_url());
    }
	protected function get_session_select( $array = array() ){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'session' , 'selected' => '' );
        foreach ( $default as $key => $value) {
            if( ! array_key_exists($key , $array)){
                $array [$key] = $value ;
            }
        }
		$this->set_session_name( $default ['name'] );
        $array['selected'] = $this->get_session_selected();
		$select_item = array( '-1' => "All");
		$items = Session_Model::orderBy('awal' ,'DESC')->get();
		foreach( $items as $item){
            $select_item [$item->id] = $item->nama ; 
		}
        return $this->get_select( $select_item , $array ) ;
	}
    public function get_additional_css(){
        return sprintf('<link href="%1$s/asset/css/sarung.css" rel="stylesheet" type="text/css"' , $this->base_url());
    }
	protected function before_view($data){
        $must = array();
        return array_merge($must , $data);
    }
    
    /* Call this if you wanna show common thing */
    public final function index( $param = array() ){
        $data = array(
            "body_attr"    => $this->get_body_attribute() ,             
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $this->get_content()     ,
            'side'  => $this->get_side()
                        )    ;
        return View::make('sarung/index' , $this->before_view($data) );
    }    
    public function  getIndex(){
        $content = sprintf('
        <h1 style="font-size:2.5em;" class="title">Fatihul Ulum Manggisan</h1>
        <div class="content_section" style="text-align:justify;">
        
        	<img src="%1$s/asset/images/fatihulUlum1.gif" alt="Fatihul Ulum Icon" class="img_fancy pull-left" width=150px height=145px />
            <p class="em_text"><b>Sarung</b> adalah sebuah applikasi yang dibuat untuk pondok pesantren Fatihul Ulum Manggisan Tanggul baik diniyah atau non diniyah(meskipun pada kenyataanya keduanya sama-sama diniyah).</p>
            <p><b>Kami</b> memilih nama sarung dikarenakan beberapa alasan</br>
			Pertama: sarung merupakan tradisi pesantren dan merupakan tradisi indonesia yang tidak perlu untuk dihilangkan!.
			</p>
            <p>Titik berat pada applikasi ini adalah klasement yang sangat menentukan siapa yang naik dan siapa yang tidak . akan tetapi dalam applikasi ini
            juga ada fungsi-fungsi lain yang juga tidak kalah penting . Harapan dari applikasi ini adalah guru dan pengurus bisa dengan mudah meng-akses siapa yang perlu bimbingan lebih
            banyak dan dari sini guru bisa melihat kemampuan siswa dalam segala pelajaran dan bisa juga melihat tract record nilai siswa atau nilai kelas secara umum. kami sudah lelah menjadi
            <b>sekolah antah berantah.</b>
            </p>
	      </div>
        ', $this->base_url());
        $this->set_content( $content );
        return $this->index();
    }
    public function get_header(){
        return sprintf('
        <nav class="navbar navbar-static">
   <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://www.manggisan.com" target="ext"><b>Fatihul Ulum</b></a>
      <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="glyphicon glyphicon-chevron-down"></span>
      </a>
    </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">  
          <li><a href="#">Santri</a></li>
          <li><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Channels</a>
            <ul class="dropdown-menu">
              <li><a href="#">Sub-link</a></li>
              <li><a href="#">Sub-link</a></li>
              <li><a href="#">Sub-link</a></li>
              <li><a href="#">Sub-link</a></li>
              
            </ul>
          </li>
          <li><a href="#">About</a></li>
        </ul>
        <ul class="nav navbar-right navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i></a>
            <ul class="dropdown-menu" style="padding:12px;">
                <form class="form-inline">
     				<button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search"></i></button><input type="text" class="form-control pull-left" placeholder="Search">
                </form>
             </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">Login</a></li>
              <li><a href="#">Profile</a></li>
              <li class="divider"></li>
              <li><a href="#">About</a></li>
             </ul>
          </li>
        </ul>
      </div>
    </div>
</nav> %1$s' , '' ,$this->get_link_must_root() );
    }
    public function get_footer(){  return " Fatihul Ulum Manggisan Tanggul Jember Copright 2014";    }
	//! this will be needed to get this url which will be used by route
	protected final function get_url_route($method){ return sprintf('%1$s%2$s',$this->base_url(), $method);}
    abstract function getSantri();
}