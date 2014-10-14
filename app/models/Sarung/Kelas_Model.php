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
        return $query->where( 'nama', '=', $namakelas);
    }

}
/**
**	kelasisi
**/
class Class_Model extends Sarung_Model_Root{
    protected $table = 'kelasisi';
	/**
	 *
	 */
	public function Santri(){
		return $this->belongsTo('Santri_Model', 'idsantri');
	}
	/**
	 *
	 */
	public function Session(){
		return $this->belongsTo('Session_Model', 'idsession');
	}
	/**
	 *
	 */
	public function Kelas(){
		return $this->belongsTo("Kelas_Model" , 'idkelas');
	}
	/**
	***	function to get kelas according to id santri
	***	return obj
	**/
	public function getkelassantribyid($santri_id){
		$sql = " select kel.nama as kelas_name, ses.nama as session_name  , keli.id as id ,kel.id as idkelas
		from kelasisi keli , santri san , admind adm , kelas kel , session ses
		where san.idadmind = adm.id 
		and keli.idsession = ses.id
		and keli.idsantri  = san.id 
		and keli.idkelas   = kel.id
		and san.id         = ?
		";
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) 	 , array($santri_id)  );
		return (object)$kelas;
	}
    /**
    ** this function should be called everytime you wanna delete  item from kelasisi`s table
    ** return 
    **/
    public function getidujiansantri($idkelas , $idsantri){
		$sql = " 
			select count(*) as total
			from ujian uji , santri san , ujiansantri ujis 
			where uji.id = ujis.idujian 
			and ujis.idsantri = san.id
			and uji.idkelas = ? and san.id = ?
		";
		$kelas = DB::connection($this->get_db())->select( DB::raw( $sql ) 	 , array( $idkelas , $idsantri)  );
		return (object)$kelas;
    }

}
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
