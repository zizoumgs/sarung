<?php
/**
*   this will control everything about uang
*   Watch out first alpabhet
**/
abstract class uang_support extends login_main{
    public function __construct(){
        parent::__construct();
		$this->set_title_on_top('');
		$this->set_uang_side('');
    }
    protected function get_limit_rows(){return 13;}
	/*  Title on top */
	protected function set_title_on_top($val){ $this->value ['title_on_top'] = $val ;}
	protected function get_title_on_top(){ return $this->value ['title_on_top'];}
	/* Uang side */
	protected function set_uang_side($val){ $this->value ['uang_side'] = $val ;}
	protected function get_uang_side(){ return $this->value ['uang_side'];}
    /* Infomration about row*/
	protected function set_information_table($posts){
        
        $information = sprintf('<div class="navbar-text navbar-right img_fancy med-font">
                                <span class="glyphicon glyphicon-info-sign "></span>%1$s</div>', FUNC\get_pagination_label_two($posts) );
        
        $this->value ['information_table'] = $information ;
    }
	protected function get_information_table(){ return $this->value ['information_table'];}
    
	/**
	 *
	**/
    protected function set_table_income_outcome( $posts , $form , $pagenation ){
		$isi = "";
		foreach ( $posts as $post) {
			$isi .= sprintf( $this->get_row_html(4) ,
                    $post->divisisub->divisi->nama, $post->divisisub->nama,
                    $this->get_rupiah_root($post->jumlah) , $post->tanggal
				);
		}
        //@
        $information = "";
        $information = $form . $this->get_information_table();
        //@ 
		$table = sprintf('
			<div class="col-md-9">
                <nav class="navbar navbar-default_" role="navigation">
                    %3$s
                </nav>
				<table class="table table-striped table-hover table-condensed" style="margin-bottom:5px">
					<tr class ="header">
						<td>Divisi</th>
						<td>Sub Divisi</th>
						<td>Jumlah</th>
						<td>Tanggal</th>
					</tr>
					%1$s
				</table>
			</div>
			<div class="col-md-3">
				%2$s
			</div>						 
		',$isi, $this->get_uang_side() , $information);
		$hasil = sprintf(
			'
			%3$s
			<div class="row" style="margin-bottom:0px">
				%1$s
			</div>
            <hr style="margin:0px 0px;">
			%2$s', $table , 
			 	$pagenation       ,
			 	$this->get_title_on_top()
			);
        
        $this->set_content($hasil);
        return $this->show();        
    }
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
        return View::make('main' , $data);        
    }
	/**
	 *	side of income
	**/	
	protected function get_side_income(){
		$side = sprintf('
            <aside id="text-3" class="widget widget_text"><h3 class="widget-title">3 Months </h3>
            </aside>
        ');
        $this->set_uang_side($side);
	}
    /**
     * filter by divisi
    **/
    protected function set_get_filter_by_division($model , & $where){
		$div 		= $this->get_selected_division();
        $where [$this->get_name_division()] =  $div ; 
		if( $div != "" &&  $div != "All" ){
            $model = $model->divisiname($div);
        }
        return $model ; 
    }
    /**
     * filter by divisisub
    **/
    protected function set_get_filter_by_divisionsub($model , & $where){
		$div 		= $this->get_selected_division_sub();
        $where [$this->get_name_division_sub()] =  $div ; 
		if( $div != "" &&  $div != "All" ){
            $model = $model->divisisubname($div);
        }
        return $model ; 
    }
}
/**
 *	class for income
*/
class uang_income extends uang_support{
    public function __construct(){
        parent::__construct();
    }	
    /**
     *  Default view for outcome
    **/
    public function anyIncome(){
		$this->income_set_title();
        $this->set_income_side();
        $this->use_select();
		$form = $this->get_form( $this->get_url()."/income" );
		$wheres = array ();
        $obj = new Income_Model();
        $obj = $this->set_get_filter_by_division($obj,$wheres);
        $obj = $this->set_get_filter_by_divisionsub($obj,$wheres);
        $posts = $obj->orderby("tanggal")->paginate( $this->get_limit_rows() );        
        $pagination = $posts->appends( $wheres )->links();
        $this->set_information_table( $posts);
        return $this->set_table_income_outcome( $posts , $form , $pagination );
   }
    /**
     *  Outcome
    **/
    private function income_set_title(){
		$a= sprintf('
			<h1 class="title title_post">Income</h1>
			');
		$this->set_title_on_top($a);
		$this->set_title("Income");
    }
    /**
    */
    private static function get_income_model(){
        return new Income_Model();
    }
	/**
	 *	side of outcome
	**/
	private function set_income_side(){
        $side  =    $this->get_year_income();
        $side .=    $this->get_month_income();   
        $this->set_uang_side($side);		
	}
    /**
     *  get outcome permonth
    */
    private function get_year_income(){
        //@ var
        $result = "" ; $tmp_result = array();
        //@ date
        $year = date("Y") ;
        $year -= 5;
        $last = 0 ; 
        for($x =  0 ; $x < 5 ; $x++){
            $year++;
            $total = self::get_income_model()->sumyear($year);
            //find arrow
            if($last == 0){
                $panah = '<td><span class="glyphicon glyphicon glyphicon-minus"></span></td>';
            }
            else{
                if($last < $total->jumlah)
                    $panah = '<td><span class="glyphicon glyphicon glyphicon-arrow-up green"></span></td>';
                else
                    $panah = '<td><span class="glyphicon glyphicon glyphicon-arrow-down red"></span></td>';
            }
            $last = $total->jumlah;
            $tmp  = sprintf('<tr><td class="bold-font">%1$s:</td>',$year);
            $tmp .= sprintf('<td>Rp: %1$s</td>%2$s</tr>',$this->get_rupiah_root($total->jumlah) , $panah);
            $tmp_result [] = $tmp;
        }
        //@ counter
        for($x = count($tmp_result)-1 ; $x >= 0  ;$x--){
            $result .= $tmp_result [$x] ;
        }
		$side = sprintf('
            <aside id="text-3" class="widget widget_text"><h3 class="widget-title"> 5 Year Income</h3>
                <table class="table table-striped table-condensed">%1$s</table>
            </aside>            
        ',$result);
        return $side;        
    }    
    /**
     *  get outcome permonth
    */
    private function get_month_income(){
        //@ var
        $result = "";
        //@ date
        $date = date("Y/m/01") ;
        $date_time = FUNC\get_time_from_string($date);
        for($x =  0 ; $x < 5 ; $x++){
            $date = FUNC\add_month_to_date($date_time, sprintf('-%1$s',$x) , "Y-m-01");
            $year = FUNC\get_date_from_string( $date ,"Y");
            $month = FUNC\get_date_from_string( $date ,"m");
            $test = self::get_income_model()->sumyearmonth($year,$month);
            $result .= sprintf('<tr><td class="bold-font">%1$s-%2$s:</td>',$year,$month);
            $result .= sprintf('<td>Rp: %1$s</td></tr>',$this->get_rupiah_root($test->jumlah));
        }
		$side = sprintf('
            <aside id="text-3" class="widget widget_text"><h3 class="widget-title"> 5 Months Income</h3>
                <table class="table table-striped table-condensed">%1$s</table>
            </aside>            
        ',$result);
        return $side;
    }
}
/**
 *	class for outcome
*/
class uang_outcome extends uang_income{
    public function __construct(){
        parent::__construct();
    }	
    /**
     *  Default view for outcome
    **/
    public function anyOutcome(){
		$this->outcome_set_title();
        $this->set_outcome_side();
        $this->use_select();
		$form = $this->get_form( $this->get_url()."/outcome" );
		$wheres = array ();
        $obj = new Outcome_Model();
        $obj = $this->set_get_filter_by_division($obj,$wheres);
        $obj = $this->set_get_filter_by_divisionsub($obj,$wheres);
        $posts = $obj->orderby("tanggal")->paginate( $this->get_limit_rows() );
        $pagination = $posts->appends( $wheres )->links();
        $this->set_information_table( $posts);
        return $this->set_table_income_outcome( $posts , $form , $pagination );
   }
    /**
     *  Outcome
    **/
    private function outcome_set_title(){
		$a= sprintf('
			<h1 class="title title_post">Outcome</h1>
			');
		$this->set_title_on_top($a);
		$this->set_title("Outcome");
    }
	/**
	 *	side of outcome
	**/
	private function set_outcome_side(){
        $side  =    $this->get_year_outcome();
        $side .=    $this->get_month_outcome();   
        $this->set_uang_side($side);		
	}
    /**
     *  get outcome permonth
    */
    private function get_year_outcome(){
        //@ var
        $result = "" ; $tmp_result = array();
        //@ date
        $year = date("Y") ;
        $year -= 5;
        $last = 0 ; 
        for($x =  0 ; $x < 5 ; $x++){
            $year++;
            $total = Outcome_Model::sumyear($year);
            //find arrow
            if($last == 0){
                $panah = '<td><span class="glyphicon glyphicon glyphicon-minus"></span></td>';
            }
            else{
                if($last < $total->jumlah)
                    $panah = '<td><span class="glyphicon glyphicon glyphicon-arrow-up red"></span></td>';
                else
                    $panah = '<td><span class="glyphicon glyphicon glyphicon-arrow-down green"></span></td>';
            }
            $last = $total->jumlah;
            $tmp  = sprintf('<tr><td class="bold-font">%1$s:</td>',$year);
            $tmp .= sprintf('<td>Rp: %1$s</td>%2$s</tr>',$this->get_rupiah_root($total->jumlah) , $panah);
            $tmp_result [] = $tmp;
        }
        //@ counter
        for($x = count($tmp_result)-1 ; $x >= 0  ;$x--){
            $result .= $tmp_result [$x] ;
        }
		$side = sprintf('
            <aside id="text-3" class="widget widget_text"><h3 class="widget-title"> 5 Year Outcome</h3>
                <table class="table table-striped table-condensed">%1$s</table>
            </aside>            
        ',$result);
        return $side;        
    }    
    /**
     *  get outcome permonth
    */
    private function get_month_outcome(){
        //@ var
        $result = "";
        //@ date
        $date = date("Y/m/01") ;
        $date_time = FUNC\get_time_from_string($date);
        for($x =  0 ; $x < 5 ; $x++){
            $date = FUNC\add_month_to_date($date_time, sprintf('-%1$s',$x) , "Y-m-01");
            $year = FUNC\get_date_from_string( $date ,"Y");
            $month = FUNC\get_date_from_string( $date ,"m");
            $test = Outcome_Model::sumyearmonth($year,$month);
            $result .= sprintf('<tr><td class="bold-font">%1$s-%2$s:</td>',$year,$month);
            $result .= sprintf('<td>Rp: %1$s</td></tr>',$this->get_rupiah_root($test->jumlah));
        }
		$side = sprintf('
            <aside id="text-3" class="widget widget_text"><h3 class="widget-title"> 5 Months Outcome</h3>
                <table class="table table-striped table-condensed">%1$s</table>
            </aside>            
        ',$result);
        return $side;
    }
}
/**
 *	main class
*/
class uang extends uang_outcome {    
    /*Important*/
    private $name_division , $name_division_sub;
    protected function get_selected_division(){        return Input::get( $this->name_division );    }
    protected function get_selected_division_sub(){    return Input::get( $this->name_division_sub );  }
    protected function get_name_division(){ return $this->name_division ; }
    protected function get_name_division_sub(){ return $this->name_division_sub ; }
    
    protected $value = array();    
    public function index( $param = array()){}
    /**
     *  get menu for uang  
    */
    public static function getMenu(){
        return sprintf('
                <a href="%1$s">Uang</a>
    			<ul class="child-menu">
        			<li>	<a href="%1$s/income">Income	</a></li>
        			<li>	<a href="%1$s/outcome">Outcome	</a></li>
        			<li>	<a href="%1$s">Total	</a></li>                    
                </ul>                       
        ',root::get_url_uang());
        
    }
    /**
     *  default view
    */
    public function anyIndex(){
        $outcome = Outcome_Model::sum('jumlah');
        $income  = Income_Model::sum('jumlah');
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
    protected function get_select_divisi( $array = array() ){
        $default = array( "class" => "selectpicker" , "id" => "" , "name" => 'divisi');
        foreach ( $default as $key => $value) {
            if( array_key_exists($key , $array)){
                $default [$key] = $array [$key] ;
            }
        }
        $this->name_division = $default ['name'] ; 
        $default ['selected'] = $this->get_selected_division();
        $posts = Divisi_Model::orderby('nama')->get();
        $items = array("All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama ; 
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
        $posts = Divisisub_Model::get_sub_divisi_name( $this->get_selected_division() )->get();
        $items = array( '' => "All");
        foreach ($posts as $post ) {
            $items [$post->id] = $post->nama; 
        }
        return $this->get_select( $items , $default) ;
    }
	/**
	 *
	**/
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
   		$hasil .= Form::open(array('url' => $go_where , 'role' => 'form' ,'class' =>'form-inline navbar-form navbar-left')) ;
        $hasil .= $additional ;
		$hasil .= '  <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">Filter</button></div>';
		$hasil .= Form::close();
		return $hasil;
	}
	/**
	 *
	**/
    protected function get_row_html( $total_col){
        $isi = "<tr>";
        for($x = 0 ; $x < $total_col ; $x++){
            $isi .= "<td>%s</td>" ;
        }
        $isi .= "</tr>";
        return $isi;
    }
    /**
     *  Default view for subdivisi
    **/
    public function anySubdivisi(){
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
    //! wiil return url for this class 
    protected function get_url(){
        return sprintf('%1$s/uang' , $this->base_url() );
    }
}