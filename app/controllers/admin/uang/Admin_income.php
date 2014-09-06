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
	private function get_base_query( $alias_name){
		$first = sprintf( '
			select outc.id as %1$s , divi.nama as %2$s, divs.nama as %3$s,
			outc.jumlah as %4$s  , outc.tanggal as %5$s
			from income outc , divisi divi , divisisub divs
			where divs.id = outc.idsubdivisi and divi.id = divs.iddivisi 
		',
		$alias_name [0] , 
		$alias_name [1] , 
		$alias_name [2] ,
		$alias_name [3] ,
		$alias_name [4] 
		);
		return $first;
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
			$wheres [] = array( 'text' => ' and divi.nama = ?'  , 'val' =>   $div );
		}
		if( $div_sub != "" &&  $div_sub != "All" ){
			$additional_data_for_pagenation  [ $this->get_name_division_sub() ] = $div_sub ; 
			$wheres [] = array( 'text' => ' and divs.nama = ?'  , 'val' =>   $div_sub );
		}
		
		$alias = array( "id" , "divisi_name" , "divisisub_name" , 'jumlah' , 'tanggal' );
		$obj = new Income_model( $alias );
		$obj->set_base_query( $this->get_base_query( $alias ) );		
		$obj->set_limit( $this->get_current_page() , $this->get_total_jump() );
		$obj->set_wheres( $wheres);
		
		$posts = $obj->get_model();
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf('
				<tr>
					<td> <span class="badge ">%1$s </span></td>
					<td>
						<a href="%6$s/income_cud/edit/%1$s" >Edit</a><br>
						<a href="#" >Delete</a></td>
					<td>%2$s</td>
					<td>%3$s</td>
					<td>%4$s</td>
					<td>%5$s</td>
				</tr>
				', $post->id ,
				$post->divisi_name,
				$post->divisisub_name,
				$post->jumlah ,
				$post->tanggal,
				$this->get_admin_url()
				);
		}
		$hasil = sprintf(
			'
		<div class="panel panel-primary">
			<div class="panel-heading">	<span class="badge pull-right">%5$s</span>Menunjukkan Semua Table Income
			</div>
			<div class="panel-body">    %4$s  </div>
			<table class="table" >
				<tr class ="header">
					<td>Id</th>
					<th>Edit & Delete</th>
					<td>Divisi</th>
					<td>Sub Divisi</th>
					<td>Jumlah</th>
					<td>Tanggal</th>
				</tr>
				%1$s				
			</table>
			<div class="panel-footer">%2$s</div>
		</div>			
			', $isi , 
			 	$obj->get_pagenation_link( $additional_data_for_pagenation ),
			 	$this->get_title(),
				$form ,
				$obj->get_total_row()
			);
		return $hasil ;		
    }
	protected function get_form(){
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

}