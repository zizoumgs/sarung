<?php
/*Cud = Create Update and delete*/
class Admin_subdivisi_crud extends Admin_uang{
	private $value ; 
	private $selected_divisi = "";
	private $selected_divisi_sub = "";
	protected function set_id($val){		$this->value ['id'] = $val ;	}
	protected function get_id(){return $this->value ['id'] ; }
	protected function set_divisi($val){		$this->value ['divisi'] = $val ;	}
	protected function get_divisi(){return $this->value ['divisi'] ; }
	protected function set_divisisub($val){		$this->value ['divisisub'] = $val ;	}
	protected function get_divisisub(){return $this->value ['divisisub'] ; }
	protected function set_message_on_top($val)  { $this->value['message_on_top'] = $val;}
	protected function get_message_on_top(){return $this->value['message_on_top'] ; }
	//! this form will show for table
	protected function get_form_table($methode = ''){
		$divisi = sprintf('
				<div class="col-sm-7">
					%1$s
				</div>',
			parent::get_select_divisi( ));
		
		$hasil ="";
		$hasil .= "<form class='form-inline' name='' methode = 'get' action= 'subdivisi_crud' role='form' > ";
		$hasil .= sprintf('<div class="form-group select_form ">%1$s</div>',$divisi);
		$hasil .= '  <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">Filter</button></div>';
		$hasil .= Form::close();
		return $hasil;
	}
	//! this is for adding , editing and deleting
	public function get_form( $url = ""	 ){
		$id = $this->get_id();
		$form  = $this->get_message_on_top() ; 
		$form .= Form::open(array('url' => $url , 'role' => 'form' ,'class' =>'form-horizontal')) ;
		$form .= $this->get_select_divisi();
		$form .= $this->get_form_subdivisi();
		$form .= Form::hidden('id', $id );
		$form .= Form::submit('Save' ,array('id'=>'','class'=>'btn btn-primary col-md-1 col-md-offset-2') ) ; 
		$form .= Form::close();
		$form .="<br>" ;
		return $form;		
	}
	/**
	 * 
	**/ 	
    public function __construct( $default = array('min_power' => 1000 ) ){
        parent::__construct($default);
   		$this->set_title('Admin Subdivisi Crud');
		$this->value = array( 'id' 			=> 	'' 	,
							 'divisi'		=> 	''	,
							 'divisisub'	=>	''	,
							 'message_on_top'	=> '' 
							 );
    }
	/**
	 * methode to add 
	**/ 
	public function getAdd($id = 0 , $nama = ""  , $message = "" ){
		$this->set_id($id);
		$this->set_divisi($nama);
		//! get table
		$this->selected_divisi = $nama;
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan menambah Subdivisi </h2>%1$s</div>', $message);
		$this->set_message_on_top( $on_top );
		$form  = $this->get_form( $this->get_add_subdivisi_url() );
		return $this->index_( $form );
	}
	/**
	 * insert into database from add
	**/ 
	public function postAdd(){
		$data = Input::all();
		$rules = array( 'divisisub' => 'required' );
		$validator = Validator::make($data, $rules);
		$div 	 = $data ['divisi'];
		if ($validator->fails())    {
			$messages = $validator->messages();
			//$messages = array("Pak nurholis " , "Pak Tono");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getAdd( 0 , $div ,  $message );
		}
		//! insert_into database
		else{
			$id = 0 ;
			$saveId = SaveId::NamaTable('subdivisi')->first();
			$table = new Divisisub_Model();
			if ( $saveId ){
				$id =  $saveId->idtable;
				$data ['id'] = $id ;
				$saveId = SaveId::find( $result->id);				
			}
			else{
				$id = $table->max('id');
				$id++;
			}
			$obj_div   		= new Divisi_Model();
			$divisi = $obj_div->where('nama' , '=' , $div  )->firstOrFail();			
			$table->id = $id;
			$table->iddivisi = $divisi->id;
			$table->nama   = $data['divisisub']			;
			
			//! prepare
			$messages = array("Gagal Memasukkan ");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));			
			$bool = false ; 
			DB::transaction(function()use ($table , $saveId , &$bool){
				$table->save();
				if($saveId)
					$saveId->delete();				
				$bool = true;
			});
			if($bool){
				$messages = array(" Sukses Menambah");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
				$pesan = "Assalamualaikum <br>Memasukkan data subdivisi dengan informasi sebagai berikut";
				foreach($data as $key => $val){
					$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
				}
				$data = array('nama'=> $this->get_nama_to_email() , 'message_contain' => $pesan );
				$this->send_email($data);				
			}
			return $this->getAdd($id , $div ,  $message);
			//return Redirect::to( $this->get_parent_url());
		}			
	}
	/**
	 * methode to edit
	**/ 
	public function getEdit($id , $nama = "" , $message = ''  ){
		$this->set_id($id);
		//! get table
		$post = DivisiSub::find($id);
		$this->selected_divisi = $post->divisi->nama;
		$this->set_divisisub( $post->nama );
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan mengedit Sub divisi dengan Id %1$s</h2>%2$s</div>', $id , $message);
		$this->set_message_on_top( $on_top );
		$form = $this->get_form( $this->get_edit_subdivisi_url());
		return $this->index_( $form );
	}
	/**
	 * methode to editing database
	**/ 
	public function postEdit(){
		$data = Input::all();
		$rules = array( 'divisisub' => 'required' );
		$validator = Validator::make($data, $rules);
		$id = Input::get('id');
		$div = Input::get( 'divisi' );
		$sub = Input::get( 'divisisub' );
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEdit($id , $div ,  $message );
		}
		//! update database
		else{
			$divisi   	= Divisi::where('nama' , '=' , $div , 'and' )->firstOrFail();
			$obj = DivisiSub::find($id);
			$obj->iddivisi = $divisi->id	 ;
			$obj->nama = $sub;
			//! prepare
			$messages = array("Gagal mengedit");
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages ));
			$bool = false ; 
			DB::transaction(function()use ( $obj , &$bool){
				$bool = true;
				$obj->save();
			});
			if($bool){
				$messages = array(" Sukses Mengedit");
				$message = sprintf('<span class="label label-info">%1$s</span>' ,
							   $this->make_message( $messages ));
				$pesan = "Assalamualaikum <br>Mengedit data Sub divisi dengan informasi sebagai berikut";
				foreach($data as $key => $val){
					$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
				}
				
				$data = array('nama'=> $this->get_nama_to_email() , 'message_contain' => $pesan );
				$this->send_email($data);				
			}
			return $this->getEdit($id , $div ,  $message);
			//return Redirect::to( $this->get_parent_url());
		}	
	}
	/**
	 * methode to delete
	**/ 
	public function getDel($id , $nama = ""  , $message = "" ){
		$this->set_id($id);
		//! get table
		$post = DivisiSub::find($id);
		$this->selected_divisi = $post->divisi->nama;
		$this->set_divisisub( $post->nama );
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan menghapus Sub divisi dengan Id %1$s</h2>%2$s</div>', $id , $message);
		$this->set_message_on_top( $on_top );
		$form = $this->get_form( $this->get_del_subdivisi_url() );
		return $this->index_( $form );
	}
	/**
	 * methode to deleting 
	**/ 
	public function postDel(){
		$id = Input::get('id');
		if($id == ""){
			return $this->getdel( $id , '' ,  'Gagal menghapus karena tidak ditemukan id untuk menggosok');
		}
		$data = array();
		$messages = array();
		$obj = DivisiSub::find( $id );
		$messages = array("Gagal menghapus");
		$message = sprintf('<span class="label label-danger">%1$s</span>' ,
						   $this->make_message( $messages ));		
		$bool = false ; 
		DB::transaction(function()use ( $obj , &$bool  ,$id){
			$bool = true;
			$obj->delete();
			$this->delete_db_admin_root('divisisub' , $id );			
		});
		if($bool){
			$messages = array(" Sukses Menghapus");
			$message = sprintf('<span class="label label-info">%1$s</span>' ,
						   $this->make_message( $messages ));
			$pesan = "Assalamualaikum <br>Menghapus data divisisub dengan informasi sebagai berikut";
			foreach($data as $key => $val){
				$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
			}
			
			$data = array('nama'=> $this->get_nama_to_email () , 'message_contain' => $pesan );
			$this->send_email($data);				
		}
		$div = Input::get('divisi');
		return $this->getAdd($id , $div ,  $message);
	}
	
	/**
	 * methode to add 
	**/ 
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
	/**
	 * methode to add 
	**/ 
	protected function get_form_subdivisi(){
		$form = sprintf('
			<div class="form-group">
				<label for="Subdivisi" class="col-sm-2 control-label" >Subdivisi</label>
				<div class="col-sm-7"> <input name="%1$s" type="text" class="form-control"  placeholder="Sub Divisi"  value="%2$s" required></div>
			</div>',
			'divisisub' ,
			$this->get_divisisub()
			);
		return $form ; 
	}

	/**
	 * default methode : table
	**/ 
	public function getIndex( $params = array ()){
		$div 		= $this->selected_divisi = Input::get('divisi');
		$form 		= $this->get_form_table();
		$wheres 	= array ();
		$divisi_sub = new Divisisub_Model();
		$wheres ['divisi']  = $div;
		if( $div 	!= "" &&  $div != "All" ){
			$divisi_sub = $divisi_sub->divisiname($div);
		}
		$posts = $divisi_sub->orderBy('updated_at', 'desc')->paginate(10);
		
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf('
				<tr>
					<td> <span class="badge ">%3$s </span></td>
					<td>
						<a href="%1$s/%3$s" >Edit</a><br>
						<a href="%2$s/%3$s" >Delete</a></td>
					<td>%4$s</td>
					<td>%5$s</td>
					<td>%6$s</td>
				</tr>
				',
				$this->get_edit_subdivisi_url(),
				$this->get_del_subdivisi_url()	,
				$post->id ,
				$post->divisi->nama,
				$post->nama,
				$post->updated_at
				);
		}
		$panel_heading = sprintf('<div class="panel-heading"><span class="badge pull-right">%1$s</span>Menunjukkan Semua Table Subdivisi
								 <a href="%2$s" class="btn btn-default btn-sm">Add</a></div>' ,
								 $posts->getTotal(),
								 $this->get_add_subdivisi_url() );
		$hasil = sprintf(
			'
		<div class="panel panel-primary">
			%5$s
			<div class="panel-body">    %4$s  </div>
			<table class="table" >
				<tr class ="header">
					<td>Id</th>
					<th>Edit & Delete</th>
					<td>Divisi</th>
					<td>Sub Divisi</th>
					<td>Last Update</th>
				</tr>
				%1$s				
			</table>
			<div class="panel-footer">%2$s</div>
		</div>
			', 	$isi , 
				$posts->appends( $wheres )->links(),
			 	$this->get_title(),
				$form ,
				$panel_heading
			);
		return $this->index_($hasil) ;				
	}
	/**
	 *
	**/
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
	protected function get_additional_css(){
		return sprintf(
		'
		<link href="%1$s" rel="stylesheet" type="text/css"/>
		%2$s
		',
		URL::to('/').'/asset/bootstrap/css/bootstrap-select.css' ,
		parent::get_additional_css()
		);
	}	
    protected function get_additional_js(){
		$js = sprintf('
				%1$s
				<script type="text/javascript" src="%2$s/asset/bootstrap/js/bootstrap-select.js"></script>
				<script type="text/javascript">
					$(function() {
						$(".selectpicker").selectpicker("show");
					});
				</script>
			',
			parent::get_additional_js(),
			$this->base_url()
			);
		return $js;
    }
	public function get_add_subdivisi_url () { return sprintf('%1$s/subdivisi_crud/add' , $this->get_admin_url() ); }
	public function get_edit_subdivisi_url() { return sprintf('%1$s/subdivisi_crud/edit' , $this->get_admin_url() ); }
	public function get_del_subdivisi_url () { return sprintf('%1$s/subdivisi_crud/del' , $this->get_admin_url() ); }
	//! override
    protected function get_selected_division(){
		return $this->selected_divisi;
	}
}