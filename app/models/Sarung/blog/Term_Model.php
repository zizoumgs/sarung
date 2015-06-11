<?php
class Term_Model extends Sarung_Model_Root{
	protected $table = 'blo_terms';
}

class Taxonomy_Model extends Sarung_Model_Root{
	protected $table = 'blo_term_taxonomy';

    public function Term(){
		return $this->belongsTo('Term_Model' , 'term_id');
    }	

}
