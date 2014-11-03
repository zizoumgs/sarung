<?php
/**
 *  id
 *  nama
*/
class Alamat_Model extends Sarung_Model_Root{
	/**
	 *	var bool
	*/
	protected $ema;
	/**
	 *	var obj
	*/
	protected $obj;
	public function get_anti_fake(){
		return $this->ema;
	}
	
}
class Negara_Model extends Alamat_Model{
	protected $table = 'negara';    
	/**
	 *	Get id negara by its name
	 *	return id
	*/
    public function scopeGet_id($query , $negara_name){
		return $query->where('nama' , '=' , $negara_name)->first();
    }
}
/**
 *  id
 *  nama
 *  idnegara
*/
class Propinsi_Model extends Alamat_Model{
	protected $table = 'propinsi';    
    public function Negara(){
		return $this->belongsTo('Negara_Model', 'idnegara');
    }
	/**
	 *	Get propinsi by negara`s name
	 *	return list of propinsi
	**/
    public function scopeGet_propinsi_of_negara($query , $negara_name){
        $negara = new Negara_Model();
        $negara_id = $negara->get_id($negara_name);
        return $query->where('idnegara' , '=' , $negara_id->id );
    }
	/**
	 *	Get id propinsi by its name and negara id
	 *	return id
	*/
    public function scopeGet_id($query , $negara_name , $propinsi_name ){
        $negara = new Negara_Model();
        $negara_id = $negara->get_id($negara_name);
		return $query->where('idnegara' , '=' , $negara_id->id)
        ->where('nama','=',$propinsi_name)->first();
    }
	/**
	 *	Get id propinsi by its name and negara id
	 *	return namas
	*/
    public function get_namas( $column = "nama" , $order = "DESC"){
		$items = array();
		foreach( $this->orderBy($column , $order)->get() as $result){
			$items [] = $result->nama;
		}
		
		return $items;
    }	
}
/**
 *  id
 *  nama
 *  idpropinsi
*/
class Kabupaten_Model extends Alamat_Model{
	protected $table = 'kabupaten';
    public function Propinsi(){
		return $this->belongsTo('Propinsi_Model', 'idpropinsi');
    }
    /**
     *  return id propinsi
    */
    private function get_id_propinsi($negara_name , $propinsi_name){
   		$propinsi = new Propinsi_Model();
        $propinsi_id = $propinsi->get_id( $negara_name , $propinsi_name );
        return $propinsi_id ; 
    }
	/**
	 *	Get kabupatens by propinsi`s and negara name
	 *	return list of propinsi
	**/
    public function scopeGet_kabupatens_of_propinsi($query , $negara_name , $propinsi_name){
		$this->ema = false;
        $obj = $this->get_id_propinsi($negara_name , $propinsi_name);
        if ( count($obj->first()) == 1){
			$this->ema = true;
      		return $query->where('idpropinsi' , '=' , $obj->id);
		}
		
    }
	/**
	 *	Get id kabupaten by its name and propinsi and negara name
	 *	return id
	*/
    public function scopeGet_id($query , $negara_name , $propinsi_name , $kabupaten_name){
        $propinsi_id = $this->get_id_propinsi( $negara_name , $propinsi_name );
		if ( $propinsi_id->exists()){
			return $query->where('idpropinsi' , '=' , $propinsi_id->id)
	        ->where('nama','=', $kabupaten_name)->first();
		}
		return null;
    }
	/**
	 *	Get id kabupaten by its name and propinsi and negara name
	 *	return id
	*/
    public function scopeGet_first($query , $negara_name , $propinsi_name , $kabupaten_name){
        $propinsi_id = $this->get_id_propinsi( $negara_name , $propinsi_name );
		if ( $propinsi_id->exists()){
			return $query->where('idpropinsi' , '=' , $propinsi_id->id)
	        ->where('nama','=', $kabupaten_name)->first();
		}
		return null;
    }

}
/**
 *  id
 *  nama
 *  idkabupaten
*/
class Kecamatan_Model extends Alamat_Model{
	protected $table = 'kecamatan';
    public function Kabupaten(){
		return $this->belongsTo('Kabupaten_Model', 'idkabupaten');
    }
    /**
     *  return id kabupaten
    */
    private function get_id_kabupaten($negara_name , $propinsi_name , $kabupaten_name){
		$this->ema  = false;
   		$obj = new Kabupaten_Model();
        $kab_id = $obj->get_id( $negara_name , $propinsi_name , $kabupaten_name);
		if( !is_null($kab_id) ){
			return $kab_id->first();
		}
		return null;
    }
	/**
	 *	Get kecamatans by propinsi`s and negara  and kabupaten name
	 *	return list of kecamatan
	**/
    public function scopeGet_kecamatans_of_kabupaten($query , $negara_name , $propinsi_name , $kabupaten_name){
		$db = $this->get_db_name();
		$results = DB::connection( $this->connection)->select( DB::raw("SELECT kec.id as id ,  kec.nama as nama
									   FROM $db.kecamatan kec, $db.kabupaten kab , $db.propinsi pro , $db.negara neg
									   WHERE  neg.id = pro.idnegara
									   and pro.id = kab.idpropinsi
									   and kab.id = kec.idkabupaten
									   and neg.nama = ?
									   and pro.nama = ?
									   and kab.nama = ?
									   order by kec.nama DESC "),
									array($negara_name , $propinsi_name , $kabupaten_name));
		return $results;		
    }
	/**
	 *	Get id kabupaten by its name and propinsi and negara name
	 *	return id
	*/
    public function scopeGet_id($query , $negara_name , $propinsi_name , $kabupaten_name , $kecamatan_name){
		$db = $this->get_db();
		$db = $this->get_db_name();		
		$results = DB::select( DB::raw("SELECT des.id as id_desa ,  des.nama as desa_name , kec.id as id , kec.id as id_kecamatan
									   FROM $db.kecamatan kec, $db.kabupaten kab , $db.propinsi pro , $db.negara neg,
									   $db.desa des 
									   WHERE  neg.id = pro.idnegara
									   and pro.id = kab.idpropinsi
									   and kab.id = kec.idkabupaten
									   and kec.id = des.idkecamatan
									   and neg.nama = ?
									   and pro.nama = ?
									   and kab.nama = ?
									   and kec.nama = ?
									   order by des.nama DESC "),
									array($negara_name , $propinsi_name , $kabupaten_name , $kecamatan_name));
		$hasil = array();
		foreach($results as $res_){
			foreach($res_ as $key => $val ){
				$hasil [$key] = $val ; 	
			}			
		}
		return (object)$hasil;		
    }

}
/**
 *  id
 *  nama
 *  idkecamatan
*/
class Desa_Model extends Alamat_Model{
	protected $table = 'desa';
    public function Kecamatan(){
		return $this->belongsTo('Kecamatan_Model', 'idkecamatan');
    }
	/**
	 *	Get kecamatans by propinsi`s and negara  and kabupaten name
	 *	return list of kecamatan
	**/
    public function scopeGet_desas_of_kecamatan($query , $negara_name , $propinsi_name , $kabupaten_name,$kecamatan_name){
		$db = $this->get_db();
		$db = $this->get_db_name();		
		$results = DB::select( DB::raw("SELECT des.id as id ,  des.nama as nama
									   FROM $db.kecamatan kec, $db.kabupaten kab , $db.propinsi pro , $db.negara neg,
									   $db.desa des 
									   WHERE  neg.id = pro.idnegara
									   and pro.id = kab.idpropinsi
									   and kab.id = kec.idkabupaten
									   and kec.id = des.idkecamatan
									   and neg.nama = ?
									   and pro.nama = ?
									   and kab.nama = ?
									   and kec.nama = ?
									   order by des.nama DESC "),
									array($negara_name , $propinsi_name , $kabupaten_name , $kecamatan_name));
		return $results;		
    }
	/**
	 *	Get only one row
	 *	return one row array
	**/
    public function get_first($negara_name , $propinsi_name , $kabupaten_name,$kecamatan_name , $desa_name){
		$db = $this->get_db();
		$db = $this->get_db_name();		
		$results = DB::select( DB::raw("SELECT des.id as id ,  des.nama as nama
									   FROM $db.kecamatan kec, $db.kabupaten kab , $db.propinsi pro , $db.negara neg,
									   $db.desa des 
									   WHERE  neg.id = pro.idnegara
									   and pro.id = kab.idpropinsi
									   and kab.id = kec.idkabupaten
									   and kec.id = des.idkecamatan
									   and neg.nama = ?
									   and pro.nama = ?
									   and kab.nama = ?
									   and kec.nama = ?
									   and des.nama = ?
									   "),
									array($negara_name , $propinsi_name , $kabupaten_name , $kecamatan_name , $desa_name));

		foreach($results as $val ){
			$array ['id'] =  $val->id;
			$array ['nama'] =  $val->nama;
		}
		return (object) $array;
    }
}



