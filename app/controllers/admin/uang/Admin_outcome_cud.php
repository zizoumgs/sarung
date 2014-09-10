<?php
/*Cut = Create Update and delete*/
class Admin_outcome_cud extends Admin_income{
	private $value ; 
	private $selected_divisi = "";
	private $selected_divisi_sub = "";
	protected function set_id($val){		$this->value ['id'] = $val ;	}
	protected function get_id(){return $this->value ['id'] ; }
	protected function set_jumlah($val){		$this->value ['jumlah'] = $val ;	}
	protected function get_jumlah(){return $this->value ['jumlah'] ; }
	protected function set_tanggal($val){		$this->value ['tanggal'] = $val ;	}
	protected function get_tanggal(){return $this->value ['tanggal'] ; }
	protected function set_divisi($val){		$this->value ['divisi'] = $val ;	}
	protected function get_divisi(){return $this->value ['divisi'] ; }
	protected function set_divisisub($val){		$this->value ['divisisub'] = $val ;	}
	protected function get_divisisub(){return $this->value ['divisisub'] ; }
	protected function set_message_on_top($val)  { $this->value['message_on_top'] = $val;}
	protected function get_message_on_top(){return $this->value['message_on_top'] ; }
	public function get_form( $methode = ""	 ){
		$id = $this->get_id();
		$url_to_submit = $this->get_admin_url() . "/outcome_cud/". $methode;
		$url_ = $url_to_submit ."/";
		$form  = $this->get_message_on_top() ; 
		$form .= Form::open(array('url' => $url_to_submit , 'role' => 'form' ,'class' =>'form-horizontal')) ;
		$form .= $this->get_select_divisi( array( "onchange" => "this.options[this.selectedIndex].value  && (window.location = '$url_' + '$id' + '/' +this.options[this.selectedIndex].value ) ") );
		$form .= $this->get_select_divisi_sub();
		$form .= $this->get_form_jumlah(  );
		$form .= $this->get_form_tanggal();
		$form .= Form::hidden('id', $id );
		$form .= Form::submit('Save' ,array('id'=>'','class'=>'btn btn-primary col-md-1 col-md-offset-2') ) ; 
		$form .= Form::close();
		$form .="<br>" ;
		return $this->index_($form);		
	}	
    public function __construct( $default = array('min_power' => 1000 ) ){
        parent::__construct($default);
   		$this->set_title('Admin Uang-Income Add');
		$this->value = array( 'id' 			=> 	'' 	,
							 'jumlah' 		=> 	'' 	,
							 'tanggal' 		=>	''	,
							 'divisi'		=> 	''	,
							 'divisisub'	=>	''	,
							 'message_on_top'	=> '' 
							 );
    }
	private function index_($form){
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
	public function getAdd($id = 0 , $nama = ""  , $message = "" ){
		$this->set_id($id);
		$this->set_divisi($nama);
		//! get table
		$this->selected_divisi = $nama;
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan menambah outcome </h2>%1$s</div>', $message);
		$this->set_message_on_top( $on_top );
		return $this->get_form( 'add');
	}
	//! insert into database from add
	public function postAdd(){
		$data = Input::all();
		$rules = array( 'jumlah' => 'required|numeric' );
		$validator = Validator::make($data, $rules);
		$div 	 = $data ['divisi'];
		$sub 	 = $data ['divisi_sub'];
		if ($validator->fails())    {
			$messages = $validator->messages();
			//$messages = array("Pak nurholis " , "Pak Tono");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEdit( 0 , $div ,  $message );
		}
		//! insert_into database
		else{
			$id = 0 ;
			$saveId = SaveId::NamaTable('outcome')->first();
			$income = new Outcome ();
			if ( $saveId ){
				$id =  $saveId->idtable;
				$data ['id'] = $id ;
				$saveId = SaveId::find( $result->id);				
			}
			else{
				$id = $income->max('id');
				$id++;
			}
			$divisi   		= Divisi::where('nama' , '=' , $div , 'and' )->firstOrFail();
			$divisisub 		= DivisiSub::where('nama' , '=' , $sub , 'and' )
							->where('iddivisi' , '=' , $divisi->id)->firstOrFail();
			$income->id = $id;
			$income->idsubdivisi = $divisisub->id	;
			$income->jumlah   = $data['jumlah']			;
			$income->tanggal  = $data['tanggal']	;
			$income->catatan  = "";
			
			//! prepare
			$messages = array("Gagal Memasukkan ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));			
			$bool = false ; 
			DB::transaction(function()use ($income , $saveId , &$bool){
				$income->save();
				if($saveId)
					$saveId->delete();
				
				$bool = true;				
			});
			if($bool){
				$messages = array(" Sukses Menambah");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
				$pesan = "Assalamualaikum <br>Memasukkan data outcome dengan informasi sebagai berikut";
				foreach($data as $key => $val){
					$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
				}
				$data = array('nama'=>"Syafii" , 'message_contain' => $pesan );
				$this->send_email($data);				
			}
			return $this->getAdd($id , $div ,  $message);
			//return Redirect::to( $this->get_parent_url());
		}			
	}
	public function getEdit($id , $nama = "" , $message = ''  ){
		$this->set_id($id);
		$this->set_divisi($nama);
		//! get table
		$posts = $this->get_model_divisi_sub( ' and main.id = ? ' , $id) ;
		foreach($posts as $post){
			$this->set_jumlah($post->jumlah) ;
			$this->set_tanggal( $post->tanggal);
			if($nama == ""){
				$this->selected_divisi = $post->divisi_name ;
				$this->selected_divisi_sub = $post->divisisub_name; 
			}
			else{
				$this->selected_divisi = $nama;				
			}
		}
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan mengedit Outcome dengan Id %1$s</h2>%2$s</div>', $id , $message);
		$this->set_message_on_top( $on_top );
		return $this->get_form( 'edit');
	}
	public function postEdit(){
		$data = Input::all();
		$rules = array( 'jumlah' => 'required|numeric' );
		$validator = Validator::make($data, $rules);
		$id = Input::get('id');
		$div = Input::get( 'divisi' );
		$sub = Input::get( 'divisi_sub' );
		$tanggal = Input::get( 'tanggal' );
		$jumlah  = Input::get( 'jumlah' );
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEdit($id , $div ,  $message );
		}
		//! update database
		else{
			$divisi   	= Divisi::where('nama' , '=' , $div , 'and' )->firstOrFail();
			$divisisub 		= DivisiSub::where('nama' , '=' , $sub , 'and' )
							->where('iddivisi' , '=' , $divisi->id)->firstOrFail();
			$income = Outcome::find($id);
			$income->idsubdivisi = $divisisub->id	;
			$income->jumlah   = $jumlah			;
			$income->tanggal  = $tanggal		;
			$income->catatan  = "";
			//! prepare
			$messages = array("Gagal mengedit");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ; 
			DB::transaction(function()use ($income , &$bool){
				$bool = true;
				$income->save();
			});
			if($bool){
				$messages = array(" Sukses Mengedit");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
				$pesan = "Assalamualaikum <br>Mengedit data outcome dengan informasi sebagai berikut";
				foreach($data as $key => $val){
					$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
				}
				
				$data = array('nama'=>"Syafii" , 'message_contain' => $pesan );
				$this->send_email($data);				
			}
			return $this->getEdit($id , $div ,  $message);
			//return Redirect::to( $this->get_parent_url());
		}	
	}
	public function getDel($id , $nama = ""  , $message = "" ){
		$this->set_id($id);
		$this->set_divisi($nama);
		//! get table
		$posts = $this->get_model_divisi_sub( ' and main.id = ? ' , $id);
		foreach($posts as $post){
			$this->set_jumlah($post->jumlah) ;
			$this->set_tanggal( $post->tanggal);
			if($nama == ""){
				$this->selected_divisi = $post->divisi_name ;
				$this->selected_divisi_sub = $post->divisisub_name; 
			}
			else{
				$this->selected_divisi = $nama;				
			}
		}
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan menghapus Outcome dengan Id %1$s</h2>%2$s</div>', $id , $message);
		$this->set_message_on_top( $on_top );
		return $this->get_form( 'del');
	}
	public function postDel(){
		$id = Input::get('id');
		$data = array();
		$messages = array();
		$income = Outcome::find( $id );
		$data ['id'] 		= $income->id ;
		$data ['jumlah'] 	= $income->jumlah ;
		$data ['tanggal'] 	= $income->tanggal;
		
		$messages = array("Gagal menghapus");
		$message = sprintf('<span class="label label-danger">%1$s</span>' ,
						   $this->make_message( $messages ));		
		$bool = false ; 
		DB::transaction(function()use ($income , &$bool  ,$id){
			$bool = true;
			$income->delete();
			$this->delete_db_admin_root('outcome' , $id );
			
		});
		if($bool){
			$messages = array(" Sukses Menghapus");
			$message = sprintf('<span class="label label-info">%1$s</span>' ,
						   $this->make_message( $messages ));
			$pesan = "Assalamualaikum <br>Mengedit data outcome dengan informasi sebagai berikut";
			foreach($data as $key => $val){
				$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
			}
			
			$data = array('nama'=>"Syafii" , 'message_contain' => $pesan );
			$this->send_email($data);				
		}
		$div = Input::get('divisi');
		return $this->getdel($id , $div ,  $message);
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
		$results = $this->get_model_divisi_sub( " and third.nama = ? " , $this->get_selected_division() );
		$data  = array();
		foreach($results as $result){
			$data [$result->income_id] = $result->divisisub_name ;
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
	protected function get_form_jumlah(){
		$form = sprintf('
			<div class="form-group">
				<label for="Jumlah" class="col-sm-2 control-label" >Jumlah</label>
				<div class="col-sm-7"> <input name="%1$s" type="text" class="form-control"  placeholder="Jumlah"  value="%2$s" required></div>
			</div>',
			$this->get_name_jumlah(),
			$this->get_jumlah()
			);
		return $form ; 
	}
	protected function get_form_tanggal(){
		$this->set_input_date( ".tanggal_input", true);
		$form = sprintf('
			<div class="form-group">
				<label for="Tanggal" class="col-sm-2 control-label">Tanggal</label>
				<div class="col-sm-7"><input name="%1$s" class="tanggal_input" type="text" class="form-control"  placeholder="Tanggal"  value="%2$s" required></div>
			</div>',
			$this->get_name_tanggal() ,
			$this->get_tanggal()
			);
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