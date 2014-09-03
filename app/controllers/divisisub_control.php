<?php
class divisisub_control extends uang {
	public function __construct(){
		$this->set_title('Sub divisi Pondok Pesantren Fatihul Ulum');
		$this->set_category('uang');
	}
	protected function get_table(){
		$posts = DivisiSub::all();
		$posts = DivisiSub::orderBy('id', 'DESC')->paginate( $this->get_total_jump() );
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf('
				<tr>
					<td>%1$s</td>
					<td>%2$s</td>
					<td>%3$s</td>
				</tr>
				', $post->id , $post->divisi->nama , $post->nama
				);
		}
		$hasil = sprintf(
			'
			<h1 class="title ">%3$s</h1>
			<table class="table table-striped table-hover" >
				<tr>
					<td>Id</th>
					<td>Divisi</th>
					<td>Sub Divisi</th>
				</tr>
				%1$s
			</table>%2$s', $isi	, $posts->links() , $this->get_title()
			);
		return $hasil ;		
	}

}
