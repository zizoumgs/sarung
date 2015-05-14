<?php
class Klasement_Controller extends Score_helper{
    private function set_filters(){
        $this->where_values = array();
		$this->where_text = "";
        //! class
		if( $this->is_not_empty($this->get_kelas()) ){
			$this->where_text = " and kel.nama = ? ";
			$this->where_values [] = $this->get_kelas() ;
			$this->where_url ['kelas'] = $this->get_kelas();
		}
        //! session
		if( $this->is_not_empty($this->get_session()) ){
			$this->where_values [] = $this->get_session() ;
			$this->where_text .= " and ses.nama = ? ";
			$this->where_url ['session'] = $this->get_session();
		}
    }
	/**
	 *	will get all student will stay
	 *	return integer
	**/
	protected function get_poor_student($santries){
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
	private function build_santri_list(){
   		$this->set_filters();

		$santries 	= Klasement_Model_query::get_klasement_all( $this->where_text  , $this->where_values ,  $this->get_session()  );
		$pelangggarans = Klasement_Model_query::get_pelanggaran_all( $this->get_session()   );
		$pelanggaran_array = array();
		
		foreach( $pelangggarans as $pel ){
			$pelanggaran_array [ $pel->id] = $pel->point;
		}
		$santries_array = array();
		$object = new stdClass();
		
		foreach( $santries as $santri ){
			$point = 0 ;
			$array = array();
			$array ['id_santri'] 	= 	$santri->id_santri;
			$array ['name'] 	= 	$santri->first_name ." ". $santri->second_name;
			if( array_key_exists ( $santri->id_santri  , $pelanggaran_array) ){
				$point = $pelanggaran_array [$santri->id_santri];
			}
			$array ["score"] 		=	$santri->nilai;
			$array ["takzir"] 		=	$point;
            
			$array ["nilai"] 		=	$santri->nilai - $point;
			
			$santries_array [] = (object)$array; 
		}
		
		usort( $santries_array , array("Score_helper", "cmp_obj"));
		//array_multisort();
		//echo count( $santries_array );
		return $santries_array;
	}    
    public function anyIndex(){
        $santries = array();
        if( $this->is_not_empty($this->get_session()) ){
            $santries = $this->build_santri_list(); 
       		$poor = $this->get_poor_student($santries);
    		return View::make('klasement'   , array('santries' =>  $santries , 'total_stay'	=> $poor  )              );
        }
        else{
            return View::make("klasement" , array('santries' =>  $santries) );
         
        }
    }
}
