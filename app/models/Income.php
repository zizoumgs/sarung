<?php
class Income extends Eloquent {	
	protected $table = 'income';
	public function divisisub() {
     	return $this->belongsTo('DivisiSub' , 'idsubdivisi');
 	}

}
