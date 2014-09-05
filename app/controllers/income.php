<?php
/**
*	To change pagenation move to 
* /vendor/laravel/framework/src/Illuminate/Pagination/views
**/
class income extends uang {
	public function __construct(){
		$this->set_title('Pemasukan Pondok Pesantren Fatihul Ulum');
		$this->set_category('uang');
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
	protected function get_table(){
		$form = $this->get_form();
		$div_sub 	= $this->get_selected_division_sub();
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
					<td>%1$s</td>
					<td>%2$s</td>
					<td>%3$s</td>
					<td>%4$s</td>
					<td>%5$s</td>
				</tr>
				', $post->id , $post->divisi_name, $post->divisisub_name,
				$post->jumlah , $post->tanggal
				);
		}
		$hasil = sprintf(
			'
			<h1 class="title">%3$s</h1>
			<br>
			%4$s
			<table class="table table-striped table-hover" >
				<tr class ="header">
					<td>Id</th>
					<td>Divisi</th>
					<td>Sub Divisi</th>
					<td>Jumlah</th>
					<td>Tanggal</th>
				</tr>
				%1$s
				
			</table>%2$s', $isi , 
			 	$obj->get_pagenation_link( $additional_data_for_pagenation ),
			 	$this->get_title(),
				$form 
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
	protected function get_side(){
		$hasil = sprintf('
			<h3 class="title">Outcome</h3>
			<div class="list-group">
			  <a href="#" class="list-group-item disabled">Table</a>
			  <a href="#" class="list-group-item">Statistik</a>
			  <a href="#" class="list-group-item">Cari</a>
			</div>
			');
		return $hasil;
	}
	protected function get_additional_css(){
		return sprintf(
		'
		<link href="%1$s" rel="stylesheet" type="text/css"/>
		<link href="%2$s" rel="stylesheet" type="text/css"/>
		',
		URL::to('/').'/asset/css/fudc.css',
		URL::to('/').'/asset/bootstrap/css/bootstrap-select.css'
		);
	}	
    protected function get_additional_js(){
		$js = sprintf('
				<script type="text/javascript" src="%1$s/asset/bootstrap/js/bootstrap-select.js"></script>
				<script type="text/javascript">
					$(function() {
						$(".selectpicker").selectpicker("show");
					});
				</script>
			',
			$this->base_url()
			);
		return $js;
    }

}
