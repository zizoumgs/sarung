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
	/* in the beginning i use larangan_kasus but i encounter error so i decided to change to be larangan_kasus_*/
	protected $table = 'larangan_kasus_';
    public function MetaObj(){
		return $this->belongsTo('Larangan_Meta_Model', 'idlarangan' , 'id');
    }
    public function Userobj(){
		return $this->belongsTo('User_Model', 'idadmind' , 'id');
    }	
	public function scopeWheresantri($query , $nama){
		return $query->whereHas('userObj', function($q) use($nama) {
			//$q->whereRaw(sprintf('first_name LIKE "%1$s" or second_name LIKE "%1$s" ' , "$nama"));
			//$q->where('first_name','LIKE' ,$nama )->where('second_name','LIKE' ,$nama);
            $q->whereRaw(" (first_name LIKE ? or second_name LIKE ? ) " ,
                                        array( "%".$nama."%" ,
                                              "%".$nama."%" )
                                        );
		});
	}
	public function scopeWheresession($query , $nama){
		return $query->whereHas('metaObj', function($q) use($nama) {
			$q->wheresession($nama);
		});
	}
	public function scopeWherejenis($query , $nama){
		return $query->whereHas('metaObj', function($q) use($nama) {
			$q->wherejenis($nama);
		});
	}
	public function scopeWherenama($query , $nama){
		return $query->whereHas('metaObj', function($q) use($nama) {
			$q->wherenama($nama);
		});
	}
}