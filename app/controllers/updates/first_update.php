<?php
/**
 *  You should run this query since i made big changes for sarung application
 *  And you should run it once
*/
class first_update extends Controller{
    /**
     *  Will hold eveyrthing
     *  var array
    */
    protected $value;
    /**
     *  Execute returning query
     *  var array
    */    
    protected function exe_query($query , $where =array()){
        DB::connection( $this->get_db()) -> select( DB::raw($query) , $where );
    }
    /**
     *  Execute non returning query
     *  var array
    */    
    protected function exe_non_query($query , $values = array()){
        DB::connection( $this->get_db()) -> statement( $query , $values );
    }
    /**
     *  get db because i have plan to use multiple database
     *  return string
    */    
    protected function get_db(){return $this->value ['db_name'] ;}
    /**
     *  set db`s name
     *  return none
    */
    protected function set_db($name){ $this->value['db_name'] = $name ;}
    /*
        Has tested
        ALTER TABLE fusarung.petugas ADD COLUMN nomorstatistik VARCHAR(30) NOT NULL;
        you also use datatype as additional information like below
        ALTER TABLE santri add idsession INTEGER NOT NULL DEFAULT 1,
        add CONSTRAINT fk_session FOREIGN KEY (idsession)REFERENCES session(id)ON DELETE NO ACTION ON UPDATE CASCADE
        in above example datatype can be filled by text from INTEGER to CASCADE
    */
    function add_column($table_name , $column_name , $datatype){
        $sql = sprintf('ALTER TABLE %1$s ADD %2$s %3$s' , $table_name , $column_name , $datatype );  	
        $this->exe_non_query( $sql );
    }
    /**
     *  Delete column
     *  return none
    */
    function del_column($table_name , $column_name){
        $sql = sprintf('ALTER TABLE %1$s DROP %2$s' , $table_name , $column_name);
        $this->exe_non_query( $sql );
    }
    /**
     *  Delete column constrain
     *  return none
    */
    function del_constraint($table_name , $key_name){
    	$sql = sprintf('ALTER TABLE %1$s
      		DROP FOREIGN KEY %2$s' , $table_name , $key_name);
        $this->exe_non_query( $sql );
    }
    /**
     *  Delete unique column
     *  return none
    */
    function del_unique($table_name , $unique_name){
        $sql = sprintf('alter table %1$s drop index %2$s', $table_name , $unique_name);
        $this->exe_non_query( $sql ) ; 
    }
    /**
     *  Change column`s name
     *  return none
    */
    function change_column_name( $table_name , $column_name , $to_be_name , $to_type = '' ){
        $sql = sprintf('ALTER TABLE %1$s CHANGE %2$s %3$s %4$s ' , $table_name , $column_name  , $to_be_name, $to_type );
        $this->exe_non_query( $sql ) ; 
    }
     /**
     *  remove given table
     *  return none
    */   
    function remove_table( $table_name ){
    	$sql = sprintf('DROP TABLE %1$s ' , $table_name);
        $this->exe_non_query( $sql ) ; 
    }
    /**
    *** Begin to update database
    *** return array 
    ***/
    function get_some_santri_col($table = 'santri'){
        return DB::connection( $this->get_db())->table($table)->get();
    }
    /**
     *  get max count
     *  return integer
    **/
    function get_max_id( $table ){
        return DB::connection( $this->get_db())->table($table)->max('id');
    }    
    /**	
    ***	Rename , add , and delete columns from some table
    ***/
    function prepare_tables(){
    	// editing admind`s table
    	// first section 
    	$admind = 'admind';
    	$this->change_column_name($admind , 'nama' ,'email' , ' VARCHAR(50) ');
    	$this->change_column_name($admind , 'katakunci' ,'password' , 'VARCHAR (100)');
    	$this->add_column( $admind , 'remember_token' , 'VARCHAR (100)' );
    	$this->add_column($admind , 'last_login' , ' DATE NOT NULL DEFAULT \'2014-10-02 01:01:01\' ' );
    	$this->add_column($admind , 'updated_at' , ' DATE NOT NULL DEFAULT \'2014-10-02 01:01:01\' ' );
    	$this->add_column($admind , 'created_at' , ' DATE NOT NULL DEFAULT \'2014-10-02 01:01:01\' ' );
    	// second section: prepare column in admin`s table which will be inserted by data in santri`s table
    	$this->add_column($admind , 'first_name'  , ' VARCHAR (50) NOT NULL DEFAULT "no name" ' );
    	$this->add_column($admind , 'second_name' , ' VARCHAR (50) NOT NULL DEFAULT "no name"  ' );
    	$this->add_column($admind , 'lahir' , ' DATE NULL DEFAULT \'2014-10-02 01:01:01\'' );
    	$this->add_column($admind , 'foto'  , ' VARCHAR (100) ' );
    	$this->add_column($admind , 'jenis'  , ' enum(\'L\',\'W\') DEFAULT \'L\' ' );
    	/*
    		-1: banned studend 
    		0: not inserted into santri table , this for new registering student
    		1 : non_aktif -> cannot edit , just view 
    		2 : aktif 	 -> can edit
    	*/
    	$this->add_column($admind , 'status'  , ' INT(11) DEFAULT 0 ' ); 
    	$this->add_column($admind , 'idtempat'  , ' int(11) NOT NULL DEFAULT 1 , 
    		ADD CONSTRAINT fk_tempat FOREIGN KEY (idtempat) REFERENCES kabupaten (id) ON DELETE NO ACTION ON UPDATE CASCADE' );
    	$this->add_column($admind , 'iddesa'  , ' int(11) NOT NULL DEFAULT 1 ,
    		ADD CONSTRAINT fk_desa FOREIGN KEY (iddesa) REFERENCES desa (id) ON DELETE NO ACTION ON UPDATE CASCADE' );
    	//! add column to santri col , you have to update it after moving data to admind`s table
    	$santri = 'santri';
    	$this->add_column($santri , 'idadmind'  , ' int(11) NOT NULL DEFAULT 1 ,		
    		ADD CONSTRAINT fk_admind FOREIGN KEY (idadmind) REFERENCES admind (id) ON DELETE NO ACTION ON UPDATE CASCADE' );
    }
    /**
     *  remove some of santri`s cols
     *  return none
    */
    function remove_unused_santri_cols(){
    	$santri = 'santri';
    	//! remove constrain first
    	$names = array('santri_ibfk_1' , 'santri_ibfk_2','santri_ibfk_3','santri_ibfk_4','santri_ibfk_5','santri_ibfk_6','santri_ibfk_7');
    	foreach ($names as $name) {
    		$this->del_constraint( $santri , $name);
    	}
    	//! then remove unique name 
    	$this->del_unique($santri , 'nama');
    	// finally
    	$cols = array(
    		'nama',
    		'nama_',
    		'jenis',
    		'idtempat',
    		'lahir',
    		'iddesa',
    		'detail',
    		'idsekolah',
    		'masuk',
    		'nisa',
    		'idsuratin',
    		'awalsession',
    		'idsuratout',
    		'idkelasakhir',
    		'idkelasawal',
    		'keluar',
    		'idreason',
    		'idayah',
    		'idibu',
    		'idwali',
    		'lanjutke',
    		'foto',
    		'perkiraansantri'
       	);
       	foreach($cols as $col){
        	echo sprintf('Try to remove %1$s <br>',$col);
        	$this->del_column($santri , $col );
        }
    }

    /**
     *  moving some data`s santri to admind`s santri
     *  return none
    */
    function moving_data(){
    	$date = date('Y-m-d');
    	$default_group = 4;
    	$id = $this->get_max_id('admind');
    	//! insert 
    	$santries = $this->get_some_santri_col();
    	foreach ($santries as $santri):
    		$id++;
    		# code...
    		$sql = "INSERT INTO admind(
    			id,
    	        	first_name,
    	            second_name,
    	            lahir,
    	            jenis,
    	            foto,
    	            iddesa,
    	            idtempat,

    	        email,
        	        remember_token,
           	    	last_login,
             	   	password,
             	   	idgroup    ,
             	   	updated_at ,
             	   	created_at 
             	   	)
    			VALUES (
    				:id,
            	    :first_name, 
            	    :second_name, 
            	    :lahir, 
            	    :jenis, 
            	    :foto,
    	            :iddesa,
        	        :idtempat , 
    
            	    :email ,
    	            :remember_token ,
        	        :last_login ,
            	    :password ,
    	            :idgroup,
        	        :updated_at ,
    	    :created_at)";
            $values = array(
                'id' => $id ,
                'first_name' => $santri->nama ,
                'second_name' => $santri->nama_ ,
                'lahir'         =>  $santri->lahir ,
                'jenis'         =>  $santri->jenis ,
                'foto'          =>  $santri->foto  ,
                'iddesa'        =>  $santri->iddesa ,
                'idtempat'      =>  $santri->idtempat ,
                
                'email'         =>  sprintf('%1$s_%2$s@gmail.com' , $santri->nama, $santri->id )  ,
                'remember_token' => '' ,
                'last_login'     => '0000-00-00' , 
                'password'       => Hash::make( $santri->nama ) ,
                'idgroup'       =>  $default_group ,
                'updated_at'    =>  $date ,
                'created_at'    =>  $date
                );
            $this->exe_non_query($sql , $values);
    		//! edit santri 
    		$sql = "UPDATE santri SET idadmind = :idadmind WHERE id = :id";    		
    		$array = array('idadmind' => $id , 'id' => $santri->id  );
            $this->exe_non_query($sql , $array);
    	endforeach;
    }
    /**
     *  create super admind for this application
     *  return none
    */
    protected function create_super_admind(){
    	$sql = "UPDATE admind SET password = :password , email = :email WHERE id = :id";
    	$array = array('password' => Hash::make('112298')  , 'email' => 'zizoumgs@gmail.com', 'id' => 1  );
           $this->exe_non_query($sql , $array);
    }
    /**
     *  I`m clueless for this constructor
     *  return none
    */    
    public function __construct(){
    }
    /**
     *  default view during running this application
     *  return none
    */    
    public function getIndex(){
        set_time_limit(1600);
        $this->set_db('fusarung');
    	echo "Prepare both santri and admin tables<br>";
    	$this->prepare_tables();
        $this->create_super_admind();
        echo "Done<br>Next is to Insert into admind table and the update santri table<br>";
        $this->moving_data();
        echo "Done<br>Next is to remove unused santri columns<br>";
        $this->remove_unused_santri_cols();        
    }
    
}