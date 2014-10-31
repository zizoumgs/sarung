<?php
/**
**/
class Admin_income_support extends Admin_uang{
	/**
	 *	contructor
	**/
	public function __construct( $default ){
		parent::__construct($default);
	}
	//! usefull for redirect 
	protected function get_parent_url(){ return parent::get_admin_url()."/income";}
	protected function get_edit_income_url(){ return sprintf('%1$s/income_cud/edit' , $this->get_admin_url() );	}
	protected function get_add_income_url(){ return sprintf('%1$s/income_cud/add'   , $this->get_admin_url() );	}
	protected function get_del_income_url(){ return sprintf('%1$s/income_cud/del'   , $this->get_admin_url() );	}
	/* Will be used by select on its children*/
	protected function get_model_divisi_sub( $text_where , $value_where){
		$obj = new Models_uang( ) ;
		$obj -> set_base_query_outcome();
		$obj -> set_where_raw( $text_where , array($value_where) );
		$obj -> set_group(' group by second.nama ');
		$obj -> set_order(' order by second.nama ASC ');
		return $obj->get_model();		
	}
	/**
	 *	return new or old model 
	**/
	public function set_get_filter_divisi($model , & $where ){
		$div 		= $this->get_selected_division();
		$where [ $this->get_name_division() ] = $div;
		if( $div != "" &&  $div != "All" ){			
			$model = $model->divisiname($div);
		}
		return $model;
	}
	/**
	 *	return new or old model 
	**/
	public function set_get_filter_divisi_sub($model , & $where ){
		$div_sub 	= $this->get_selected_division_sub( array('onchange' => "this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value)") ) ;
		$where [ $this->get_name_division_sub() ] = $div_sub;
		if( $div_sub != "" &&  $div_sub != "All" ){
			$model = $model->divisisubname($div_sub);
		}
		return $model;
	}
	/**
	 *	get object model
	*/
	protected function get_model_obj(){
		return new Income_Model();
	}
	/**
	 *	get object model by id , useful for deleting , editing
	*/
	protected function get_model_obj_find($id){
		$income = new Income_Model();
		return $income->find($id);
	}	
}
class Admin_income extends Admin_income_support{
    public function __construct( $default = array('min_power' => 1000 )  ){
        parent::__construct($default);
   		$this->set_title('Admin Uang-Income Fatihul Ulum');
    }
	//! index , this is default methode which will be called by index
    protected function get_content(){
		$form = $this->get_form();		
		$wheres = array ();
		$obj 	= 	$this->get_model_obj();
		$obj 	= 	$this->set_get_filter_divisi($obj , $wheres);
		$obj 	= 	$this->set_get_filter_divisi_sub($obj , $wheres);
		$posts 	= 	$obj->orderBy( "updated_at"  , "DESC")->paginate(10);
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf('
				<tr>
					<td> <span class="badge ">%2$s </span></td>
					<td>
						<a href="%1$s/%2$s" >Edit</a><br>
						<a href="%8$s/%2$s" >Delete</a></td>
					<td>%3$s</td>
					<td>%4$s</td>
					<td>%5$s</td>
					<td>%6$s</td>
					<td>%7$s</td>
				</tr>
				',
				$this->get_edit_income_url(),
				$post->id ,
				$post->divisisub->divisi->nama,
				$post->divisisub->nama,
				$this->get_rupiah_root($post->jumlah) ,
				$post->tanggal,
				$post->updated_at,
				$this->get_del_income_url()
				
				);
		}
		$panel_heading = sprintf('<div class="panel-heading"><span class="badge pull-right">%1$s</span>Menunjukkan Semua Table Income
								 <a href="%2$s" class="btn btn-default btn-sm">Add</a></div>' ,
								 $posts->getTotal() ,
								 $this->get_add_income_url() );
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
					<td>Jumlah</th>
					<td>Tanggal</th>
					<td>Last Update</th>
				</tr>
				%1$s				
			</table>
			<div class="panel-footer">%2$s</div>
		</div>			
			', $isi , 
			 	$posts->appends( $wheres )->links(),
			 	$this->get_title(),
				$form ,
				$panel_heading
			);
		return $hasil ;		
    }
	/**
	 *	filter
	*/
	protected function get_form($methode = ''){
		$divisi = $this->get_select_divisi( );
		$divisi_sub = $this->get_select_divisi_sub(  );
		$hasil ="";
		//$hasil .= Form::open(array('method' => 'get' , 'action' => '')); 
		$hasil .= "<form class='form-inline' name='' methode = 'get' action= 'income' role='form' > ";
		$hasil .= sprintf('<div class="form-group select_form ">%1$s</div>',$divisi);
		$hasil .= sprintf('<div class="form-group select_form ">%1$s</div>',$divisi_sub);
		//$hasil .= '  <div class="form-group"><input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal"></div>';
		$hasil .= '  <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">Filter</button></div>';
		$hasil .= Form::close();
		return $hasil;
	}
	/**
	 *	css additional
	*/
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

}