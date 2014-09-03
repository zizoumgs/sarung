<?php
class DivisiSub_model extends Root_model {	
	public function __construct( $alias = array() ){	
		$this->set_alias( $alias );
		$this->set_order( " order by id DESC " );
	}
	/* You cant fill from outside*/
	protected final function get_base_query(){
		$alias_name = $this->get_alias_names();
		$first = sprintf( 'select divs.id as %1$s ,  divi.nama as %2$s , divs.nama as %3$s
			from  divisi divi , divisisub divs 
			where divs.iddivisi = divi.id',
			$alias_name [0] , $alias_name [1] , $alias_name [2]
		);
		return $first;
	}
}

/*
class DivisiSub extends Eloquent {
	protected $table = 'divisisub';
	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function divisi() {
     	return $this->belongsTo('divisi' , 'iddivisi');
 	}
}
*/
