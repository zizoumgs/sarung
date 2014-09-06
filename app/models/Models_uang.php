<?php
/*
    All model from uang will be placed here
*/
class Models_uang extends Root_model{
	public function __construct(){}
	/*Manual Base Query*/
	public function set_base_query($query){		$this->base_query = $query ;	}
	/*Automatic Base Query , the alias header name will have 5 column*/
	public function set_base_query_income(){
		$alias_header_name = array( "income_id" , "divisi_name" , "divisisub_name" , 'jumlah' , 'tanggal' , 'updated_at' );
		$first = sprintf( '
			select main.id as %1$s , third.nama as %2$s, second.nama as %3$s,
			main.jumlah as %4$s  , main.tanggal as %5$s , main.updated_at as %6$s
			from income main , divisi third , divisisub second
			where second.id = main.idsubdivisi and third.id = second.iddivisi 
		',
		$alias_header_name [0] , 
		$alias_header_name [1] , 
		$alias_header_name [2] ,
		$alias_header_name [3] ,
		$alias_header_name [4] ,
        $alias_header_name [5]
		);
		$this->set_alias($alias_header_name);
		$this->set_base_query($first);
	}
	/*Automatic Base Query , the alias header name will have 5 column*/
	public function set_base_query_outcome(){
		$alias_header_name = array( "income_id" , "divisi_name" , "divisisub_name" , 'jumlah' , 'tanggal' );
		$first = sprintf( '
			select main.id as %1$s , third.nama as %2$s, second.nama as %3$s,
			main.jumlah as %4$s  , main.tanggal as %5$s
			from outcome main , divisi third , divisisub second
			where second.id = main.idsubdivisi and third.id = second.iddivisi 
		',
		$alias_header_name [0] , 
		$alias_header_name [1] , 
		$alias_header_name [2] ,
		$alias_header_name [3] ,
		$alias_header_name [4]
		);
		$this->set_alias($alias_header_name);
		$this->set_base_query($first);
	}
}

