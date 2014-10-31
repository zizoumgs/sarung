<?php
class Divisisub_Model extends Uang_Root_Model {	
	protected $table = 'divisisub';
	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function divisi() {
		//! must be capital form first aplhabet
     	return $this->belongsTo('Divisi_Model' , 'iddivisi');
 	}
	/**
	 *	filter by division`s name
	**/
	public function scopeDivisiname($query , $name){
		return $query->whereHas('divisi',function($q) use( $name) {
			$q->where('nama', '=', $name);
		});
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
