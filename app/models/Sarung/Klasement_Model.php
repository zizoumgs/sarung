<?php
/**
 *  this is model just for klasement
 *  it uses santri table
*/
class Klasement_Model extends Sarung_Model_Root{
	protected $table = 'santri';
    protected $result_indi;
    protected $block =false;
    protected $html_result;
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
				'total_attend'   => 	0 	, /* Not yet implement */
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
    /**
     *  insert result db to array
    */
	private function set_klasement_ind_month( $model ){
        //@ there are no examination
        if(count( $model) == 0 ){
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
					'total_attend'  => 	0 	, 
   					'last_pos'		=>	$last_post      ,
   					'current_pos'	=>	$current_pos    ,
   					'arrow'			=>	$arrow          ,
                    'star'         => ''
   				);
                $this->result_indi [$key] = $santri;
            }
            return false;
        }
		//@ the result , this is multidimention array
		$urutan = 0  ; $pos;
		$sql_array = array();
		$urutan = 1 ; 
        foreach($model as $uji){
           	$result = array(
				'nilai' => $uji->nilai ,
				'id'	=> $uji->id_santri  ,
                'pos'   =>  $urutan         ,
                'total_nilai'   => $this->result_indi[$uji->id_santri]['total_nilai'] + $uji->nilai,
			);
			$sql_array [$uji->id_santri] = $result;
			$urutan++;
            //! for finding position
            $pos [$result['id']] = $result ['total_nilai'] ;
        }
        //@ sort array
        arsort($pos);
        $urutan = 1;
        $new_post = array();
        foreach($pos as $key => $val){
            $new_post [$key] = $urutan;
            $urutan++;
        }
        //! for correct something about position
        $pos_correction = array();
        //@ insert
		foreach( $this->result_indi as $key => $santri){
            $star = "";
			$id_santri = $key;
			$total_attend = $santri['total_attend'];
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
				$total_attend++;
            }
			//@ santri didn`t attend
            else{
                $nilai = 0 ;
                $total_nilai = $santri ['total_nilai'];
                //@ we will correct it at correction section
                $current_pos = 0;
            }
			$total_nilai    =   $santri ['total_nilai'] + $nilai;
            $last_pos      =   $santri['current_pos'];
			
            $arrow = $this->get_arrow( $last_pos , $current_pos);
            //@ score
            $this->result_indi[$id_santri] ['nilai']        =  $nilai;
            $this->result_indi[$id_santri] ['total_nilai']  =  $total_nilai;
            $this->result_indi[$id_santri] ['last_pos']     =  $last_pos;
            $this->result_indi[$id_santri] ['star']         =   $star;
			$this->result_indi[$id_santri] ['total_attend'] =  $total_attend;			
            $pos_correction [$id_santri] = $total_nilai;
		}
         //@ sort array   to correct position , this has been found in nabil during 2014-june
        arsort( $pos_correction);
        $urutan = 1;
        $new_post = array();
        foreach($pos_correction as $key => $val){
            $new_post [$key] = $urutan;
            $urutan++;
        }
        //@ correct position
		foreach( $this->result_indi as $key => $santri){
 			$id_santri                                      = $key;
            $last_pos                                       =   $santri['current_pos'];
            $current_pos                                    =   $new_post [$id_santri];
            $arrow                                          = $this->get_arrow( $last_pos , $current_pos);
            $this->result_indi[$id_santri] ['last_pos']     =  $last_pos;
            $this->result_indi[$id_santri] ['current_pos']  =  $current_pos;
            $this->result_indi[$id_santri] ['arrow']        =  $arrow;
        }

        return true;
	}
    /**
     *  get score and etc for particular month, make sure  you alredy call set_score()
     *  return html
    */
    public function get_result_for_particular_month($santri , $column){
        return $this->html_result [$santri->id_santri] [$column] ;
    }
    /**
     *  set score
    */
    public function set_score($santries , $total_colum , $where_query , $where_query_two,$where_values , $date){
            //@ find examination result before this
      		$uji = new Klasement_Model();
            //echo $date;
            $where_values_one   =   array_merge($where_values , array( $date ));
       		$model = $uji->get_klasement_before($where_query , $where_values_one);
   			$this->set_klasement_ind_month( $model );
            //! change date to another
            $str = strtotime( $date );
            $month = date("m", $str);            
            for($x = 0 ; $x < $total_colum ;$x++):
                //@ 
                if($month == 13):
                    $month = 1;
                endif;
                //@ find examination result which is wanted by user
                $where_value   =  array_merge( $where_values , array($month ) );
        		$uji = new Klasement_Model();
        		$model = $uji->get_klasement_ind_month_this($where_query_two , $where_value);
    			$this->set_klasement_ind_month( $model );
      			//@ check if exist
                foreach($santries as $santri):
                    $result =  array() ;
           			if( array_key_exists($santri->id_santri, $this->result_indi) ){
           				$emas = $this->result_indi [$santri->id_santri] ;
           				if($emas){
							/*
           					$result .= sprintf('<td class="text-center">%1$s %2$s</td>',$emas ['nilai'], $emas ['star'] );
                            $result .= sprintf('<td class="text-center"><b>%1$s</b></td>',$emas ['total_nilai'] );
                            $result .= sprintf('<td class="text-center">%1$s</td>',$emas ['last_pos'] );
                            $result .= sprintf('<td><b>%1$s</b></td>',$emas ['arrow'] );
							*/
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
	 *	query for klasement , without looking into particular month
	*/
	public function get_klasement_all($where_query , $where_values){
		$sql = sprintf('
			select san.id	as id_santri , 
			adm.first_name, adm.second_name ,	ses.awal , ses.akhir , 
			ROUND(sum(ujis.nilai*uji.kalinilai),1) as nilai
						
			from admind adm , santri san , ujiansantri ujis,
			session ses , ujian uji ,  pelajaran pel , kelas kel , kalender kal
			
			where kal.id = uji.idkalender  and kel.id = uji.idkelas and  pel.id = uji.idpelajaran 
			and ujis.idsantri = san.id  and uji.id = ujis.idujian
			and san.idadmind = adm.id 
			and ( san.keluar ="0000-00-00" OR YEAR(ses.akhir) < YEAR(san.keluar)   )
			and ses.id = kal.idsession  %1$s
			group by ujis.idsantri order by nilai DESC
		' , $where_query);
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) 	 , $where_values );
		return $kelas;
	}
	/**
     *  return 
	*/
	public function get_date_examination($wherequery, $whereArray , $limit= " limit 0 , 4"){
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
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) 	 , $whereArray);
		return $kelas;		
	}
	/**
	 *	query for klasement , without looking into particular month
	 *	return obj
	*/
	private function get_klasement_ind_month_this( $where_query  , $where_values){
		$sql = sprintf('
				select 
			adm.first_name, adm.second_name , san.id  as id_santri,	ses.awal , ses.akhir , 
			ROUND(sum(ujis.nilai*uji.kalinilai),1) as nilai,
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
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) , $where_values	);
		return $kelas;
	}
	/**
	 *	query for klasement , without looking into particular month
	 *	return obj
	*/
	private function get_klasement_before( $where_query  , $where_values){
		$sql = sprintf('
				select 
			adm.first_name, adm.second_name , san.id  as id_santri,	ses.awal , ses.akhir , 
			ROUND(sum(ujis.nilai*uji.kalinilai),1) as nilai,
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
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) , $where_values	);
		return $kelas;
	}
}
