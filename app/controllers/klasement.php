<?php
/**
 *	this class is dedicated for klasement
 *	parent class login.php
**/
abstract class klasement extends login_main{
    private $input , $where_next_prev;
    /***
     *  total month will be seen by user per page
    ***/
	protected function set_month_per_view($val){
		$this->input ['month_per_view'] = $val ;
	}
	protected function get_month_per_view(){
		return $this->input ['month_per_view'];
	}
		
    /***
     *  name of form for next and previous button
    ***/
    private function set_form_name($val){
        $this->input ['form_name_next_prev'] = $val ;
    }
    private function get_form_name(){
        return $this->input ['form_name_next_prev'] ;
    }
    /**
    */
    public function get_page_name(){
        return "page_next";
    }
    public function get_page_selected(){
        return Input::get($this->get_page_name());
    }

    /***
     *  name of form for session
    ***/    
    private function set_session_name($val){
        $this->input ['session_name'] = $val ;
    }
    private function get_session_name(){
        return $this->input ['session_name'];
    }
    private function get_session_selected(){
        return Input::get($this->get_session_name());
    }
    /***
     *  name of form for kelas
     *  return string
    ***/
    private function set_kelas_name($val){
        $this->input ['kelas_name'] = $val;
    }
    private function get_kelas_name(){
        return $this->input ['kelas_name'] ;
    }
    private function get_kelas_selected(){
        return Input::get( $this->get_kelas_name());
    }
    /***
     *  name of form for pelajaran
     *  return string
    ***/
    private function set_pelajaran_name($val){
        $this->input ['pelajaran_name'] = $val;
    }
    private function get_pelajaran_name(){
        return $this->input ['pelajaran_name'] ;
    }
    private function get_pelajaran_selected(){
        return Input::get( $this->get_pelajaran_name());
    }
	public function __construct(){
		parent::__construct();
	}
    /**
     *  convert string to time
     *  return time
    */
    public function get_time_from_string($string){
        $time = strtotime($string);//"2013-09-01";
        return $time; 
    }    
    /**
     *  convert string to date
     *  return date
    */
    public function get_date_from_string($string , $format = "Y-m-d"){
        $time = strtotime($string);//"2013-09-01";
        $date = date($format,$time);
        return $date ; 
    }
    /**
     *  @  (dtime , string , string )
     *  add month to date
     *  return date
    */
    public function add_month_to_date( $time , $months = "+1", $format = " Y-m-d "){
        //$date = mktime(0, 0, 0, date("n") + $months, 1);
        $parameter = sprintf('%1$s months',$months);
        return date($format, strtotime($parameter, $time));
    }
    /**
     *  default value for this class , you should execute this everytime this class will be loaded
     *  return none
    */
    public function set_default_value(){
		$this->set_month_per_view(4);
        $this->set_session_name('session_name');
        $this->set_kelas_name('kelas_name');
        $this->set_form_name('form_button_next_prev');
		$this->where_next_prev = array();
        $this->set_pelajaran_name("pelajaran_name");
        $this->set_js_klasement();
   		$this->set_title('Klasement');
    }
	/**
	 *	Default function
	 *	return show_klasement
	*/
	public function anyKlasement(){
        $this->set_default_value();
			$table = $this->getTable();			
		return $this->show_klasement($table);
	}
	/**
	 *	get first_date of examination
	 *	return array
	*/
	public function get_date_examination($current_page){
		$result = array("");
        $first_month = date("Y-m-01");
        //@ get date from database
        $where_text = " and ses.nama = ? and kel.nama = ? ";
        $where_values = array($this->get_session_selected(),$this->get_kelas_selected());
        $where_text = $this->get_pelajaran_filter($where_text,$where_values);
		$uji = new Klasement_Model();
		$ujis = $uji->get_date_examination( $where_text , $where_values , "");
        //@ there are result
		if($ujis){
			foreach($ujis as $uji){
                $date = $this->get_date_from_string($uji->awal,"Y-m-01");
                $first_date = $this->get_time_from_string($date );
                //echo $uji->awal."<br>".$date."<br>";
                break;
			}
		}
        //@ there are no result : to do
        else{
            $first_date = $this->get_time_from_string("2014-01-01");
        }
        //@ process with first examination
        $tmp = $first_date;
        $additional = $this->get_month_per_view() * ($current_page-1);
        for($x = 0 ; $x < $this->get_month_per_view() ; $x++){
            $add_month = $x + $additional ;
            $tmp = $this->add_month_to_date($first_date, sprintf('+%1$s',$add_month) , "Y-m-01");
            $result [] = $this->get_date_from_string( $tmp ,"Y-M");
        }
		return $result;
	}
    private function get_group($label , $input){
        $hasil = sprintf('
            <div class="form-group">
                <label class="sr-only" >%1$s</label>
                %2$s
            </div>        
        ',$label , $input);
        return $hasil;
    }
 	/**
	 *	form to filter result
	 *	return html form
	*/
    private function get_filter(){
        $this->use_select('.selectpicker',true);
        $attr = array('name' => $this->get_session_name() ,
                      'id' => $this->get_session_name() ,
                      "class" => "selectpicker col-md-12",
                      'selected' => Input::get($this->get_session_name()) );
        $session = FUNC\get_session_select($attr);
        $session = $this->get_group('session',$session);
        //@ kelas
        $attr = array('name' => $this->get_kelas_name(),
                      'id' => $this->get_kelas_name() ,
                      "class" => "selectpicker col-md-12",
                      "selected" => Input::get($this->get_kelas_name()));
        $kelas  =   FUNC\get_kelas_select($attr);
        $kelas  =   $this->get_group('Kelas',$kelas);
        //@ pelajaran name
        $attr = array('name' => $this->get_pelajaran_name(),
                      'id' => $this->get_pelajaran_name() ,
                      "class" => "selectpicker col-md-12",
                      "selected" => $this->get_pelajaran_selected());
        $pelajaran  =   FUNC\get_pelajaran_select($attr , array("All"));
        $pelajaran  =   $this->get_group('Kelas',$pelajaran);
        
        //@ inut button
        $button = sprintf('
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        ');
        $hasil = Form::open( array('class' => "form-inline " , 'url' => $this->get_url_klasement()));
        $hasil .=   $session;
        $hasil .=   $kelas;
        $hasil .=   $pelajaran;
        $hasil .=   $button;
        $hasil .= Form::close();
        return $hasil;
    }
    /**
     *  get filter pelajaran
     *  return string
    */
    private function get_pelajaran_filter( $where_text , & $where_values){
        $session_name   = $this->get_pelajaran_selected();
        $this->where_next_prev [$this->get_pelajaran_name()] = $session_name;             
        if($session_name != "" && $session_name != "All"){
			$where_values [] = $session_name;
            $where_text .= " and pel.nama = ? ";
        }
        return $where_text;
    }
    /**
     *  ge filter session
     *  return string
    */
    private function get_session_filter( $where_text , & $where_values){
        $session_name   = $this->get_session_selected();
        if($session_name != ""){
            $where_text .= " and ses.nama = ? ";
            $where_values [] = $session_name;
            $this->where_next_prev [$this->get_session_name()] = $session_name; 
        }
        return $where_text;
    }
    /**
     *  ge filter class
     *  return string
    */
    private function get_kelas_filter( $where_text , & $where_values){
        $session_name   = $this->get_kelas_selected();
        if($session_name != ""){
            $where_text .= " and kel.nama = ? ";
            $where_values [] = $session_name;
            $this->where_next_prev [$this->get_kelas_name()] = $session_name; 
        }
        return $where_text;       
    }
	/**
	 *	get function , main function of this class
	 *	return table html
	*/
	private function getTable(){
		if($this->get_session_selected() == ""){
			$result = "<h1>Guide to you</h1>";
			$result.='<p class="text-justify">Please set session and kelas to particular item , otherwise you will see shis messge again , after you
			alardei set up then click button find (button on most of right)!
			You dont have to set pelajaran , </p>
			';
			return $this->get_default_html($result , $this->get_filter() , '');
		}
		//@ header
        $start_ = Input::get( $this->get_page_name());
        $limit  = "" ;
        if( $start_ ==""){
            $start_ = 1 ; 
        }
        //  $tmp = "/*and ses.nama = ? and kel.nama = ?*/";
		$heading = $this->get_date_examination( $start_);
		$result = "<tr>";
		$count = 0 ;
		foreach($heading as $head){
			$span = "";
			if($count > 0){
				$span = 'colspan="4" class="text-center" ';
			}
			$result .= sprintf('<th %1$s>%2$s</th>',$span,$head);
			$count++;
		}
		$result .= "</tr>";
		//@ second header : show result , total result , last position and current position as well as down/up array according to their position
		$second_header = array("Sco","Tot","LPos","CPos");
		$count = 0 ;
		$result .= "<tr>";
		for($x = 0 ; $x < count($heading) ;$x++){
			if($x == 0 ){
				$result .= "<td></td>";
			}
			else{
				foreach($second_header as $val){
					$result .= sprintf('<td colspan="1" class="text-center"><small>%1$s</small></td>' , $val);
				}
			}
		}
		$result .="</tr>";
        //$filter
        $where_values = array();
        $where_query = "";
        $where_query  = $this->get_session_filter   ($where_query 	, 	$where_values);
        $where_query  = $this->get_kelas_filter     ($where_query 	, 	$where_values);
		$where_query  = $this->get_pelajaran_filter	($where_query	,	$where_values);
        //@ add month to date
        $date = $this->get_date_from_string($heading [1]."-01" ,"Y-m-d");
        //echo $date;
        //$date = "2013-09-01";
		//@ table cell	, going to database
		$santri_obj 	= new Klasement_Model();
		$santries 	= $santri_obj->get_klasement_all( $where_query , $where_values);
		//echo count ($santries);
        $where_query_one    =   $where_query." and kal.awal < ? ";
        $where_query_two    =   $where_query." and MONTH(kal.awal) = ? ";
        //@
		$santri_obj->init_array($santries);
        $santri_obj->set_score($santries, $this->get_month_per_view() , $where_query_one , $where_query_two ,$where_values , $date);
		foreach($santries as $santri){
			$name = sprintf('%1$s %2$s' , $santri->first_name, $santri->second_name);
			$limit_name = str_limit( sprintf('%1$s %2$s' , $santri->second_name , $santri->first_name) , 13,'..');
			$result .= "<tr>";
			$result .= sprintf('<td title="%1$s">%2$s<span class="badge pull-right blue">%3$s</span></td>', $name,$limit_name ,$santri->id_santri);
			$result .= $santri_obj->get_result_for_particular_month($santri , 0 );
            $result .= $santri_obj->get_result_for_particular_month($santri , 1 );
            $result .= $santri_obj->get_result_for_particular_month($santri , 2 );
            $result .= $santri_obj->get_result_for_particular_month($santri , 3 );
			$result .= "</tr>";
		}
		return $this->get_default_html($result , $this->get_filter() , $this->get_next_previous_link( $this->where_next_prev));
	}
	/**
	 *	default html for this
	*/
	public function get_default_html($result , $filter , $link){
		$hasil 		= sprintf('
            <hr>
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h1>Klasement Nilai <small>Santri Fatihul Ulum</small></h1>
                    </div>
                   <div class="col-md-5">
                        <div class="pull-right">
                           %2$s
                        </div>
                   </div>
               </div>
            </div>
            <hr>
            %3$s
			<div class="table-responsive">
				<table class="table table-condensed table-bordered table-striped">
					%1$s
				</table>
			</div>
		',$result , $filter , $this->get_next_previous_link( $this->where_next_prev));
		return $hasil ; 		
	}
    /**
     *  get next previous , it need count
     *  return html 
    */
    private function get_next_previous_link($where , $per_page = 4){
        $page = Input::get($this->get_page_name());
        if( ! is_numeric ($page)){
            $page = 1;
        }
        $url = url("/clicknextprevious" );
        $hasil = Form::open( array( "name" => $this->get_form_name() , 'id'=> $this->get_form_name() , 'method' => 'get') );
            $hasil .= Form::hidden( $this->get_page_name() , $page , array( 'id' => $this->get_page_name()));
            foreach( $where as $key => $val){
                $hasil .= Form::hidden( $key,  $val , array( 'id' => $key));
            }
        $hasil .= Form::close();
        $form = $hasil ;
		//@ disable
		$disable_prev = $disable_next= "";
		if( $page == 1 ){
			$disable_prev = "disabled";
		}
		if( $page == 3 ){
			$disable_next = "disabled";
		}		
        $hasil = sprintf('
            <ul class="pager">
                <li class="previous"><a href="#" 	class="btn btn-sm %2$s" id="page-next">&larr; Back</a></li>
                <li class="next"><a href="#"		class="btn btn-sm %3$s" id="page-prev">Next &rarr;</a></li>
            </ul>
            %1$s
        ',$form , $disable_prev , $disable_next );
        return $hasil ; 
    }
    /**
     *  js for this class
     *  return none
    */
    public function set_js_klasement(){
		//@ final
		$js = sprintf(
		'
		<script>
		$(function() {			
			$( "#page-prev"  ).click(function () {
                var a = $("#%2$s").val();
                a++;
                $("#%2$s").val(a);
                $("#%1$s").submit();
			});
			$( "#page-next"  ).click(function () {
                var a = $("#%2$s").val();
				if(a > 1)	{	a--;	}
				$("#%2$s").val(a);                
                $("#%1$s").submit();
			});
		})
		</script>
		' , $this->get_form_name() , $this->get_page_name());
        $this->set_js($js);        
    }
    /**
     *  Show table
    */
	protected function show_klasement($content){
        $data = array(
        	'body_attr'    => $this->get_body_attribute() , 
            'js'    => $this->get_js() ,
            'footer'    => $this->get_footer() ,
            'header'    => $this->get_header(),
            'css'       => $this->get_css(),
            'title'   => $this->get_title(),
            'content' => $content     ,
            'side'  => $this->get_side()
                        )    ;		
        return View::make('klasement' , $data);		
	}
}
