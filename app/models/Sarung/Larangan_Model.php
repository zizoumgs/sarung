<?php
/**
 *  this file will be dwelling form larangan_nama , larangan_meta , and larangan_kasus
*/
class Larangan_Nama_Model extends Sarung_Model_Root{
	protected $table = 'larangan_nama';
	//@ get id by his name
	// return id or -1
	public function scopeGet_id_by_name($query , $nama){
		$result =  $query->where('nama' , '=' , $nama);
		return $this->check_and_get_id($result);
	}
	/**
	 *	parent table
    public function Admin(){
		return $this->belongsTo('admind', 'id');
    }
	*/
}
/**
 *  this file will be dwelling form larangan_nama , larangan_meta , and larangan_kasus
*/
class Larangan_Meta_Model extends Sarung_Model_Root{
	protected $table = 'larangan_meta';
    public function NamaObj(){
		return $this->belongsTo('Larangan_Nama_Model', 'idlarangan' , 'id');
    }
    public function SessionObj(){
		return $this->belongsTo('Session_Model', 'idsession' , 'id');
    }
	public function scopeWherenama($query , $nama){
		return $query->whereHas('namaObj', function($q) use($nama) {
			$q->where('nama', 'like', "%$nama%");
		});
	}
	public function scopeWheresession($query , $nama){
		return $query->whereHas('sessionObj', function($q) use($nama) {
			$q->where('nama', 'like', "%$nama%");
		});
	}
	public function scopeWherejenis($query , $nama){
		return $query->where('jenis','=', $nama);
	}
}
/**
 *  this file will be dwelling form larangan_nama , larangan_meta , and larangan_kasus
*/
class Larangan_Kasus_Model extends Sarung_Model_Root{
	protected $table = 'larangan_kasus';
    public function MetaObj(){
		return $this->belongsTo('Larangan_Meta_Model', 'idlarangan' , 'id');
    }
    public function Userobj(){
		return $this->belongsTo('User_Model', 'idadmind' , 'id');
    }	
}