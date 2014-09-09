<?php
/**
*   this will control everything about uang
*   Watch out first alpabhet
**/
class uang extends root {    
    /*Important*/
    protected $value = array();
    private $name_division , $name_division_sub;
    protected function get_name_division(){ return $this->name_division ; }
    protected function get_name_division_sub(){ return $this->name_division_sub ; }
    public function index( $param = array()){}
    /* Call this if you wanna show common thing */
    public function show(  ){
        $data = array(
            'body_attr'    => $this->get_body_attribute() ,             
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $this->get_content()     ,
            'side'  => $this->get_side()
                        )    ;
        return View::make('uang/index' , $data);        
    }
    public function getIndex(){
        $outcome = Outcome::sum('jumlah');
        $income  = Income::sum('jumlah');
        $side = '
        <div class="thumbnai">
            <ul class="list-group">
                <li class="list-group-item active">Short Information</li>
                <li class="list-group-item">Total Pengeluaran : <span class="badge pull-right">'.$this->get_rupiah_root($outcome).'</span></li>
                <li class="list-group-item">Total Pemasukan :<span class="badge pull-right">'.$this->get_rupiah_root($income).'</span></li>
                <li class="list-group-item">Uang Sekarang : <span class="badge pull-right">'.$this->get_rupiah_root($income-$outcome).'</span></li>                
            </ul>
        </div>';
        $this->set_side( $side );
        $this->set_title ("Assalamu Alaikum");
        $p = " <h1 class='title'>Assalamu Alaikum</h1>
        <p>This application will make money of Fatihul ULum Online and therefore can make us little hard to cheat  ,
        Although that will not make 100% free from Corruption</p>";
        $this->set_content( $p);
        return $this->show();
    }
    protected function get_header(){
        return sprintf('
            <header class="header_container">
            <div class= "test">
                <div class="container">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="%1$s">Fatihul Ulum</a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="%1$s/income">Income</a></li>
                                <li><a href="%1$s/outcome">Outcome</a></li>
                                <li><a href="%1$s/subdivisi">Sub Divisi</a></li>
                                <!-- <li><a href="#">Contact</a></li> -->
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </header>' , $this->get_url() );

    }
    protected function get_footer(){
        $hasil = sprintf('
            <footer>
                <h3>Fatihul Ulum </h3>
            </footer>
            '
            );
        return $hasil;
    }
    protected function get_select_divisi( $array = array() ){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'divisi');
        foreach ( $default as $key => $value) {
            if( array_key_exists($key , $array)){
                $default [$key] = $array [$key] ;
            }
        }
        $this->name_division = $default ['name'] ; 
        $default ['selected'] = $this->get_selected_division();
        $posts = DB::select(DB::raw('
            select divi.id as id , divi.nama as nama_div
            from divisi divi 
            order by nama_div')
        );
        $items = array("All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama_div ; 
        }
        return $this->get_select( $items , $default) ;
    }

    protected function get_select_divisi_sub( $array = array() ){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'divisi_sub');
        foreach ( $default as $key => $value) {
            if( array_key_exists($key , $array)){
                $default [$key] = $array [$key] ;
            }
        }
        $this->name_division_sub = $default ['name'] ; 
        //! for selected item
        $default ['selected'] = $this->get_selected_division_sub();
        $posts = DB::select(DB::raw('
            select divis.id as id , divis.nama as nama_div 
            from divisisub divis 
            group by nama_div
            order by divis.id DESC')
        );
        $items = array( '' => "All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama_div ; 
        }
        return $this->get_select( $items , $default) ;
    }
    protected function get_selected_division(){        return Input::get( $this->name_division );    }
    protected function get_selected_division_sub(){    return Input::get( $this->name_division_sub );  }
	protected function get_form($go_where , $with_divisi_sub = true , $with_divisi = true){
        $additional = "";
        if ($with_divisi){
    		$additional .= sprintf('<div class="form-group select_form ">%1$s</div>',$this->get_select_divisi( ));
        }
        if ($with_divisi_sub){
    		$additional .= sprintf('<div class="form-group select_form ">%1$s</div>',$this->get_select_divisi_sub(  ) );
        }
		$hasil ="";
		//$hasil .= Form::open(array('method' => 'get' , 'action' => ''));
   		$hasil .= Form::open(array('url' => $go_where , 'role' => 'form' ,'class' =>'form-inline')) ;
        $hasil .= $additional ;
		$hasil .= '  <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">Filter</button></div>';
		$hasil .= Form::close();
		return $hasil;
	}
    protected function get_row_html( $total_col){
        $isi = "<tr>";
        for($x = 0 ; $x < $total_col ; $x++){
            $isi .= "<td>%s</td>" ;
        }
        $isi .= "</tr>";
        return $isi;
    }
    private function set_table_income_outcome( $posts , $form , $pagenation ){
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf( $this->get_row_html(5) ,
                    $post->income_id , $post->divisi_name, $post->divisisub_name,
                    $this->get_rupiah_root($post->jumlah) , $post->tanggal
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
			 	$pagenation       ,
			 	$this->get_title(),
				$form 
			);
        $this->set_content($hasil);
        return $this->show();
        
    }
    //! default view for outcome
    public function getOutcome(){
        $this->set_title("Fatihul Ulum Manggisan Outcome");
        $this->use_select();
		$form = $this->get_form( $this->get_url()."/outcome" );
		$div_sub 	= $this->get_selected_division_sub();
		$div 		= $this->get_selected_division();
		$wheres = array ();
		$additional_data_for_pagenation  = array() ;
		if( $div != "" &&  $div != "All" ){
			$additional_data_for_pagenation  [ $this->get_name_division() ] = $div ; 
			$wheres [] = array( 'text' => ' and third.nama = ?'  , 'val' =>   $div );
		}
		if( $div_sub != "" &&  $div_sub != "All" ){
			$additional_data_for_pagenation  [ 'divisi_sub'] = $div_sub ; 
			$wheres [] = array( 'text' => ' and second.nama = ?'  , 'val' =>   $div_sub );
		}
		$obj = new Models_uang();
		$obj->set_base_query_outcome();
		$obj->set_limit( $this->get_current_page() , $this->get_total_jump() );
		$obj->set_order(' order by main.tanggal DESC ');
		$obj->set_wheres( $wheres);        
		$posts = $obj->get_model();
        $pagination = $obj->get_pagenation_link( $additional_data_for_pagenation );        
        return $this->set_table_income_outcome( $posts , $form , $pagination );
   }
    public function postOutcome(){
        return $this->getOutcome();
    }
    // Default view for income
    public function getIncome(){
        $this->set_title("Fatihul Ulum Manggisan Income");
        $this->use_select();
		$form = $this->get_form( $this->get_url()."/income" );
		$div_sub 	= $this->get_selected_division_sub();
		$div 		= $this->get_selected_division();
		$wheres = array ();
		$additional_data_for_pagenation  = array() ;
		if( $div != "" &&  $div != "All" ){
			$additional_data_for_pagenation  [ $this->get_name_division() ] = $div ; 
			$wheres [] = array( 'text' => ' and third.nama = ?'  , 'val' =>   $div );
		}
		if( $div_sub != "" &&  $div_sub != "All" ){
			$additional_data_for_pagenation  [ 'divisi_sub'] = $div_sub ; 
			$wheres [] = array( 'text' => ' and second.nama = ?'  , 'val' =>   $div_sub );
		}
		$obj = new Models_uang();
		$obj->set_base_query_income();
		$obj->set_limit( $this->get_current_page() , $this->get_total_jump() );
		$obj->set_order(' order by main.tanggal DESC ');
		$obj->set_wheres( $wheres);        
		$posts = $obj->get_model();
        $pagination = $obj->get_pagenation_link( $additional_data_for_pagenation );        
        return $this->set_table_income_outcome( $posts , $form , $pagination );
   }
    public function postIncome(){
        return $this->getIncome();
    }

    public function getSubdivisi(){
        $this->set_title('Fatihul Ulum Manggisan ');
        $this->use_select();
 		$div 		= $this->selected_divisi = Input::get('divisi');
		$form = $this->get_form( $this->get_url()."/subdivisi" , false);
		$wheres = array ();
		$divisi_sub = new DivisiSub();
		$posts ;
		if( $div != "" &&  $div != "All" ){
			$this->selected_divisi = $div;
			$wheres  ['divisi'] =  $div ; 
			$divisi = Divisi::where('nama','=',$div)->first();
			$posts = $divisi_sub->where('iddivisi','=', $divisi->id )->orderBy('updated_at', 'desc')->paginate(10);
		}
		else{
			$posts = $divisi_sub->orderBy('updated_at', 'desc')->paginate(10);					
		}
		
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf($this->get_row_html(3), 
				$post->id ,
				$post->divisi->nama,
				$post->nama
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
				</tr>
				%1$s				
			</table>%2$s
		</div>			
			', 	$isi , 
				$posts->appends( $wheres )->links(),
			 	$this->get_title(),
				$form 				
			);
        $this->set_content($hasil);
        return $this->show();        
    }
    public function postSubdivisi(){
        return $this->getSubdivisi();
    }
	protected function get_additional_css(){
		return sprintf(
		'
		<link href="%1$s" rel="stylesheet" type="text/css"/>
		',
		URL::to('/').'/asset/css/fudc.css'
		);
	}
    //! wiil return url for this class 
    protected function get_url(){
        return sprintf('%1$s/uang' , $this->base_url() );
    }
}