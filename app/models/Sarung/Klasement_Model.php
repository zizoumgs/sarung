<?php
/**
 *  this is model just for klasement
 *  it uses santri table
*/
class Klasement_Model_query extends Sarung_Model_Root {
	/**
	 *	query for klasement , with looking into particular month
	 *	return obj
	*/
	public static function get_static(){
		return 10 ; 
	}
	public static function get_unspecific_date_pelanggaran( $where_query  ){
		return sprintf('(select COALESCE(sum( metn.point ),0) as point 
			from larangan_kasus_ kasn , larangan_meta metn , larangan_nama namn , session sesn , admind admn , santri  sann 
			where kasn.idlarangan = metn.id	and sann.idadmind = admn.id and namn.id = metn.idlarangan and sesn.id = metn.idsession
			and admn.id = kasn.idadmind  and sann.id =  san.id  %1$s )' , $where_query); 
	}
	public static function get_pelanggaran_all( $session ){
		$sql = sprintf('
			select san.id as id ,sum( met.point) as point 
			from larangan_kasus_ kas , larangan_meta met , larangan_nama nam , session ses , admind adm , santri  san 
			where kas.idlarangan = met.id	and san.idadmind = adm.id and nam.id = met.idlarangan and ses.id = met.idsession
			and adm.id = kas.idadmind  and ses.nama = ?  group by kas.idadmind order by ses.nama DESC 
		');
		return DB::connection( self::get_db())->select( DB::raw( $sql ) , array( $session )	);		
	}
	/**
	 *	query for klasement , with looking into particular month
	 *	return obj
	*/
	public static function get_klasement_ind_month_this( $where_query  , $where_values , $where_pelanggaran){
		
		$sql = sprintf('
				select 
			adm.first_name, adm.second_name , san.id  as id_santri,	ses.awal , ses.akhir , 
			ROUND(sum(ujis.nilai*uji.kalinilai),1)  as nilai,
			 @row_number:=@row_number+1 AS  rank
						
			from (SELECT @row_number:=0) AS foo , admind adm , santri san , ujiansantri ujis,
			session ses , ujian uji ,  pelajaran pel , kelas kel , kalender kal
			
			where kal.id = uji.idkalender  and kel.id = uji.idkelas and  pel.id = uji.idpelajaran 
			and ujis.idsantri = san.id  and uji.id = ujis.idujian
			and san.idadmind = adm.id and ses.id = kal.idsession
			and ( san.keluar ="0000-00-00" OR YEAR(ses.akhir) < YEAR(san.keluar)   )
            %1$s
			group by ujis.idsantri order by nilai DESC			
		',$where_query);
		//self::get_unspecific_date_pelanggaran( " and  sesn.nama = ?  and YEAR (kasn.tanggal) = ? and MONTH(kasn.tanggal) = ? "  ) );
		$kelas = DB::connection( self::get_db())->select( DB::raw( $sql ) ,  $where_values	);
		return $kelas;
	}
	/**
	 *	query for klasement , without looking into particular month
	 *	return obj
	*/
	public static function get_klasement_before( $where_query  , $where_values , $where_pelanggaran ){
		$sql = sprintf('
				select 
			adm.first_name, adm.second_name , san.id  as id_santri,	ses.awal , ses.akhir , 
			ROUND(sum(ujis.nilai*uji.kalinilai),1)  as nilai,
			 @row_number:=@row_number+1 AS  rank
						
			from (SELECT @row_number:=0) AS foo , admind adm , santri san , ujiansantri ujis,
			session ses , ujian uji ,  pelajaran pel , kelas kel , kalender kal
			
			where kal.id = uji.idkalender  and kel.id = uji.idkelas and  pel.id = uji.idpelajaran 
			and ujis.idsantri = san.id  and uji.id = ujis.idujian
			and san.idadmind = adm.id and ses.id = kal.idsession
			and ( san.keluar ="0000-00-00" OR YEAR(ses.akhir) < YEAR(san.keluar)   )
            %1$s
			group by ujis.idsantri order by nilai DESC			
		',$where_query );
		$kelas = DB::connection( self::get_db())->select( DB::raw( $sql ) , $where_values	);
		return $kelas;
	}	

	/**
     *  return 
	*/
	public static function get_date_examination($wherequery, $whereArray , $limit= " limit 0 , 4"){
		$sql= sprintf('
		select uji.id , eve.nama , ses.nama  , uji.pelaksanaan , kel.nama , pel.nama , 
			kal.awal as awal	,
			( (DATE_FORMAT(kal.awal,"%%y")*12) + MONTH(kal.awal)) as urutan
		from kalender kal 
			JOIN session ses ON ses.id = kal.idsession
			JOIN event eve ON eve.id = kal.idevent ,
		ujian uji
			JOIN kelas kel ON uji.idkelas = kel.id
			JOIN pelajaran pel ON pel.id = uji.idpelajaran
		where
			uji.idkalender = kal.id
			%1$s
			group by awal
			order by urutan ASC
			%2$s
		' , $wherequery , $limit);
		$kelas = DB::connection( self::get_db())->select( DB::raw( $sql ) 	 , $whereArray);
		return $kelas;		
	}

	/**
	 *	query for klasement , without looking into particular month
	*/
	public static function get_klasement_all($where_query , $where_values , $session ){
		$sql = sprintf('
			select san.id	as id_santri , 
			adm.first_name, adm.second_name ,	ses.awal , ses.akhir , 
			ROUND(sum( ujis.nilai*uji.kalinilai ) ,1)  as nilai
						
			from admind adm , santri san , ujiansantri ujis,
			session ses , ujian uji ,  pelajaran pel , kelas kel , kalender kal
			
			where kal.id = uji.idkalender  and kel.id = uji.idkelas and  pel.id = uji.idpelajaran 
			and ujis.idsantri = san.id  and uji.id = ujis.idujian
			and san.idadmind = adm.id 
			and ( san.keluar ="0000-00-00" OR YEAR(ses.akhir) < YEAR(san.keluar)   )
			and ses.id = kal.idsession  %1$s
			group by ujis.idsantri order by nilai DESC
		' , $where_query);//,  self::get_unspecific_date_pelanggaran( " and  sesn.nama = ses.nama "	 ) );
		
		$tmp = array_merge(  array($session) , $where_values );
		$tmp = $where_values;
		//printf( $session );
		$kelas = DB::connection( self::get_db())->select( DB::raw( $sql ) 	 , $tmp  );
		return $kelas;
	}
}
class Klasement_Model extends Sarung_Model_Root{
	protected $table = 'santri';
    protected $result_indi;
    protected $block =false;
    protected $html_result;
	public function __construct(){
		parent::__construct();

	}
	
    /**
     *  array for our score list
    */
	public function init_array($models){
		//! register array
		$this->result_indi = array();
		foreach($models as $model){
			$this->result_indi [$model->id_santri] = array(
				'nilai' 		=>  0 	,
				'total_nilai'   => 	0 	,
				'point_sum'   => 	0	, /* Not yet implement */
                'last_pos'      =>  0 	,
                'current_pos'   =>  0 	,
				'id'		    => $model->id_santri	,	
                'arrow'         =>  ""	    ,
                'star'         =>  ''
				
			);
		}
	}
	public function get_html_result(){
		return $this->html_result;
	}
	private function is_there_examination( $model ){		return ( count( $model) != 0 ); 	}
	private function there_are_no_examination( $model ){
		foreach( $this->result_indi as $key => $santri){
   			$id_santri = $key;
   			//@ santri attends examination
			//! all needed variable
            $array_last =  array();
			$total_nilai    =   $santri ['total_nilai'] + 0;
            $last_post      =   $santri['current_pos'];
            $current_pos    =   $last_post;
            $arrow = $this->get_arrow( $last_post , $current_pos);
			$santri = array(
				'nilai'			=> 	0	            ,
				'total_nilai'	=>	$total_nilai	,
				'total_tindakan'  => 	0 	, 
				'last_pos'		=>	$last_post      ,
				'current_pos'	=>	$current_pos    ,
				'arrow'			=>	$arrow          ,
                'star'         => ''
 			);
            $this->result_indi [$key] = $santri;
        }
	    return false;		
	}
	
	private function get_new_pos( $pos ){
        $urutan = 1;
        $new_post = array();
        foreach($pos as $key => $val){
            $new_post [$key] = $urutan;
            $urutan++;
        }
		return  $new_post;
	}
	private function get_correct_position( $sql_array , $pos ){
		$new_post = $this->get_new_pos( $pos );
		$pos_correction = array();
        //@ insert
		foreach( $this->result_indi as $key => $santri){
            $star = "";
			$id_santri = $key;
			//$total_attend = $santri['total_tindakan'];
			//@ santri attends examination
			if(  array_key_exists($id_santri , $sql_array) ){
				$sql_array_the_santri = $sql_array [$key];
                $current_pos    =   $new_post [$id_santri];
                $nilai = $sql_array_the_santri ['nilai'];
                //@ give star
                if( $sql_array_the_santri['pos'] < 4 ){
                    $star_pos = $sql_array_the_santri['pos'] ;
                    $choosen_color = array("green" , "gold" , "blue");
                    $star = sprintf('<span class="glyphicon glyphicon-star %1$s very_small pull-right"></span>' , $choosen_color [$star_pos-1]) ; 
                }
				//$total_attend++;
            }
			//@ santri didn`t attend
            else{
                $nilai = 0 ;
                $total_nilai = $santri ['total_nilai'];
                //@ we will correct it at correction section
                $current_pos = 0;
            }
			$total_nilai	=   $santri ['total_nilai'] + $nilai ;// - $sql_array_the_santri  ['point_sum'];
            $last_pos      	=   $santri['current_pos'];
			
            $arrow = $this->get_arrow( $last_pos , $current_pos);
            //@ score
            $this->result_indi[$id_santri] ['nilai']        =  $nilai;
            $this->result_indi[$id_santri] ['total_nilai']  =  $total_nilai   ;
            $this->result_indi[$id_santri] ['last_pos']     =  $last_pos;
            $this->result_indi[$id_santri] ['star']         =   $star;
			//print $santri ['point_sum']. " -> " . $id_santri . " , ";
			//$this->result_indi[$id_santri] ['total_tindakan'] =  $total_attend;			
            $pos_correction [$id_santri] = $total_nilai;
		}
         //@ sort array   to correct position , this has been found in nabil during 2014-june
        arsort( $pos_correction);
		return $pos_correction;
	}
	private function set_final_position( $pos_correction){
		$new_post = $this->get_new_pos( $pos_correction );
        //@ correct position
		foreach( $this->result_indi as $key => $santri){
 			$id_santri                                      = 	$key;
            $last_pos                                       =   $santri['current_pos'];
            $current_pos                                    =   $new_post [$id_santri];
            $arrow                                          = 	$this->get_arrow( $last_pos , $current_pos);
            $this->result_indi[$id_santri] ['last_pos']     =  	$last_pos;
            $this->result_indi[$id_santri] ['current_pos']  =  	$current_pos;
            $this->result_indi[$id_santri] ['arrow']        =  	$arrow;
			$this->result_indi[$id_santri] ['total_tindakan']   =  10;
        }		
	}
	private function model_to_array( $santri_model, $model_pelanggaran ,  &$pos ){
		$urutan = 1 ; 
		$sql_array = array();
		$array_model_pelanggaran = array();
		/*
        foreach( $model_pelanggaran as $model ){
			$array_model_pelanggaran [$model->id ] = $model->point ;
			//print( $model->point ). "<br>"; 
		}
		*/
        foreach( $santri_model as $uji){
			$point = 0;
			/*
			if( array_key_exists ($uji->id_santri , $array_model_pelanggaran) ){
				$point =  $array_model_pelanggaran [ $uji->id_santri] ;
				//print( $point ) . "<br>";
			}
			*/
           	$result = array(
				'nilai' => $uji->nilai 		,
				'id'	=> $uji->id_santri  ,
                'pos'   =>  $urutan         ,
                'total_nilai'   => $this->result_indi[$uji->id_santri]['total_nilai'] + $uji->nilai,
				'point_sum'		=> $point  ,
			);
			$sql_array [$uji->id_santri] = $result;
			$urutan++;
            //! for finding position
            $pos [ $uji->id_santri ] = $result ['total_nilai'] ;
        }
		return $sql_array;
	}
	private function there_are_examination( $model , $model_pelanggaran ){	
		$pos = array();
		$sql_array = $this->model_to_array( $model , $model_pelanggaran  , $pos ); 
        //@ sort array
        arsort($pos);
        //! for correct something about position
        $pos_correction =  $this->get_correct_position( $sql_array , $pos );
		$this->set_final_position( $pos_correction); 
        return true;		
	}
    /**
     *  insert result db to array
    */
	private function set_klasement_ind_month( $model  , $model_pelanggaran ){
		//@ the result , this is multidimention array
		if( $this->is_there_examination( $model ) ){
			return $this->there_are_examination( $model , $model_pelanggaran );
		}else{
			return $this->there_are_no_examination( $model );
		}
	}
    /**
     *  set score
    */
    public function set_score($santries , $total_colum , $where_query , $where_query_two,$where_values , $session , $date){
        //@ find examination result before this
        //echo $date;
        $where_values_one   =   array_merge($where_values , array( $date ));
       	$model = Klasement_Model_query::get_klasement_before($where_query , $where_values_one , array($session , $date));
		
		//$model_pelanggaran = Klasement_Model_query::get_unspecific_date_pelanggaran( " and  ses.nama = ?  and kas.tanggal < ? " , array ("14-15" ,"2015-05-01") );

   		$this->set_klasement_ind_month( $model , "" );
        //! change date to another
        $str = strtotime( $date );
        $month = date("m", $str);
		$year = date("y", $str);
        for($x = 0 ; $x < $total_colum ;$x++):
			//@ 
            if($month == 13):
			   $month = 1;
            endif;
			//print ( $this->get_combination_date( $str , $month) );
            //@ find examination result which is wanted by user
            $where_value   =  array_merge( $where_values , array($month ) );
        	
			$model = Klasement_Model_query::get_klasement_ind_month_this($where_query_two , $where_value , array($session , $year , $month) );
			
    		$this->set_klasement_ind_month( $model , "" );
      		//@ check if exist
            foreach($santries as $santri):
			    $result =  array() ;
        		if( array_key_exists($santri->id_santri, $this->result_indi) ){
        			$emas = $this->result_indi [$santri->id_santri] ;
        			if($emas){
        				$result [] = $emas ['nilai'] .  $emas ['star'] ;
                        $result [] = $emas ['total_nilai'];
                        $result [] = $emas ['last_pos'];
                        $result [] = $emas ['arrow'];
					}
        		}
                $this->html_result [$santri->id_santri] [$x]  = $result ; 
            endforeach;
            $month++;
            //@ we have all position for santri
		endfor;
    }
    /**
     *  get score and etc for particular month, make sure  you alredy call set_score()
     *  return html
    */
    public function get_result_for_particular_month($santri , $column){
        return $this->html_result [$santri->id_santri] [$column] ;
    }
	private function get_combination_date( $original_date , $month ){
		return date("y", $original_date) . $month ."<br>";  
	}
    /**
     *  arrow
    */
    private function get_arrow ($last_post , $current_post){
        $arrow = "";
        if( $last_post == 0){
           return sprintf('%1$s <span class="glyphicon glyphicon-minus pull-right"></span> '               ,   $current_post);
        }
        elseif( $last_post > $current_post){
           return sprintf('%1$s <span class="glyphicon glyphicon-arrow-up pull-right green"></span> '   ,   $current_post);
        }
        elseif($last_post < $current_post){
            return sprintf('%1$s <span class="glyphicon glyphicon-arrow-down pull-right red"></span> '  ,   $current_post);
        }
        return sprintf('%1$s <span class="glyphicon glyphicon-minus pull-right"></span> '               ,   $current_post);
    }
}
