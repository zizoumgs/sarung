<?php
class Outcome_model extends Eloquent {
	/**
	*	http://laravel.com/docs/eloquent
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'outcome';
	public function divisisub() {
     	return $this->belongsTo('divisisub' , 'idsubdivisi');
 	}
 	public function divisisub_a(){
  		return $this->belongsToMany('divisisub' , 'nama');
 	}
}