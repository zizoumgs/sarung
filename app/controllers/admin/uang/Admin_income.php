<?php
/**
*	To use Model ,
*	Subclass
*	$alias = array( "id" , "divisi_name" , "divisisub_name" , 'jumlah' , 'tanggal' );
*	$obj = new Income_model( $alias );
*	$obj->set_base_query( $this->get_base_query( $alias ) );		
*	$obj->set_limit( $this->get_current_page() , $this->get_total_jump() );
*	$obj->set_wheres( $wheres);
**/
class Admin_income extends Admin_uang{
    public function __construct( $default = array('min_power' => 1000 )  ){
        parent::__construct($default);
   		$this->set_title('Admin Uang-Income Fatihul Ulum');
    }
	//! index , this is default methode which will be called by index
    protected function get_content(){
		$form = $this->get_form();
		$div_sub 	= $this->get_selected_division_sub( array('onchange' => "this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value)") ) ;
		$div 		= $this->get_selected_division();
		$wheres = array ();
		$additional_data_for_pagenation  = array() ;
		if( $div != "" &&  $div != "All" ){
			$additional_data_for_pagenation  [ $this->get_name_division() ] = $div ; 
			$wheres [] = array( 'text' => ' and third.nama = ?'  , 'val' =>   $div );
		}
		if( $div_sub != "" &&  $div_sub != "All" ){
			$additional_data_for_pagenation  [ $this->get_name_division_sub() ] = $div_sub ; 
			$wheres [] = array( 'text' => ' and second.nama = ?'  , 'val' =>   $div_sub );
		}
		
		$obj = new Models_uang();
		$obj->set_base_query_income();
		$obj->set_limit( $this->get_current_page() , $this->get_total_jump() );
		$obj->set_order(' order by updated_at DESC ');
		$obj->set_wheres( $wheres);
		
		$posts = $obj->get_model();
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
				$post->income_id ,
				$post->divisi_name,
				$post->divisisub_name,
				$this->get_rupiah_root($post->jumlah) ,
				$post->tanggal,
				$post->updated_at,
				$this->get_del_income_url()
				
				);
		}
		$panel_heading = sprintf('<div class="panel-heading"><span class="badge pull-right">%1$s</span>Menunjukkan Semua Table Income
								 <a href="%2$s" class="btn btn-default btn-sm">Add</a></div>' ,
								 $obj->get_total_row() ,
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
			 	$obj->get_pagenation_link( $additional_data_for_pagenation ),
			 	$this->get_title(),
				$form ,
				$panel_heading
			);
		return $hasil ;		
    }
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
}