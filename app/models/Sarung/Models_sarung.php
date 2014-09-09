<?php
/*
    All model from sarung will be placed here
*/
class Models_sarung extends Root_model{
	public function __construct( ){
		parent::__construct("fusarung");
    }
	/*Manual Base Query*/
	public function set_base_query($query){		$this->base_query = $query ;	}
	/*Automatic Base Query , the alias header name will have 5 column*/
	public function set_base_query_santri( $alias_header_name = array( "image",'nama', "id" , "nis" , 'ijazah' ,'kecamatan') ){
		$first = sprintf( '
			select san.foto as %2$s,
            concat( san.nama," ",if(san.nama_="","_",san.nama_)) as %3$s,
            san.id as %4$s ,
            concat(DATE_FORMAT(ses.awal,"%%y"),LPAD(san.nis,ses.perkiraansantri, "0") )as  %5$s,
            if( (select count(*) from %1$s.santriaddon where idsantri = san.id)>0,"Ada","Tidak ada") as %6$s,
			kec.nama as %7$s 			
			from %1$s.santri san , %1$s.wali wal , %1$s.sekolah sek ,
			%1$s.session ses , %1$s.kelasisireason kelir ,	%1$s.desa des , %1$s.kecamatan kec
			where kelir.id=san.idreason and san.idayah = wal.id and san.idsekolah = sek.id  and ses.id = san.idsession
			and kec.id = des.idkecamatan and des.id = san.iddesa
		',
		$this->get_database_name(),
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
		$alias_header_name = array( "income_id" , "divisi_name" , "divisisub_name" , 'jumlah' , 'tanggal', 'updated_at' );
		$first = sprintf( '
			select main.id as %1$s , third.nama as %2$s, second.nama as %3$s,
			main.jumlah as %4$s  , main.tanggal as %5$s , main.updated_at as %6$s
			from outcome main , divisi third , divisisub second
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
}

