<?php
class Divisi extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	//protected $table = 'divisi';
	protected $table = 'divisisub';
	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function divisisub() {
     	return $this->belongsTo('divisi' , 'iddivisi');
 	}	
}