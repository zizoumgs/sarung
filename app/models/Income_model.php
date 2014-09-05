<?php
class Income_model extends Root_model {	
	public function __construct( $alias = array() ){	
		$this->set_alias( $alias );
		$this->set_order( " order by id DESC " );
	}
	public function set_base_query($query){		$this->base_query = $query ;	}	
}
/*
class Income_model extends Eloquent {
	protected $table = 'income';
	public function divisisub() {
     	return $this->belongsTo('divisisub' , 'idsubdivisi');
 	}
}
*/