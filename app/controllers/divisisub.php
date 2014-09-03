<?php
class divisisub extends uang {
	public function __construct(){
		$this->set_title('Sub divisi Pondok Pesantren Fatihul Ulum');
		$this->set_category('uang');
	}
	protected function get_table(){
		$form = $this->get_form();
		$div 		= $this->get_selected_division();
		$wheres = array ();
		$additional_data_for_pagenation  = array() ;
		if( $div != "" &&  $div != "All" ){
			$additional_data_for_pagenation  [ $this->get_name_division() ] = $div ; 
			$wheres [] = array( 'text' => ' and divi.nama = ?'  , 'val' =>   $div );
		}

		$divisi_sub = new DivisiSub_model( array( "id" , "divisi_name" , "divisisub_name") );
		$divisi_sub->set_limit( $this->get_current_page() , $this->get_total_jump() );
		$divisi_sub->set_wheres( $wheres);		
		$posts = $divisi_sub->get_model();
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf('
				<tr>
					<td>%1$s</td>
					<td>%2$s</td>
					<td>%3$s</td>
				</tr>
				', $post->id , $post->divisi_name , $post->divisisub_name
				);
		}
		$hasil = sprintf(
			'
			<h1 class="title ">%3$s</h1><br>
			%4$s
			<table class="table table-striped table-hover" >
				<tr>
					<td>Id</th>
					<td>Divisi</th>
					<td>Sub Divisi</th>
				</tr>
				%1$s
			</table>%2$s', $isi	, 
			$divisi_sub->get_pagenation_link( $additional_data_for_pagenation )  ,
			 $this->get_title() , 
			 $form
			);
		return $hasil ;		
	}
	protected function get_form(){
		$divisi = $this->get_select_divisi( );
		$hasil ="";
		//$hasil .= Form::open(array('method' => 'get' , 'action' => '')); 
		$hasil .= "<form class='form-inline' name='' methode = 'get' action= 'subdivisi' role='form' > ";
		$hasil .= sprintf('<div class="form-group select_form ">%1$s</div>',$divisi);
		//$hasil .= '  <div class="form-group"><input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal"></div>';
		$hasil .= '  <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">Filter</button></div>';
		$hasil .= Form::close();
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
