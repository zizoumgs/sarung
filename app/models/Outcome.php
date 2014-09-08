<?php

class Outcome extends Eloquent {
	protected $table = 'outcome';
	public function divisisub() {
     	return $this->belongsTo('DivisiSub' , 'idsubdivisi');
 	}
}


/*This will return error , i didt know why
class Outcome_model extends Eloquent {
	protected $table = 'outcome';
	public function divisisub() {
     	return $this->belongsTo('divisisub' , 'idsubdivisi');
 	}
}
 */