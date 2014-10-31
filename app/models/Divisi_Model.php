<?php

class Divisi_Model extends Uang_Root_Model {
	protected $table = 'divisi';
    public function divisisub(){
        return $this->has_one('Divisisub_Model' , 'iddivisi');
    }
	/**
	 * get id by division name
	*/
	public function scopeGetid($query , $name){
		$model = $query->where('nama' , '=' , $name);
		if($model->first()){
			return $model->first()->id ; 
		}
		return -1;
	}
}