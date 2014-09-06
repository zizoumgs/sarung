<?php
class DivisiSub extends Eloquent {	
	protected $table = 'divisisub';
	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function divisi() {
     	return $this->belongsTo('divisi' , 'iddivisi');
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
