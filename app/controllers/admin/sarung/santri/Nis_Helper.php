<?php
class Nis_Helper {
    private $session_name , $nis_obj , $nis_number;
	private function set_nis_obj(){
        $this->nis_obj = new Save_Nis_Model();
        $this->nis_obj =  $this->nis_obj->getobj( $this->get_session_name() );
	}
	private function set_nis_number(){
        //! get number
        if( self::check_obj_nis() ){
           $this->nis_number = $this->nis_obj->first()->nis;                    
        }
        else{
	       $santri = new Santri_Model();
           $this->nis_number =  $santri->getmaxnisplus( $this->session_name );
        }
	}
    
	public function check_obj_nis(){
        return (!is_null($this->nis_obj)) && ($this->nis_obj->first()) ;
    }


    public function __construct( $session_name){
        $this->session_name = $session_name;
        $this->set_nis_obj();
        $this->set_nis_number();
    }
    
    public function get_nis_number(){
        return $this->nis_number;
    }
    public function get_session_name(){
        return $this->session_name;
    }
    public function get_nis_obj(){
        return $this->nis_obj;
    }

	public static function get_nis( $id_santri ){
		$obj = Santri_Model::find( $id_santri);
        $date = new DateTime( $obj->session->awal);
        $nis = $date->format("y").str_pad($obj->nis,$obj->session->perkiraansantri,"0", STR_PAD_LEFT);
		return $nis;
	}	
}