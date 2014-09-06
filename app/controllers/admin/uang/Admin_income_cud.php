<?php
/*Cut = Create Update and delete*/
class Admin_income_cud extends Admin_income{
	private $selected_divisi = "";
	private $selected_divisi_sub = "";
    public function __construct( $default = array('min_power' => 1000 ) ){
        parent::__construct($default);
   		$this->set_title('Admin Uang-Income Add');
    }
	//! we should kill this
	//public function index ($param = array()){}
	public function getAdd(){		
		return $this->index();
	}
	public function getEdit($id , $nama = ""){
		$subs = User::all();//->where('id','=' , 5 , 'and')->get();
		foreach( $subs as $sub ){
			$sub->email;
		}
		//! get table
		$obj = new Income_model();
		$obj->set_base_query_all();		
		$obj->set_where(' and main.id = ? ' , $id );
		$posts = $obj->get_model() ;
		$jumlah = $tanggal = "";
		foreach($posts as $post){
			$jumlah = $post->jumlah ;
			$tanggal = $post->tanggal;
			if($nama == ""){
				$this->selected_divisi = $post->divisi_name ;
				$this->selected_divisi_sub = $post->divisisub_name; 
			}
			else{
				$this->selected_divisi = $nama;				
			}
		}
		$url_ = $this->get_admin_url() . "/income_cud/edit/";
		$form  = sprintf('<div class="thumbnail"><h2>Anda akan mengedit Income dengan Id %1$s</h2></div>' , $id);
		$form .= Form::open(array('url' => $url_ , 'role' => 'form' ,'class' =>'form-horizontal')) ;
		
		$form .= $this->get_select_divisi( array( "onchange" => "this.options[this.selectedIndex].value  && (window.location = '$url_' + '$id' + '/' +this.options[this.selectedIndex].value ) ") );
		//$form .= $this->get_select_divisi( array( "onchange" => "this.options[this.selectedIndex].value  && (window.location = $url_ ) ") );
		$form .= $this->get_select_divisi_sub();
		$form .= $this->get_form_jumlah( $jumlah );
		$form .= $this->get_form_tanggal( $tanggal );
		$form .= Form::hidden('id', $id );
		$form .= '<input type="submit" class="btn btn-primary col-md-1 col-md-offset-2" Value ="Ok">';
		$form .= Form::close();
		$form .="<br>" ;
        $data = array(
        	'body_attr'    => $this->get_body_attribute() , 
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $form    ,
            'side'  => $this->get_side()
        );
        return View::make( $this->get_view() , $data);
	}
	public function postEdit( $id ){
		return "<h2>Bla</h2>" . $id;
	}
	public function getDelete(){
		return $this->index();		
	}
	protected function get_select_divisi( $array = array() , $items = array()  ){
		$form = sprintf('
			<div class="form-group">
				<label for="Divisi" class="col-sm-2 control-label">Divisi</label>
				<div class="col-sm-7">
					%1$s
				</div>
			</div>',
			parent::get_select_divisi( $array ));
		return $form ; 		
	}
	protected function get_select_divisi_sub( $array = array() , $items = array()){
		$data = $items;
		if( $this->get_selected_division() != ""):
		$alias = array( "id" , "nama_div");
		$wheres = array( array ( 'text' => ' and divi.nama = ? ' , 'val' => $this->get_selected_division() ));
		$obj = new Income_model( $alias ) ;
		$obj -> set_base_query( 'select divis.id as id , divis.nama as nama_div from divisisub divis ,  divisi divi where  divis.iddivisi = divi.id ' );
		$obj -> set_wheres( $wheres );
		$obj -> set_group(' group by divis.nama '); 
		$results = $obj->get_model();
		$data  = array();
		foreach($results as $result){
			$data [$result->id] = $result->nama_div ;
		}
		endif;
		$form = sprintf('
			<div class="form-group">
				<label for="Divisi Sub" class="col-sm-2 control-label" >Divisi Sub</label>
				<div class="col-sm-7"> %1$s </div>
			</div>',
			parent::get_select_divisi_sub( $array , $data));
		return $form ; 		
	}	
	protected function get_form_jumlah($value){
		$form = sprintf('
			<div class="form-group">
				<label for="Jumlah" class="col-sm-2 control-label" >Jumlah</label>
				<div class="col-sm-7"> <input name="%1$s" type="text" class="form-control"  placeholder="Jumlah"  value="%2$s" required></div>
			</div>',
			$this->get_name_jumlah(),
			$value
			);
		return $form ; 
	}
	protected function get_form_tanggal($value){
		$form = sprintf('
			<div class="form-group">
				<label for="Tanggal" class="col-sm-2 control-label">Tanggal</label>
				<div class="col-sm-7"><input name="%1$s" type="text" class="form-control"  placeholder="Tanggal"  value="%2$s" required></div>
			</div>',
			$this->get_name_tanggal() ,
			$value);
		return $form ; 		
	}
	public function get_name_jumlah(){ return "jumlah" ; }
	public function get_name_tanggal(){ return "tanggal" ; }
	//! override
    protected function get_selected_division(){
		return $this->selected_divisi;
	}
    protected function get_selected_division_sub(){
		return $this->selected_divisi_sub;
	}
	
}