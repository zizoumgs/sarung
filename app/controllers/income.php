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
	protected function get_default_query(){
		$query = sprintf('
			select outc.id as id , divi.nama as nama_div, divs.nama as nama_sub,
			outc.jumlah as jumlah  , outc.tanggal as tanggal
			from income outc , divisi divi , divisisub divs
			where divs.id = outc.idsubdivisi and divi.id = divs.iddivisi 
			');
		return $query;
	}
	protected function get_table(){
		$form = $this->get_form();
		$div_sub 	= $this->get_selected_division_sub();
		$div 		= $this->get_selected_division();
		$additional_data_for_pagenation  = array() ;
		$additional_query = "";
		$additonal_where = array();
		if( $div != "" &&  $div != "All" ){
			$additional_query .= sprintf(' and divi.nama = ? ');
			$additonal_where [] = $div ;
			$additional_data_for_pagenation  [ $this->get_name_division() ] = $div ; 
		}
		if( $div_sub != "" &&  $div_sub != "All" ){
			$additional_query .= sprintf(' and divs.nama = ? ');
			$additonal_where [] = $div_sub ;
			$additional_data_for_pagenation  [ $this->get_name_division_sub() ] = $div_sub ; 
		}

		$this->set_pagenation( $additional_query , $additonal_where );
		$query = sprintf('%1$s %2$s order by id DESC limit %3$s,%4$s',
			$this->get_default_query() 	, 
			$additional_query			,
			$this->get_current_page()   , 
			$this->get_total_jump()
			);
		$posts = DB::select(DB::raw($query) , $additonal_where ) ; 
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
				', $post->id , $post->nama_div, $post->nama_sub,
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
			 $this->get_pagenation_link( $additional_data_for_pagenation ),
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
		$hasil .= sprintf('<div class="form-group select_form  ">%1$s</div>',$divisi);
		$hasil .= sprintf('<div class="form-group select_form ">%1$s</div>',$divisi_sub);
		//$hasil .= '  <div class="form-group"><input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal"></div>';
		$hasil .= '  <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">Filter</button></div>';
		$hasil .= Form::close();
		return $hasil;
	}
	protected function get_side(){
		$hasil = sprintf('
			<h3 class="title">Income</h3>
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
