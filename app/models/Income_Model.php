<?php
class Income_Model extends Uang_Root_Model {	
	protected $table = 'income';
	public function divisisub() {
     	return $this->belongsTo('Divisisub_Model' , 'idsubdivisi');
 	}
	/**
	 *	filter by division`s name
	*/
	public function scopeDivisiname($query , $name){
		$id = Divisi_Model::getid($name);
		return $query->whereHas('divisisub',function($q) use( $id) {
			$q->where('iddivisi', '=', $id);
		});
	}
	/**
	 *	filter by divisionsub`s name
	*/
	public function scopeDivisisubname($query , $name){
		return $query->whereHas('divisisub',function($q) use($name) {
			$q->where('nama', '=', $name);
		});
	}

}
