<?php
class Income_model extends Root_model {	
	public function __construct( $alias = array() ){	
		$this->set_alias( $alias );
		$this->set_order( " order by id DESC " );
	}
	/* You cant fill from outside*/
	protected final function get_base_query(){
		$alias_name = $this->get_alias_names();
		$first = sprintf( '
			select outc.id as %1$s , divi.nama as %2$s, divs.nama as %3$s,
			outc.jumlah as %4$s  , outc.tanggal as %5$s
			from income outc , divisi divi , divisisub divs
			where divs.id = outc.idsubdivisi and divi.id = divs.iddivisi 
		',
		$alias_name [0] , 
		$alias_name [1] , 
		$alias_name [2] ,
		$alias_name [3] ,
		$alias_name [4] 

		);
		return $first;
	}
}
/*
class Income_model extends Eloquent {
	protected $table = 'income';
	public function divisisub() {
     	return $this->belongsTo('divisisub' , 'idsubdivisi');
 	}
}
*/