<?php
class Divisi extends Eloquent {	
	protected $table = 'divisi';
    public function divisisub(){
        return $this->has_one('divisisub' , 'iddivisi');
    }
}