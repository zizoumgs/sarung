<?php
class Klasement_helper extends Controller {
    private $where_text   = "" ;
    private $where_values = array()  ;
	private $where_url = array();
    protected $values , $header;
	public function get_where_values(){		return $this->where_url;	}
    public function __construct(){
        $this->where_values = array();
		$this->where_url = array();
        $this->where_text = "";
        $this->values = new StdClass;
		$this->values->header = $this->header = array();
		
    }
    public function get_time_from_string($string){
        $time = strtotime($string);//"2013-09-01";
        return $time; 
    }
    public function get_month_per_view(){        return 4;    }
    public function add_month_to_date( $time , $months = "+1", $format = " Y-m-d "){
        //$date = mktime(0, 0, 0, date("n") + $months, 1);
        $parameter = sprintf('%1$s months',$months);
        return date($format, strtotime($parameter, $time));
    }
    public function get_date_from_string($string , $format = "Y-m-d"){
        $time = strtotime($string);//"2013-09-01";
        $date = date($format,$time);
        return $date ; 
    }
    
	protected function get_kelas(){		return Input::get('kelas');	}
	protected function get_session(){		return Input::get('session');	}
	protected function get_pelajaran(){		return Input::get('pelajaran');	}
	public function get_header(){ return $this->values->header; }
    /**
     *  this will limit output of santri
    */
    private function set_filters(){
        $this->where_values = array();
		$this->where_text = "";
        //! class
		if( $this->get_kelas() != "" && $this->get_kelas() != "All" ){
			$this->where_text = " and kel.nama = ? ";
			$this->where_values [] = $this->get_kelas() ;
			$this->where_url ['kelas'] = $this->get_kelas();
		}
        //! session
		if( $this->get_session() != "" && $this->get_session() != "ALL" ){
			$this->where_text .= " and ses.nama = ? ";
			$this->where_values [] = $this->get_session() ;
			$this->where_url ['session'] = $this->get_session();
		}
		//! pelajaran
        if( $this->get_pelajaran() != "" && $this->get_pelajaran() != "All"){
			$this->where_values [] = $this->get_pelajaran();
            $this->where_text .= " and pel.nama = ? ";
			$this->where_url ['pelajaran'] = $this->get_pelajaran();
        }		
    }
    /*
     ** init clasement and its array
     ** return string
    */
    protected function get_santri(){
		$headers = $this->get_header();
        $this->set_filters();
        $date = $this->get_date_from_string($headers [1]."-01" ,"Y-m-d");
		$santri_obj 	= new Klasement_Model();
		$santries 	= $santri_obj->get_klasement_all( $this->where_text  , $this->where_values );
        
		//echo count ($santries);
        $where_query_one    =   $this->where_text." and kal.awal < ? ";
        $where_query_two    =   $this->where_text." and MONTH(kal.awal) = ? ";
        //@ get database and then save it in array
		$santri_obj->init_array($santries);
        $santri_obj->set_score($santries, $this->get_month_per_view() , $where_query_one , $where_query_two ,$this->where_values , $date);

		$this->values->stay_santri = $this->get_poor_student($santries);
        
        $this->values->html_santries = $santri_obj->get_html_result();
        return $santries;
    }
    /**
     * get date where examination is held
     * return array
    */
	protected function set_table_header(){
        $current_page = Input::get( 'page' );
        if( $current_page ==""){
			$local = date("m");
			if ( $local >= 1 && $local <= 4  ){
				$current_page = 2 ;
			}
			elseif ($local > 4 && $local <= 8 ){
				$current_page = 3 ;
			}
			else{
				$current_page = 1 ;
			}			
			$_POST ['page'] =  $current_page;
			$_GET  ['page'] =  $current_page;
			Redirect::to( URL::to('/klasement?page='.$current_page) );
        }

		$result = array("");
        $first_month = date("Y-m-01");
        //$this->where_values = array( Input::get('session_name') , Input::get('class_name') );
		$this->set_filters();
        //$this->set_pelajaran_filter();
		$uji = new Klasement_Model();
		$ujis = $uji->get_date_examination( $this->where_text , $this->where_values , "");
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
            $first_date = $this->get_time_from_string("2014-09-01");
        }
        //@ process with first examination
        $tmp = $first_date;
        $additional = $this->get_month_per_view() * ($current_page-1);
        for($x = 0 ; $x < $this->get_month_per_view() ; $x++){
            $add_month = $x + $additional ;
            $tmp = $this->add_month_to_date($first_date, sprintf('+%1$s',$add_month) , "Y-m-01");
            $result [] = $this->get_date_from_string( $tmp ,"Y-M");
        }
		//return $result;
		$this->values->header = $result ;
	}
	/**
	 *	will get all student will stay
	 *	return integer
	**/
	private function get_poor_student($santries){
		$id_ses_obj = Session_Addon_Model::sessionname( Input::get('session')  );
		//! yes there is object
		if($id_ses_obj->first()){
			$total_santri 	= 	count($santries);
			$limit			=	$id_ses_obj->first()->nilai;
			$point			=	ceil (	($limit*$total_santri)/100	);
			return $point;
		}
		return 0;
	}

}
/**
*/
class Klasement_controller extends Klasement_helper{
    public function __construct(){
        parent::__construct();
    }
    public function anyIndex(){        
		$wheres = array ();
        $posts = array ();
		$pg = Paginator::make( array() , 1, 1); 
		$santries = $html_santries = array();
		if( $this->get_session() != "ALL" && $this->get_session() != "" ){
			$this->set_table_header();
			$santries = $this->get_santri();
			$html_santries = $this->values->html_santries;
	        $pg = Paginator::make( array("a" , "b" , "c","d") , 12, 4 );
		}
		return View::make('klasement', array('posts'    =>  $posts ,
                                             'wheres'   =>  $this->get_where_values()  ,
                                             'headers'  =>  $this->get_header() ,
                                             'santries' =>  $santries ,
                                             'html_santri'  => $html_santries ,
                                             'pg' => $pg )
                          );
    }
    
}