<?php
class DivisiSub extends Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'divisisub';
	// DEFINE RELATIONSHIPS --------------------------------------------------
	public function divisi() {
     	return $this->belongsTo('divisi' , 'iddivisi');
 	}
    public function scopeOfNama($query, $type)
    {
        return $query->whereNama($type);
    } 	

}