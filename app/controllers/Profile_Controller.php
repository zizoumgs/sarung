<?php 
//Profile_Controllers.php
class Profile_Controller extends Controller {
    public function anyIndex( $id_santri){
		//
        
    }
	public function anySantri($id_santri){
		$result [ 'santri' ] = Larangan_Kasus_Model::get_kasus_santri( $id_santri )  ;
		return View::make('profile' , $result );
	}
}

