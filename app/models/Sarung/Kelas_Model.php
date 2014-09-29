<?php
/**
 *	This class contain three table
 *	kelasroot
 *	kelas
 *	kelasdetail
 *	jurusan
*/
/**
 *	kelasroot table has following column
 *	1.	id
 *	2.	tingkat
 *	3.	level
 *	4.	created_at
 *	5.	updated_at
 *	6.  catatan
*/
class Kelas_Root_Model extends Sarung_Model_Root{
	protected $table = 'kelasroot';
    /*
    public function kelas(){
        return $this->has_one('Kelas_Model');
    }
    */
}
/**
 *	Pelajaran table has following column
 *	1.	id
 *	2.	nama
 *	3.	inisial
 *	4.	created_at
 *	5.	updated_at
*/
class Jurusan_Model extends Sarung_Model_Root{
	protected $table = 'jurusan';
}
/**
 *	kelas table has following column
 *	1.	id
 *	2.	nama	
 *	3.	LEVEL		//! we will remove this
 *	4.	created_at
 *	5.	updated_at
 *	6.  catatan
 *	7.	idkelasroot
 *	8. 	idjurusan
 *	Name must be unique
*/
class Kelas_Model extends Sarung_Model_Root{
	protected $table = 'kelas';
	public function KelasRoot() {
     	return $this->belongsTo('Kelas_Root_Model' , 'idkelasroot');
 	}
	public function Jurusan() {
     	return $this->belongsTo('Jurusan_Model' , 'idjurusan');
 	}
}
/**
 *	This table used for class detail , like wali kelas additional bills , etc
 *	kelasdetail table has following column
 *	1.	id
 *	2.	idpetugas
 *	3.	idsession			
 *	4.	idkelas
 *	5.	tambahanbiaya
 *	6.	idjurusan		// We will remove this 
 *	7.	created_at
 *	8.	updated_at
*/
class Kelas_Detail_Model extends Sarung_Model_Root{
	protected $table = 'kelasdetail';
	public function Kelas() {
     	return $this->belongsTo('Kelas_Model' , 'idkelas');
 	}
}


