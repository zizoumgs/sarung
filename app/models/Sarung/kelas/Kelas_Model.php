<?php
/**
 *	This class contain three table
 *	kelasroot
 *	kelas
 *	kelasdetail
 *	jurusan
*/
class Kelas_Root_Model extends Sarung_Model_Root{
	/**
	 *	kelasroot table has following column
	 *	1.	id
	 *	2.	tingkat
	 *	3.	level
	 *	4.	created_at
	 *	5.	updated_at
	 *	6.  catatan
	 */
	protected $table = 'kelasroot';
}
class Jurusan_Model extends Sarung_Model_Root{
	/**
	 *	Pelajaran table has following column
	 *	1.	id
	 *	2.	nama
	 *	3.	inisial
	 *	4.	created_at
	 *	5.	updated_at
	 */
	protected $table = 'jurusan';
}
class Kelas_Model extends Sarung_Model_Root{
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
	protected $table = 'kelas';
	/**
	 *
	 */
	public function KelasRoot() {
     	return $this->belongsTo('Kelas_Root_Model' , 'idkelasroot');
 	}
	/**
	 *
	 */
	public function Jurusan() {
     	return $this->belongsTo('Jurusan_Model' , 'idjurusan');
 	}
	/**
	 *
	 */
	public function Detail(){
		return $this->hasOne("Kelas_Detail_Model" , "Kelas_Detail_Model");
	}

    public function scopeGetfirst($query , $namakelas){
        return $query->where( 'nama', '=', $namakelas)->first();
    }
    public function scopeGetid($query , $namakelas){
    	$obj = $query->where( 'nama', '=', $namakelas);
		return $this->check_and_get_id( $obj);
    }
    public function scopeGet_id_by_name($query , $namakelas){
    	$obj = $query->where( 'nama', '=', $namakelas);
		return $this->check_and_get_id( $obj);
    }

}
/**
 *	i will remove this table , since wali santri can be putten in kelasisi
*/
class Kelas_Detail_Model extends Sarung_Model_Root{
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
	protected $table = 'kelasdetail';
	/**
	 *
	 **/	
	public function Kelas() {
     	return $this->belongsTo('Kelas_Model' , 'idkelas');
 	}
}
