<?php
/*Crut = Create Read Update and delete*/
class Admin_divisi_crud extends Admin_uang{
	private $value ; 
	private $selected_divisi = "";
	private $selected_divisi_sub = "";
	protected function set_id($val){		$this->value ['id'] = $val ;	}
	protected function get_id(){return $this->value ['id'] ; }
	protected function set_divisi($val){		$this->value ['divisi'] = $val ;	}
	protected function get_divisi(){return $this->value ['divisi'] ; }
	protected function set_message_on_top($val)  { $this->value['message_on_top'] = $val;}
	protected function get_message_on_top(){return $this->value['message_on_top'] ; }
	//! this is for adding , editing and deleting
	public function get_form( $url = ""	 ){
		$id = $this->get_id();
		$form  = $this->get_message_on_top() ; 
		$form .= Form::open(array('url' => $url , 'role' => 'form' ,'class' =>'form-horizontal')) ;
		$form .= $this->get_form_divisi();
		$form .= Form::hidden('id', $id );
		$form .= Form::submit('Save' ,array('id'=>'','class'=>'btn btn-primary col-md-1 col-md-offset-2') ) ; 
		$form .= Form::close();
		$form .="<br>" ;
		return $form;		
	}	
    public function __construct( $default = array('min_power' => 1000 ) ){
        parent::__construct($default);
   		$this->set_title('Admin Subdivisi Crud');
		$this->value = array( 'id' 			=> 	'' 	,
							 'divisi'		=> 	''	,
							 'message_on_top'	=> '' 
							 );
    }
	public function getAdd($id = 0 , $nama = ""  , $message = "" ){
		$this->set_id($id);
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan menambah Divisi </h2>%1$s</div>', $message);
		$this->set_message_on_top( $on_top );
		$form  = $this->get_form( $this->get_add_divisi_url() );
		return $this->index_( $form );
	}
	//! insert into database from add
	public function postAdd(){
		$data = Input::all();
		$rules = array( 'divisi' => 'required' );
		$validator = Validator::make($data, $rules);
		$div 	 = $data ['divisi'];
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getAdd( 0 , $div ,  $message );
		}
		//! insert_into database
		else{
			$id = 0 ;
			$saveId = SaveId::NamaTable('divisi')->first();
			$table = new Divisi ();
			if ( $saveId ){
				$id =  $saveId->idtable;
				$data ['id'] = $id ;
				$saveId = SaveId::find( $result->id);				
			}
			else{
				$id = $table->max('id');
				$id++;
			}
			$table->id = $id;
			$table->nama   = $data['divisi']			;
			
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
				$pesan = "Assalamu alaikum <br>Memasukkan data divisi dengan informasi sebagai berikut";
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
	public function getEdit($id , $nama = "" , $message = ''  ){
		$this->set_id($id);
		//! get table
		$post = Divisi::find($id);
		$this->set_divisi( $post->nama );
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan mengedit Divisi dengan Id %1$s</h2>%2$s</div>', $id , $message);
		$this->set_message_on_top( $on_top );
		$form = $this->get_form( $this->get_edit_divisi_url());
		return $this->index_( $form );
	}
	public function postEdit(){
		$data = Input::all();
		$rules = array( 'divisi' => 'required' );
		$validator = Validator::make($data, $rules);
		$id = Input::get('id');
		$div = Input::get( 'divisi' );
		if ($validator->fails())    {
			$messages = $validator->messages();
			$message = sprintf('<span class="label label-danger">%1$s</span>' ,
							   $this->make_message( $messages->all() ));
			return $this->getEdit($id , $div ,  $message );
		}
		//! update database
		else{
			$obj = Divisi::find($id);
			$obj->nama = $div;
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
				$pesan = "Assalamualaikum <br>Mengedit data divisi dengan informasi sebagai berikut";
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
	public function getDel($id , $nama = ""  , $message = "" ){
		$this->set_id($id);
		//! get table
		$post = Divisi::find($id);
		$this->set_divisi( $post->nama );
		$on_top  = sprintf('<div class="thumbnail"><h2>Anda akan menghapus Divisi dengan Id %1$s</h2>%2$s</div>', $id , $message);
		$this->set_message_on_top( $on_top );
		$form = $this->get_form( $this->get_del_divisi_url() );
		return $this->index_( $form );
	}
	public function postDel(){
		$id = Input::get('id');
		if($id == ""){
			return $this->getdel( $id , '' ,  'Gagal menghapus karena tidak ditemukan id untuk menggosok');
		}
		$data = array();
		$messages = array();
		$obj = Divisi::find( $id );
		$messages = array("Gagal menghapus");
		$message = sprintf('<span class="label label-danger">%1$s</span>' ,
						   $this->make_message( $messages ));		
		$bool = false ; 
		DB::transaction(function()use ( $obj , &$bool  ,$id){
			$bool = true;
			$obj->delete();
			$this->delete_db_admin_root('divisi' , $id );
		});
		if($bool){
			$messages = array(" Sukses Menghapus");
			$message = sprintf('<span class="label label-info">%1$s</span>' ,
						   $this->make_message( $messages ));
			$pesan = "Assalamu alaikum <br>Menghapus data divisi dengan informasi sebagai berikut";
			foreach($data as $key => $val){
				$pesan .= sprintf('%1$s = %2$s ' , $key , $val );
			}
			
			$data = array('nama'=> $this->get_nama_to_email () , 'message_contain' => $pesan );
			$this->send_email($data);				
		}
		$div = Input::get('divisi');
		return $this->getAdd($id , $div ,  $message);
	}
	
	protected function get_form_divisi(){
		$form = sprintf('
			<div class="form-group">
				<label for="Subdivisi" class="col-sm-2 control-label" >Subdivisi</label>
				<div class="col-sm-7"> <input name="%1$s" type="text" class="form-control"  placeholder="Divisi"  value="%2$s" required></div>
			</div>',
			'divisi' ,
			$this->get_divisi()
			);
		return $form ; 
	}

	public function getIndex( $params = array ()){
		$wheres = array ();
		$divisi_sub = new Divisi();
		$posts ;
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
				</tr>
				',
				$this->get_edit_divisi_url(),
				$this->get_del_divisi_url()	,
				$post->id ,
				$post->nama,
				$post->updated_at
				);
		}
		$panel_heading = sprintf('<div class="panel-heading"><span class="badge pull-right">%1$s</span>Menunjukkan Semua Table Subdivisi
								 <a href="%2$s" class="btn btn-default btn-sm">Add</a></div>' ,
								 $posts->count(),
								 $this->get_add_divisi_url() );
		$hasil = sprintf(
			'
		<div class="panel panel-primary">
			%4$s
			<table class="table" >
				<tr class ="header">
					<td>Id</th>
					<th>Edit & Delete</th>
					<td>Divisi</th>
					<td>Last Update</th>
				</tr>
				%1$s				
			</table>
			<div class="panel-footer">%2$s</div>
		</div>			
			', 	$isi , 
				$posts->links(),
			 	$this->get_title(),
				$panel_heading
			);
		return $this->index_($hasil) ;				
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
	public function get_add_divisi_url () { return sprintf('%1$s/divisi_crud/add' , $this->get_admin_url() ); }
	public function get_edit_divisi_url() { return sprintf('%1$s/divisi_crud/edit' , $this->get_admin_url() ); }
	public function get_del_divisi_url () { return sprintf('%1$s/divisi_crud/del' , $this->get_admin_url() ); }
	//! override
    protected function get_selected_division(){		return $this->selected_divisi;	}
}