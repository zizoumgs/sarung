<?php
/**
 *	Pelajaran table has following column
 *	1.	id
 *	2.	nama
 *	3.	inisial
 *	4.	created_at
 *	5.	updated_at
*/
class Pelajaran_Model extends Sarung_Model_Root{
	protected $table = 'pelajaran';

    public function scopeGet_id_by_name($query , $name){
		$result =  $query->where('nama' , '=' , $name);
		return $this->check_and_get_id($result);
    }    	
}
