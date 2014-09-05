<?php
class DivisiSub_model extends Root_model {	
	public function __construct( $alias = array() ){	
		$this->set_alias( $alias );
		$this->set_order( " order by id DESC " );
	}
	public function set_base_query($query){		$this->base_query = $query ;	}	
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
