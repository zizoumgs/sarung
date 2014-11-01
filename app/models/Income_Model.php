<?php
class Income_Model extends Uang_Root_Model {	
	protected $table = 'income';
	/**/
	protected static function get_table(){		return "income";	}

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
	/**
	 * get outcome by month
	*/
	public static function sumyearmonth($year , $month){
			$users = DB::connection( parent::get_db_name())->table( self::get_table() )
			->select(DB::raw(' sum(jumlah) as jumlah , tanggal as tanggal '))
			->whereRaw(' YEAR(tanggal) = ? and MONTH(tanggal) = ? '	 , array($year , $month) )->first();
			return $users;			
	}
	/**
	 * get outcome by year
	*/
	public static function sumyear($year){
			$users = DB::connection( parent::get_db_name())->table( self::get_table() )
			->select(DB::raw(' sum(jumlah) as jumlah , tanggal as tanggal '))
			->whereRaw(' YEAR(tanggal) = ? '	 , array($year) )->first();
			return $users;			
	}
}
