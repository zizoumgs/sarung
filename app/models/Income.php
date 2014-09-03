<?php
class Income_model extends Eloquent {
	/**
	*	http://laravel.com/docs/eloquent
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'income';
	public function divisisub() {
     	return $this->belongsTo('divisisub' , 'idsubdivisi');
 	}
}