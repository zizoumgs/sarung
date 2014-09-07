<?php
class DivisiSub extends Eloquent {	
	protected $table = 'divisisub';
	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function divisi() {
		//! must be capital form first aplhabet
     	return $this->belongsTo('Divisi' , 'iddivisi');
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
