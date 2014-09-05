<?php
class Outcome_model extends Root_model {	
	public function __construct( $alias = array() ){	
		$this->set_alias( $alias );
		$this->set_order( " order by id DESC " );
	}
	public function set_base_query($query){		$this->base_query = $query ;	}	
}


/*This will return error , i didt know why
class Outcome_model extends Eloquent {
	protected $table = 'outcome';
	public function divisisub() {
     	return $this->belongsTo('divisisub' , 'idsubdivisi');
 	}
}
 */