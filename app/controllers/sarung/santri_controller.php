<?php
/**
 *  all santri view will be taken care bt this class 
*/
class santri_controller extends sarung_root {
	protected $default_santri = array();
	/* Useful for nama santri*/
	protected final function set_santri_nama($val) { $this->default_santri ['nama_santri'] = $val ;}
	protected final function get_santri_nama() { return $this->default_santri ['nama_santri'];}

	protected final function set_santri_id($val) { $this->default_santri ['id_santri'] = $val ;}
	protected final function get_santri_id() { return $this->default_santri ['id_santri'];}
	
	protected final function set_kecamatan_nama($val) { $this->default_santri ['nama_kecamatan'] = $val ;}
	protected final function get_kecamatan_nama(){ return $this->default_santri ['nama_kecamatan'] ; }

	protected final function get_santri_nama_selected(){ return Input::get( $this->get_santri_nama() ); }
	protected final function get_santri_id_selected(){ return Input::get( $this->get_santri_id() ); }
	protected final function get_kecamatan_nama_selected(){ return Input::get( $this->get_kecamatan_nama() ); }
	
    public function __construct(){
		parent::__construct();
		$this->set_santri_nama( 'santri_nama');
		$this->set_santri_id( 'santri_id');
		$this->set_kecamatan_nama( 'kecamatan' );
		$this->set_title('List Of Fatihul Ulum Santri');
	}
	/*this will be default for filter table */
	protected function get_form_filter_default( $go_where , $method , $additional){
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' ,'class' =>'form-horizontal form-default')) ;
		$hasil .= $additional ;
		$button = '<div class="form-group"><div class="col-sm-offset-3 col-sm-9">';
		$button .= Form::submit('Filter' , array( 'class' => 'btn btn-primary' ) );
		$button .= '</div></div>';
		//$hasil .= '<button type="submit" class="btn btn-success submit-filter" >Filter</button>';
		$hasil .= $button;
		$hasil .= Form::close();
		return $hasil;
	}
	private function get_form_group($input , $name_label){
		return sprintf('<div class="form-group ">
					   <label class="col-sm-3 control-label">%2$s</label>
					   <div class="col-sm-9">
					   %1$s
					   </div>
					   </div>' , $input , $name_label);
	}
	protected function get_form_filter( $go_where  , $method = 'get', $with_session = true ){
		$this->use_select();
        $additional = "";
        if ($with_session){
    		//$additional .= sprintf('<div class="form-group select_form ">%1$s</div>',$this->get_session_select());
			$additional .= $this->get_form_group( $this->get_session_select( array( 'class'=>'selectpicker col-md-12')) , 'Session');
        }
		$tmp = Form::text( $this->get_santri_nama() , '', array( 'class' => 'form-control' , 'placeholder' => 'Nama' , 'Value' => $this->get_santri_nama_selected() ));
		$additional .= $this->get_form_group($tmp , 'Nama');
		
		$tmp = Form::text( $this->get_santri_id()  , '', array( 'class' => 'form-control' , 'placeholder' => 'Id Santri' , 'Value' => $this->get_santri_id_selected() ));; 
		$additional .= $this->get_form_group( $tmp ,'IdSantri');
		$hasil =  $this->get_form_filter_default( $go_where , $method , $additional);
		$hasil = sprintf('<h3 class="title_post">Filter</h3>%1$s',$hasil);
		//$hasil = sprintf('<div class="thumbnai">%1$s</div>' , $hasil);
		return $hasil;
	}
	//! you can use this function to get santri url
	protected final function get_url_route_santri(){		return $this->get_url_route('/santri');			}
	protected function make_get_man( $url , $array ){
		$count = 0 ;
		$url = $this->get_url_route($url);
		$hasil = ""; 
		foreach($array as $key => $val){
			if($count == 0):
				$hasil .= sprintf('?%1$s=%2$s', $key ,urlencode($val)) ;
			else:
				$hasil .= sprintf('&%1$s=%2$s', $key ,urlencode($val)) ;
			endif;
			$count++;
		}
		return htmlspecialchars($url . $hasil);
	}
    public function getSantri(){
		$url = $this->get_url_route_santri();
		$form = $this->get_form_filter($url);
		$this->set_side($form);
        $santri = new Models_sarung();
        $santri->set_base_query_santri();
        $santri->set_limit( $this->get_current_page() , $this->get_total_jump() );
		
		if( $this->get_session_selected() != '' && $this->get_session_selected() != 'All'){
			$this->set_pagination_where_data( $this->get_session_name() , $this->get_session_selected());
			$santri->set_where( 'ses.nama' , $this->get_session_selected() );
		}
		if( $this->get_santri_id_selected() != '' ){
			$this->set_pagination_where_data( $this->get_santri_id() , $this->get_santri_id_selected());
			$santri->set_where( 'san.id' , $this->get_santri_id_selected() );
		}
		if( $this->get_santri_nama_selected() != '' ){
			$this->set_pagination_where_data( $this->get_santri_nama() , $this->get_santri_nama_selected());
			$query_raw = " and (san.nama LIKE ? or san.nama_  LIKE ?)" ;
			$query_raw_vals = array( "%".$this->get_santri_nama_selected()."%" , "%".$this->get_santri_nama_selected()."%") ;
			$santri->set_where_raw( $query_raw , $query_raw_vals );
			//$santri->set_where( 'san.nama' , "%".$this->get_santri_nama_selected()."%" ,' like ' , 'or');
			//$santri->set_where( 'san.nama_' , $this->get_session_selected() ,' LIKE ' , 'or');
		}
		if($this->get_kecamatan_nama_selected() != ""){
			$this->set_pagination_where_data( $this->get_kecamatan_nama() , $this->get_kecamatan_nama_selected());
			$santri->set_where( 'kec.nama' , $this->get_kecamatan_nama_selected() );
		}
        $posts = $santri->get_model();
		$filter = sprintf('<div class="page-header">
								<h5> You are filtering with <small>In this place filter should appear </small></h5>
								<a rel="nofollow" href="%1$s" class="btn btn-sm btn-primary" >Clear</a>
							</div>
						' , $this->get_url_route_santri());
        $temp = "";
        $temp  .= sprintf('
		<h1 class="title_post">%2$s<span class="badge pull-right">%3$s</span></h1>
		<div class="fugalleryboss"><div class="row">',
		'',
		$this->get_title(),
		$santri->get_pagenation()->count()
		);
        foreach($posts as $post ):
			
	            $temp .= "<div class='col-md-3'>";
					$temp .= "<div class='thumb'>";
        			  			$temp .= sprintf('<div class="img-thumbnail-root"><img class="img-thumbnail" src="%1$s/%2$s">
														<div class="inside-img">
															<span class="label bg-my">Id:%3$s</span>
														</div>
												 </div>
												 ',$this->get_default_folder_foto_santri() ,$post->image ,
												 $post->id,
												 $post->nis
												 );
								$temp .= sprintf('<a href=""><h4 class="entry-title rm-margin">%1$s</h4></a>', Str::limit($post->nama, 20));
								//! prepare to send get
								$url = '/santri';
								$array = array( $this->get_kecamatan_nama() => $post->kecamatan);								
								$array_combine = array_merge($array , $this->get_pagination_where_data());
								$temp .= sprintf('<a rel="nofollow" href="%2$s"><span class="glyphicon glyphicon-map-marker"></span> %1$s</a>',
												 $post->kecamatan,
												 $this->make_get_man($url , $array_combine) 
												 );
								//$temp .=link_to_action('sarung_controller@getSantri', $post->kecamatan, array(), $array);
	            $temp .= sprintf('</div>');		/* End of cold-md-6*/
	            $temp .="</div>";		/* End of cold-md-6*/
        endforeach;                
        $temp .="</div>";	/* End of Row*/
        $temp .="</div>";	/* End of  Gallery BOss*/
		$temp .= $santri->get_pagenation_link( $this->get_pagination_where_data() );
        $this->set_content($temp);
        return $this->index();
    }
    public function getSantri_(){
		$url = $this->get_url_route('/santri');
		$form = $this->get_form_filter($url);
		$this->set_side($form);
        $santri = new Models_sarung();
        $santri->set_base_query_santri();
        $santri->set_limit( $this->get_current_page() , $this->get_total_jump() );
		
		if( $this->get_session_selected() != '' && $this->get_session_selected() != 'All'){
			$this->set_pagination_where_data( $this->get_session_name() , $this->get_session_selected());
			$santri->set_where( 'ses.nama' , $this->get_session_selected() );
		}
		if( $this->get_santri_id_selected() != '' ){
			$this->set_pagination_where_data( $this->get_santri_id() , $this->get_santri_id_selected());
			$santri->set_where( 'san.id' , $this->get_santri_id_selected() );
		}
		if( $this->get_santri_nama_selected() != '' ){
			$this->set_pagination_where_data( $this->get_santri_nama() , $this->get_santri_nama_selected());
			$query_raw = " and (san.nama LIKE ? or san.nama_  LIKE ?)" ;
			$query_raw_vals = array( "%".$this->get_santri_nama_selected()."%" , "%".$this->get_santri_nama_selected()."%") ;
			$santri->set_where_raw( $query_raw , $query_raw_vals );
			//$santri->set_where( 'san.nama' , "%".$this->get_santri_nama_selected()."%" ,' like ' , 'or');
			//$santri->set_where( 'san.nama_' , $this->get_session_selected() ,' LIKE ' , 'or');
		}
		
        $posts = $santri->get_model();
        $temp = "";
        $temp  .= sprintf('
		<h1 class="title_post">%2$s<span class="badge pull-right">%3$s</span></h1>
		<div class="fugalleryboss"><div class="row">',
		$santri->get_pagenation_link( $this->get_pagination_where_data()) ,
		$this->get_title(),
		$santri->get_pagenation()->count()
		);
		
        foreach($posts as $post ):
	            $temp .= "<div class='col-md-6'>";
					$temp .= "<div class='thumb'>";
                        $temp .="<div class='row'>";
                            $temp .= "<div class='col-md-6'>";
        			  			$temp .= sprintf('<div class="img-thumbnail-root"><img class="img-thumbnail" src="%1$s/%2$s"><span class="label label-primary inside-img">Id:%2$s</span>
												 </div>
												 ',$this->get_default_folder_foto_santri() ,$post->image);
                            $temp .= "</div>";
                            $temp .= "<div class='col-md-6'>";
                                $temp .= sprintf('
												 <div class="row">
													<h4 class="entry-title">%1$s</h4>
													<span class="label label-default">Id:%2$s</span><br>
													<span class="label label-primary">Nis:%3$s</span><br>
													<span class="label label-primary">%4$s</span><br>
													<!--
													<label class="col-md-3">Id:</label><label class="col-md-9 ">%2$s</label>
													<label class="col-md-3">Nis:</label><label class="col-md-9 ">%3$s</label>
													-->
												</div>
												 ',
                                                 $post->nama ,
                                                 $post->id,
                                                 $post->nis,
												 $post->desa
                                                 );
                            $temp .= "</div>";
                        $temp .= "</div>";
		            $temp .="</div>";	/* End of thumn*/
	            $temp .="</div>";		/* End of cold-md-6*/
        endforeach;                
        $temp .="</div>";	/* End of Row*/
        $temp .="</div>";	/* End of  Gallery BOss*/
		$temp .= $santri->get_pagenation_link( $this->get_pagination_where_data() );
        $this->set_content($temp);
        return $this->index();
    }	
}