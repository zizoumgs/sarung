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
	/**
	 *	get name of subdivisi from certain division
	 **/
	protected static function get_sub_divisi_name($divisi_name , $order_by = "nama"){
		if($divisi_name == "" || $divisi_name == "All")
			return self::groupBy($order_by);
		return self::groupBy($order_by)->divisiname($divisi_name);			
	}	
}
