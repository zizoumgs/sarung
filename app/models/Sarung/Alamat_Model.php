<?php
/**
 *  id
 *  nama
*/
class Negara_Model extends Sarung_Model_Root{
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
class Propinsi_Model extends Sarung_Model_Root{
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
}
/**
 *  id
 *  nama
 *  idpropinsi
*/
class Kabupaten_Model extends Sarung_Model_Root{
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
        $propinsi_id = $this->get_id_propinsi($negara_name , $propinsi_name);
        if ($propinsi_id->exists())
      		return $query->where('idpropinsi' , '=' , $propinsi_id->id);
    }
	/**
	 *	Get id kabupaten by its name and propinsi and negara name
	 *	return id
	*/
    public function scopeGet_id($query , $negara_name , $propinsi_name , $kabupaten_name){
        $propinsi_id = $this->get_id_propinsi( $negara_name , $propinsi_name );
		return $query->where('idpropinsi' , '=' , $propinsi_id->id)
        ->where('nama','=', $kabupaten_name)->first();
    }
}
/**
 *  id
 *  nama
 *  idkabupaten
*/
class Kecamatan_Model extends Sarung_Model_Root{
	protected $table = 'kecamatan';
    public function Kabupaten(){
		return $this->belongsTo('Kabupaten_Model', 'idkabupaten');
    }
    /**
     *  return id kabupaten
    */
    private function get_id_kabupaten($negara_name , $propinsi_name , $kabupaten_name){
   		$obj = new Kabupaten_Model();
        return $obj->get_id( $negara_name , $propinsi_name , $kabupaten_name);
    }
	/**
	 *	Get kecamatans by propinsi`s and negara  and kabupaten name
	 *	return list of kecamatan
	**/
    public function scopeGet_kecamatans_of_kabupaten($query , $negara_name , $propinsi_name , $kabupaten_name){
        $obj = $this->get_id_kabupaten($negara_name , $propinsi_name , $kabupaten_name);
        if ( $obj->exists())
      		return $query->where('idkabupaten' , '=' , $obj->id);
    }
	/**
	 *	Get id kabupaten by its name and propinsi and negara name
	 *	return id
	*/
    public function scopeGet_id($query , $negara_name , $propinsi_name , $kabupaten_name , $kecamatan_name){
        $obj = $this->get_id_kabupaten( $negara_name , $propinsi_name , $kabupaten_name );
		return $query->where('idkabupaten' , '=' , $obj->id)
        ->where('nama','=', $kecamatan_name)->first();
    }
}
/**
 *  id
 *  nama
 *  idkecamatan
*/
class Desa_Model extends Sarung_Model_Root{
	protected $table = 'desa';
    public function Kecamatan(){
		return $this->belongsTo('Kecamatan_Model', 'idkecamatan');
    }
}



