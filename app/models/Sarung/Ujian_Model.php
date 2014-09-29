<?php
/**
 *  below is columns which is has by ujian table
 *  id
 *  idpelajaran
 *  idkalender
 *  idkelas
 *  pelaksanaan	(I think i can remove this since there are date on event table)
 *  catatan
 *  minnilai	(I think to remove this)
 *  kalinilai
 *  tempat
 *  idsession   (will be removed)
*/
class Ujian_Model extends Sarung_Model_Root{
	protected $table = 'ujian';
	
    public function Kalender(){
       return $this->belongsTo('Kalender_Model' ,'idkalender');
    }    
    public function Pelajaran(){
       return $this->belongsTo('Pelajaran_Model' ,'idpelajaran');
    }
    public function Kelas(){
        return $this->belongsTo('Kelas_Model' ,'idkelas');
    }
}
/**
 *  below is columns which is has by ujian tableaddon
 *  id
 *  idujian
 *  file
*/
class Ujian_Model_AddOn extends Sarung_Model_Root{
	protected $table = 'ujianaddon';
    public function Ujian(){
       return $this->belongsTo('Ujian_Model' ,'idujian');
    }    
}


