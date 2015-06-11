<?php
/**
 *  You should run this query since i made big changes for sarung application
 *  And you should run it once
*/
class update_support extends Controller{
    /**
     *  I`m clueless for this constructor
     *  return none
    */    
    public function __construct(){
    }
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
	 *	Change table`s name
	*/
	public function change_table_name($col_name , $desire_name){
		$sql = sprintf('RENAME TABLE %1$s TO %2$s' , $col_name , $desire_name);
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
	
	protected function get_sarung_db(){
		return Config::get("database.connections.fusarung.database");
	}
	protected function get_user_name_main(){
		return Config::get("database.main_username");
	}
	protected function get_password_main(){
		return Config::get("database.main_password");
	}
	
	protected function get_db_sarung_object(){
		$sarung = $this->get_sarung_db();
		$db_sarung = new PDO("mysql:host=localhost;dbname=$sarung;charset=utf8", $this->get_user_name_main() , $this->get_password_main() );
		return $db_sarung;
	}
}
/**
 *	third update will add several column in session
*/
class update_third extends update_support{
    /**
     *  I`m clueless for this constructor
     *  return none
    */    
    public function __construct(){
		parent::__construct();
    }
	/**
	**/
	public function init_third(){
		$table = 'sessionaddon';
		//@ change naik_kelas to sessionaddon
		$this->change_table_name('naik_kelas' , $table);
		//@ delete col alias in session table
		$this->del_column('session','alias');
		//@ add some table
		$this->add_column($table , "created_at"		, ' DATETIME DEFAULT \'2014-01-01\' ' );
		$this->add_column($table , 'updated_at'  	, ' DATETIME DEFAULT \'2014-01-01\' ' );
		
		//@ change column`s data
		$session_add = Session_Addon_Model::get();
		foreach($session_add as $item){
			$tmp = Session_Addon_Model::find	($item->id);
			$tmp->model = "Persen";
			$tmp->save();				
		}
		//@ insert new data for 14-15
		$session = Session_Model::where('nama','=','14-15');
		if( $session->first()){
			$session_add = new Session_Addon_Model();
			$session_add->nilai = 10;
			$session_add->model = "Persen";
			$session_add->idsession = $session->first()->id;
			$session_add->save();
		}
	}
}
/**
 *	Update tindakan
*/
class update_tindakan extends update_third{
	public function __construct(){
		parent::__construct();
	}
	/**
	**/
	public function init_update_tindakan(){
		//@ get object
		$sarung = $this->get_sarung_db();
		$db_sarung = new PDO("mysql:host=localhost;dbname=$sarung;charset=utf8", $this->get_user_name_main() , $this->get_password_main() );
		$db = new PDO('mysql:host=localhost;dbname=mgscom_iman;charset=utf8', $this->get_user_name_main() , $this->get_password_main() );
		//@ get names of tindakan
		//
		$sql = "select namaLarangan as nama_larangan from larangan group by nama_larangan";
		$larangan = $db->query( $sql );
		//@ create nama of tindakan
		//
		$table_name = "larangan_nama";
		$sql =  "CREATE TABLE IF NOT EXISTS $table_name( ".
				"id INT NOT NULL, ".
				"nama VARCHAR(70) NOT NULL, ".
				"updated_at DATETIME ,".
				"created_at DATETIME ,". 
				"UNIQUE(nama), ".
				"PRIMARY KEY ( id ))ENGINE=InnoDB DEFAULT CHARSET=latin1; ";
		$result = $db_sarung->exec($sql);
		//@ insert what we got before
		$id = 1 ; 
		foreach($larangan as $row) {
			$nama = addslashes($row['nama_larangan']);
			$result = $db_sarung->exec("INSERT INTO $table_name(id,nama) VALUES($id,'$nama')");
			$id++;
		}
		//@ get  name of tindakan with session
		//
		$db_sarung->query("SET wait_timeout=12000;");
		$db->query("SET wait_timeout=1200;");
		$this->insert_into_larangan_meta($db_sarung , $db);
		$this->insert_into_larangan_kasus($db_sarung , $db);
	}
	/**
	 *	get id sarung according to id santri on iman application
	***/
	private function get_id_on_sarung($id_iman , $santries){
		$hasil = 0;
		foreach($santries as $santri){
			//! same 
			if( $santri ['idiman'] == $id_iman){
				$hasil =  $santri ['idsarung'];
				break;
			}
		}
		if($hasil == 0 ){
			//@ danger
			echo $id_iman ."</br>";
		}
		return $hasil;
	}
	/**
	***/
	private function get_id_list(){
$santri = array(
	array( // row #0
		'idiman' => 1,
		'idsarung' => 55,
		'nama' => 'ABD KODIR',
	),
	array( // row #1
		'idiman' => 2,
		'idsarung' => 68,
		'nama' => 'M SYAFI\'I',
	),
	array( // row #2
		'idiman' => 3,
		'idsarung' => 53,
		'nama' => 'AHMAD FUADI',
	),
	array( // row #3
		'idiman' => 4,
		'idsarung' => 19,
		'nama' => 'HARIYANTO',
	),
	array( // row #4
		'idiman' => 5,
		'idsarung' => 69,
		'nama' => 'PURWANTO',
	),
	array( // row #5 , no id
		'idiman' => 6,
		'idsarung' => 39,
		'nama' => 'SIROZUZZAMAN',
	),
	array( // row #6
		'idiman' => 7,
		'idsarung' => 90,
		'nama' => 'NUR SIWAN',
	),
	array( // row #7
		'idiman' => 8,
		'idsarung' => 147,
		'nama' => 'BUDIANTO',
	),
	array( // row #8
		'idiman' => 9,
		'idsarung' => 61,
		'nama' => 'HAFID SUNNI',
	),
	array( // row #9
		'idiman' => 10,
		'idsarung' => 148,
		'nama' => 'IKROM',
	),
	array( // row #10
		'idiman' => 11,
		'idsarung' => 170,
		'nama' => 'AINUL YAKIN',
	),
	array( // row #11
		'idiman' => 12,
		'idsarung' => 25,
		'nama' => 'ZAINUDDIN',
	),
	array( // row #12
		'idiman' => 13,
		'idsarung' => 21,
		'nama' => 'MUSOFFA\'',
	),
	array( // row #13
		'idiman' => 14,
		'idsarung' => 247,
		'nama' => 'MOHAMMAD AKIB',
	),
	array( // row #14
		'idiman' => 16,
		'idsarung' => 273,
		'nama' => 'ARDI WAHYU',
	),
	array( // row #15
		'idiman' => 17,
		'idsarung' => 359,
		'nama' => 'SULTON ADI WIJAYA',
	),
	array( // row #16
		'idiman' => 18,
		'idsarung' => 66,
		'nama' => 'MUHAMMAD SHOLEH',
	),
	array( // row #17
		'idiman' => 21,
		'idsarung' => 65,
		'nama' => 'KHOIRUL ANAM',
	),
	array( // row #18
		'idiman' => 22,
		'idsarung' => 59,
		'nama' => 'BUSTOMI',
	),
	array( // row #19 , mat kool
		'idiman' => 23,
		'idsarung' => 348,
		'nama' => 'MUHAMMAD',
	),
	array( // row #20
		'idiman' => 24,
		'idsarung' => 144,
		'nama' => 'MUHAMMAD ZAINI',
	),
	array( // row #21
		'idiman' => 25,
		'idsarung' => 145,
		'nama' => 'MOHAMMAD AHSAN',
	),
	array( // row #22
		'idiman' => 26,
		'idsarung' => 85,
		'nama' => 'NURHALIS SABANA',
	),
	array( // row #23 , ENDUT
		'idiman' => 27,
		'idsarung' => 520,
		'nama' => 'SHOLEHUDDIN',
	),
	array( // row #24
		'idiman' => 29,
		'idsarung' => 63,
		'nama' => 'IMAM SAFI\'I',
	),
	array( // row #25
		'idiman' => 30,
		'idsarung' => 89,
		'nama' => 'ACHMAD SYAIFUDDIN KARIM',
	),
	array( // row #26 
		'idiman' => 31,
		'idsarung' => 37,
		'nama' => 'MUNIR',
	),
	array( // row #27
		'idiman' => 32,
		'idsarung' => 142,
		'nama' => 'ABDOL GHOFUR',
	),
	array( // row #28
		'idiman' => 35,
		'idsarung' => 23,
		'nama' => 'MIDUN',
	),
	array( // row #29
		'idiman' => 36,
		'idsarung' => 62,
		'nama' => 'HARIYANTO',
	),
	array( // row #30
		'idiman' => 37,
		'idsarung' => 14,
		'nama' => 'ARIS KURNIAWAN',
	),
	array( // row #31
		'idiman' => 38,
		'idsarung' => 38,
		'nama' => 'SOLEMAN',
	),
	array( // row #32
		'idiman' => 39,
		'idsarung' => 144,
		'nama' => 'ABDUR ROHMAN',
	),
	array( // row #33
		'idiman' => 40,
		'idsarung' => 285,
		'nama' => 'YULIANTO',
	),
	array( // row #34 
		'idiman' => 41,
		'idsarung' => 82,
		'nama' => 'ROHMAN IMAM MAWARDI',
	),
	array( // row #35
		'idiman' => 42,
		'idsarung' => 272,
		'nama' => 'ANTO WIJAYA',
	),
	array( // row #36
		'idiman' => 43,
		'idsarung' => 155,
		'nama' => 'ROBBY AGUS SALIM',
	),
	array( // row #37
		'idiman' => 44,
		'idsarung' => 92,
		'nama' => 'RIZKI ZAENAL ANWAR',
	),
	array( // row #38 glen , CREATE
		'idiman' => 45,
		'idsarung' => 297,
		'nama' => 'SUPRIYADI',
	),
	array( // row #39 , it should be dedi purnomo
		'idiman' => 46,
		'idsarung' => 389,
		'nama' => 'DEDI PURWANTO',
	),
	array( // row #40
		'idiman' => 47,
		'idsarung' => 56,
		'nama' => 'MOCH. KHOLIL',
	),
	array( // row #41
		'idiman' => 48,
		'idsarung' => 16,
		'nama' => 'IMRON',
	),
	array( // row #42
		'idiman' => 49,
		'idsarung' => 15,
		'nama' => 'ANDRE',
	),
	array( // row #43 
		'idiman' => 51,
		'idsarung' => 488,
		'nama' => 'ACHMAD RIDO\'I',
	),
	array( // row #44 
		'idiman' => 52,
		'idsarung' => 489,
		'nama' => 'LUKMAN ',
	),
	array( // row #45
		'idiman' => 53,
		'idsarung' => 152,
		'nama' => 'MUAFI ',
	),
	array( // row #46
		'idiman' => 54,
		'idsarung' => 64,
		'nama' => 'KHAIRUL ANAM',
	),
	array( // row #47
		'idiman' => 55,
		'idsarung' => 17,
		'nama' => 'FAISAL ARIFIN',
	),
	array( // row #48
		'idiman' => 56,
		'idsarung' => 283,
		'nama' => 'MOCH. NURULLAH',
	),
	array( // row #49
		'idiman' => 57,
		'idsarung' => 22,
		'nama' => 'MUHAMMAD BAKIR MZ',
	),
	array( // row #50, CREATED
		'idiman' => 58,
		'idsarung' => 521,
		'nama' => 'SYAIFUDDIN',
	),
	array( // row #51
		'idiman' => 60,
		'idsarung' => 60,
		'nama' => 'DAFID KURNIAWAN',
	),
	array( // row #52
		'idiman' => 61,
		'idsarung' => 154,
		'nama' => 'MUSTAQIM',
	),
	array( // row #53
		'idiman' => 62,
		'idsarung' => 156,
		'nama' => 'SHOLEHUDIN',
	),
	array( // row #54
		'idiman' => 63,
		'idsarung' => 160,
		'nama' => 'WARISUL HUDA',
	),
	array( // row #55
		'idiman' => 64,
		'idsarung' => 146,
		'nama' => 'ACHMAD SODIKIN',
	),
	array( // row #56
		'idiman' => 66,
		'idsarung' => 344,
		'nama' => 'BABUN NUR JANNAH',
	),
	array( // row #57
		'idiman' => 67,
		'idsarung' => 276,
		'nama' => 'HERMANSYAH',
	),
	array( // row #58
		'idiman' => 68,
		'idsarung' => 159,
		'nama' => 'UMAR FARUQ',
	),
	array( // row #59 
		'idiman' => 69,
		'idsarung' => 490,
		'nama' => 'EDI',
	),
	array( // row #60 
		'idiman' => 70,
		'idsarung' => 491,
		'nama' => 'RUDI',
	),
	array( // row #61
		'idiman' => 71,
		'idsarung' => 145,
		'nama' => 'ACHMAD ZAELANI',
	),
	array( // row #62
		'idiman' => 72,
		'idsarung' => 153,
		'nama' => 'MUHAMMAD JEPRI',
	),
	array( // row #63
		'idiman' => 74,
		'idsarung' => 492,
		'nama' => 'ROISUL HAKIM',
	),
	array( // row #64
		'idiman' => 75,
		'idsarung' => 157,
		'nama' => 'SUKRIANTO',
	),
	array( // row #65
		'idiman' => 76,
		'idsarung' => 7,
		'nama' => 'ZAENAL',
	),
	array( // row #66
		'idiman' => 77,
		'idsarung' => 11,
		'nama' => 'MOCH ILHAM',
	),
	array( // row #67
		'idiman' => 78,
		'idsarung' => 67,
		'nama' => 'MOH. MA\'RUF',
	),
	array( // row #68 
		'idiman' => 79,
		'idsarung' => 493,
		'nama' => 'MIFTAHUL ULUM',
	),
	array( // row #69
		'idiman' => 80,
		'idsarung' => 88,
		'nama' => 'ROQIEB',
	),
	array( // row #70
		'idiman' => 86,
		'idsarung' => 345,
		'nama' => 'ILHAM ZAELANI',
	),
	array( // row #71
		'idiman' => 87,
		'idsarung' => 397,
		'nama' => 'SUHARTAJI',
	),
	array( // row #72
		'idiman' => 88,
		'idsarung' => 494,
		'nama' => 'SUYITNO',
	),
	array( // row #73
		'idiman' => 90,
		'idsarung' => 342,
		'nama' => 'AHMAD RISKI',
	),
	array( // row #74
		'idiman' => 93,
		'idsarung' => 495,
		'nama' => 'ANDI PURWANTO',
	),
	array( // row #75 
		'idiman' => 94,
		'idsarung' => 496,
		'nama' => 'M. SYAHID',
	),
	array( // row #76
		'idiman' => 95,
		'idsarung' => 225,
		'nama' => 'MUHAMMAD  MUNAWWIR',
	),
	array( // row #77
		'idiman' => 96,
		'idsarung' => 224,
		'nama' => 'IRGI AHMAD FAHREZY',
	),
	array( // row #78
		'idiman' => 97,
		'idsarung' => 340,
		'nama' => 'AHMAD BASORI',
	),
	array( // row #79
		'idiman' => 99,
		'idsarung' => 158,
		'nama' => 'SYAMSUR RIDLO YATULLOH',
	),
	array( // row #80
		'idiman' => 100,
		'idsarung' => 352,
		'nama' => 'MUHAMMAD HENDRIK',
	),
	array( // row #81
		'idiman' => 104,
		'idsarung' => 353,
		'nama' => 'M. NURUL HIDAYAT',
	),
	array( // row #82 
		'idiman' => 107,
		'idsarung' => 497,
		'nama' => 'AINUL HAKI',
	),
	array( // row #83
		'idiman' => 108,
		'idsarung' => 339,
		'nama' => 'AHMAD ARIFIN',
	),
	array( // row #84 , CREATED , gumuk kembar 
		'idiman' => 109,
		'idsarung' => 519,
		'nama' => 'MUHAMMAD RIZAL',
	),
	array( // row #85
		'idiman' => 110,
		'idsarung' => 289,
		'nama' => 'ZAINUL AMBIYAK',
	),
	array( // row #86 , CREATED
		'idiman' => 111,
		'idsarung' => 518,
		'nama' => 'ALFAN HIDAYAT',
	),
	array( // row #87 , CREATED
		'idiman' => 112,
		'idsarung' => 517,
		'nama' => 'MOCH. RIZKY PRATAMA',
	),
	array( // row #88 , CREATED
		'idiman' => 113,
		'idsarung' => 516,
		'nama' => 'ABDUL FAQI',
	),
	array( // row #89 , CREATED
		'idiman' => 115,
		'idsarung' => 515,
		'nama' => 'MOCH. WILDAN HAKIKI',
	),
	array( // row #90
		'idiman' => 116,
		'idsarung' => 341,
		'nama' => 'AHMAD FAUZAN',
	),
	array( // row #91
		'idiman' => 118,
		'idsarung' => 396,
		'nama' => 'SOHIBUL JALAL',
	),
	array( // row #92
		'idiman' => 119,
		'idsarung' => 162,
		'nama' => 'ANDIKA  ZAKARIYA',
	),
	array( // row #93
		'idiman' => 120,
		'idsarung' => 447,
		'nama' => 'M.ZAINURI ROMADHONI',
	),
	array( // row #94 , CREATED
		'idiman' => 121,
		'idsarung' => 514,
		'nama' => 'HUSNI MUBAROK',
	),
	array( // row #95
		'idiman' => 122,
		'idsarung' => 385,
		'nama' => 'AHMAD FAUZI',
	),
	array( // row #96
		'idiman' => 123,
		'idsarung' => 392,
		'nama' => 'JONI ADI IRAWAN',
	),
	array( // row #97
		'idiman' => 124,
		'idsarung' => 361,
		'nama' => 'ACHMAD ZAINAL ABIDIN',
	),
	array( // row #98
		'idiman' => 125,
		'idsarung' => 238,
		'nama' => 'NUR ISKANDAR',
	),
	array( // row #99
		'idiman' => 126,
		'idsarung' => 265,
		'nama' => 'MOH.SYAKIR NI\'AM',
	),
	array( // row #100 , CREATED
		'idiman' => 127,
		'idsarung' => 513,
		'nama' => 'HANAN',
	),
	array( // row #101
		'idiman' => 128,
		'idsarung' => 394,
		'nama' => 'MUJAHID ANSHORI',
	),
	array( // row #102
		'idiman' => 129,
		'idsarung' => 267,
		'nama' => 'AHMAD YASIN',
	),
	array( // row #103
		'idiman' => 130,
		'idsarung' => 390,
		'nama' => 'FA\'IQUL HIMAM',
	),
	array( // row #104
		'idiman' => 132,
		'idsarung' => 278,
		'nama' => 'MUHAMMAD FARID',
	),
	array( // row #105 , CREATED
		'idiman' => 133,
		'idsarung' => 512,
		'nama' => 'MUHAMMAD TOYIB',
	),
	array( // row #106
		'idiman' => 134,
		'idsarung' => 393,
		'nama' => 'MUHAMMAD FAISAL ALI YUSUP',
	),
	array( // row #107 , 
		'idiman' => 135,
		'idsarung' => 368,
		'nama' => 'MOH.ZAKIL HAMDANI',
	),
	array( // row #108 , CREATED
		'idiman' => 136,
		'idsarung' => 511,
		'nama' => 'NUR HOLILI',
	),
	array( // row #109
		'idiman' => 137,
		'idsarung' => 239,
		'nama' => 'AKHMAD ROFIQI',
	),
	array( // row #110
		'idiman' => 139,
		'idsarung' => 388,
		'nama' => 'ANDIKA',
	),
	array( // row #111
		'idiman' => 140,
		'idsarung' => 242,
		'nama' => 'MUNIP RAMADHANI',
	),
	array( // row #112
		'idiman' => 141,
		'idsarung' => 391,
		'nama' => 'FARHAN FATHONI FIRMANSYAH',
	),
	array( // row #113
		'idiman' => 142,
		'idsarung' => 235,
		'nama' => 'MANSHUR',
	),
	array( // row #114
		'idiman' => 144,
		'idsarung' => 386,
		'nama' => 'AHMAT ERFAN YAKIN',
	),
	array( // row #115 , CREATED
		'idiman' => 145,
		'idsarung' => 510,
		'nama' => 'MAHMUDI',
	),
	array( // row #116
		'idiman' => 146,
		'idsarung' => 236,
		'nama' => 'KHOIRUL ANAM',
	),
	array( // row #117
		'idiman' => 147,
		'idsarung' => 263,
		'nama' => 'FERI KUSNANTO',
	),
	array( // row #118 C-7, CREATED
		'idiman' => 148,
		'idsarung' => 509 ,
		'nama' => 'FATHUR ROHMAN',
	),
	array( // row #119
		'idiman' => 149,
		'idsarung' => 387,
		'nama' => 'AHMAD YASIN',
	),
	array( // row #120
		'idiman' => 151,
		'idsarung' => 262,
		'nama' => 'ABDUL JALAL',
	),
	array( // row #121
		'idiman' => 152,
		'idsarung' => 173,
		'nama' => 'AHMAD ZEN FANANI',
	),
	array( // row #122
		'idiman' => 153,
		'idsarung' => 243,
		'nama' => 'MOH.YUZKI AMINULLAH',
	),
	array( // row #123
		'idiman' => 154,
		'idsarung' => 264,
		'nama' => 'MUHAMMAD LUTFI',
	),
	array( // row #124
		'idiman' => 155,
		'idsarung' => 267,
		'nama' => 'WALID BAHTIAR',
	),
	array( // row #125 , CREATED
		'idiman' => 156,
		'idsarung' => 508,
		'nama' => 'DIKI WAHYUDI',
	),
	array( // row #126
		'idiman' => 157,
		'idsarung' => 343,
		'nama' => 'ARIS RUSMAWAN',
	),
	array( // row #127
		'idiman' => 158,
		'idsarung' => 279,
		'nama' => 'MOH ALI REZA',
	),
	array( // row #128 , CREATED
		'idiman' => 160,
		'idsarung' => 507,
		'nama' => 'MOHAMMAD NASORADIN',
	),
	array( // row #129
		'idiman' => 161,
		'idsarung' => 425,
		'nama' => 'FATHUL QORIB',
	),
	array( // row #130 , CREATED
		'idiman' => 162,
		'idsarung' => 506,
		'nama' => 'NOPAL ROHMAT TRI WAHYUDI',
	),
	array( // row #131 
		'idiman' => 163,
		'idsarung' => 292,
		'nama' => 'MOH SHOLEHUDDIN',
	),
	array( // row #132
		'idiman' => 167,
		'idsarung' => 426,
		'nama' => 'MUHAIMIN ASRORI',
	),
	array( // row #133 , CREATED
		'idiman' => 168,
		'idsarung' => 505,
		'nama' => 'FATHUR ROHMAN',
	),
	array( // row #134
		'idiman' => 169,
		'idsarung' => 402,
		'nama' => 'AHMAD DANI',
	),
	array( // row #135
		'idiman' => 172,
		'idsarung' => 403,
		'nama' => 'AHMAD KAMIL BUDI HARTONO',
	),
	array( // row #136 
		'idiman' => 173,
		'idsarung' => 422,
		'nama' => 'MUHAMMAD TAUFIQ',
	),
	array( // row #137
		'idiman' => 174,
		'idsarung' => 429,
		'nama' => 'NANANG MUSTHOFA',
	),
	array( // row #138
		'idiman' => 175,
		'idsarung' => 433,
		'nama' => 'SUMARTO',
	),
	array( // row #139
		'idiman' => 176,
		'idsarung' => 414,
		'nama' => 'HAKIKI OKTARIZAL',
	),
	array( // row #140
		'idiman' => 177,
		'idsarung' => 411,
		'nama' => 'BUDI HARTONO',
	),
	array( // row #141
		'idiman' => 178,
		'idsarung' => 401,
		'nama' => 'ANSHORI',
	),
	array( // row #142 
		'idiman' => 179,
		'idsarung' => 399,
		'nama' => 'ABDUR RAHMAN SHOLEH',
	),
	array( // row #143
		'idiman' => 180,
		'idsarung' => 398,
		'nama' => 'ABDUL AZIZ',
	),
	array( // row #144
		'idiman' => 181,
		'idsarung' => 409,
		'nama' => 'BADRUS SODEK',
	),
	array( // row #145
		'idiman' => 182,
		'idsarung' => 436,
		'nama' => 'SYAHRUL GUNAWAN',
	),
	array( // row #146
		'idiman' => 183,
		'idsarung' => 431,
		'nama' => 'OKY ABDUL ROHMAN',
	),
	array( // row #147
		'idiman' => 184,
		'idsarung' => 280,
		'nama' => 'MOH. ISROFIL',
	),
	array( // row #148
		'idiman' => 185,
		'idsarung' => 293,
		'nama' => 'MOH ALLIF',
	),
	array( // row #149
		'idiman' => 186,
		'idsarung' => 413,
		'nama' => 'FERI IRAWAN',
	),
	array( // row #150
		'idiman' => 187,
		'idsarung' => 269,
		'nama' => 'ACHMAD BAIDHOWY',
	),
	array( // row #151
		'idiman' => 189,
		'idsarung' => 286,
		'nama' => 'NAHROWI',
	),
	array( // row #152
		'idiman' => 190,
		'idsarung' => 418,
		'nama' => 'MOH IRFAN',
	),
	array( // row #153 , CREATED
		'idiman' => 191,
		'idsarung' => 504,
		'nama' => 'AHMAD MANSUR',
	),
	array( // row #154
		'idiman' => 192,
		'idsarung' => 275,
		'nama' => 'DIKI HERMAWAN',
	),
	array( // row #155
		'idiman' => 194,
		'idsarung' => 274,
		'nama' => 'BAHARUDDIN',
	),
	array( // row #156
		'idiman' => 195,
		'idsarung' => 360,
		'nama' => 'YULIAN EKO MAULANA',
	),
	array( // row #157
		'idiman' => 197,
		'idsarung' => 410,
		'nama' => 'BAIS',
	),
	array( // row #158
		'idiman' => 198,
		'idsarung' => 291,
		'nama' => 'ACHMAD FAUZY',
	),
	array( // row #159
		'idiman' => 199,
		'idsarung' => 284,
		'nama' => 'MUHAMMAD SHOLIHIN',
	),
	array( // row #160 
		'idiman' => 201,
		'idsarung' => 419,
		'nama' => 'MUHAMMAD FAISAL',
	),
	array( // row #161
		'idiman' => 203,
		'idsarung' => 444,
		'nama' => 'MANSUR SHOLEH',
	),
	array( // row #162 , CREATED
		'idiman' => 204,
		'idsarung' => 503,
		'nama' => 'ANGGA DWINKI NOER HAKIKI',
	),
	array( // row #163
		'idiman' => 205,
		'idsarung' => 416,
		'nama' => 'HERMAN SETIAWAN',
	),
	array( // row #164 , CREATED
		'idiman' => 206,
		'idsarung' => 502,
		'nama' => 'DIKI CANDRA',
	),
	array( // row #165 , CREATED
		'idiman' => 208,
		'idsarung' => 501,
		'nama' => 'ALIF FAHRUR ROZI',
	),
	array( // row #166
		'idiman' => 209,
		'idsarung' => 287,
		'nama' => 'SAIFUL BAHRI',
	),
	array( // row #167 , MANGGUNGAN CREATED
		'idiman' => 211,
		'idsarung' => 500,
		'nama' => 'M.ABDUL GHOFUR',
	),
	array( // row #168
		'idiman' => 212,
		'idsarung' => 290,
		'nama' => 'ADITYA BUDI PURNOMO',
	),
	array( // row #169
		'idiman' => 213,
		'idsarung' => 400,
		'nama' => 'ADI PURNOMO',
	),
	array( // row #170
		'idiman' => 214,
		'idsarung' => 268,
		'nama' => 'ZAINUL QUDSI',
	),
	array( // row #171 
		'idiman' => 215,
		'idsarung' => 336,
		'nama' => 'MA\'RUF',
	),
	array( // row #172 , AMBIGUE , CREATED
		'idiman' => 216,
		'idsarung' => 499,
		'nama' => 'MOH SHOLEHUDDIN',
	),
	array( // row #173
		'idiman' => 218,
		'idsarung' => 337,
		'nama' => 'TUKIANTO',
	),
	array( // row #174
		'idiman' => 219,
		'idsarung' => 260,
		'nama' => 'SAMSUL KAMAR',
	),
	array( // row #175
		'idiman' => 220,
		'idsarung' => 440,
		'nama' => 'JEFRI ADITIYA PUTRA',
	),
	array( // row #176 
		'idiman' => 221,
		'idsarung' => 498,
		'nama' => 'MOH.AS\'ADUR ROFIQ',
	),
	array( // row #177
		'idiman' => 222,
		'idsarung' => 349,
		'nama' => 'MOCHAMMAD ZAHID',
	),
	array( // row #178
		'idiman' => 223,
		'idsarung' => 422,
		'nama' => 'RIZAL',
	),
	array( // row #179 
		'idiman' => 224,
		'idsarung' => 383,
		'nama' => 'MUHAMMAD  ARIEF',
	),
	array( // row #180
		'idiman' => 226,
		'idsarung' => 379,
		'nama' => 'HABIB MAULANA ZULFI',
	),
	array( // row #181
		'idiman' => 227,
		'idsarung' => 373,
		'nama' => 'ABDUR ROHMAN WAHID',
	),
	array( // row #182
		'idiman' => 231,
		'idsarung' => 434,
		'nama' => 'NABIL HALHALAL HIKAM',
	),
	array( // row #183
		'idiman' => 233,
		'idsarung' => 57,
		'nama' => 'MUHAMMAD TAUFIK ',
	),
	array( // row #184
		'idiman' => 234,
		'idsarung' => 351,
		'nama' => 'MOCH. HAFI',
	),
	array( // row #185
		'idiman' => 236,
		'idsarung' => 451,
		'nama' => 'FUDHOILUL ILMANI',
	),
	array( // row #186
		'idiman' => 239,
		'idsarung' => 374,
		'nama' => 'AFRIAN KURNIAWAN ',
	),
	array( // row #187
		'idiman' => 242,
		'idsarung' => 456,
		'nama' => 'MALIK ABDUL AZIS',
	),
	array( // row #188 
		'idiman' => 244,
		'idsarung' => 480,
		'nama' => 'AZRIL CHOIRUDIN P',
	),
	array( // row #189 
		'idiman' => 245,
		'idsarung' => 483,
		'nama' => 'TAUFIK ROHMAN',
	),
	array( // row #190
		'idiman' => 247,
		'idsarung' => 372,
		'nama' => 'ABDUR ROFIK',
	),
	array( // row #191
		'idiman' => 249,
		'idsarung' => 358,
		'nama' => 'RIZAL ISMAWAN',
	),
	array( // row #192
		'idiman' => 254,
		'idsarung' => 375,
		'nama' => 'AKIL FAWAID',
	),
	array( // row #193
		'idiman' => 255,
		'idsarung' => 384,
		'nama' => 'MOH KHOIRUL LUAY',
	),
	array( // row #194
		'idiman' => 256,
		'idsarung' => 355,
		'nama' => 'MUHAMMAD SUA\'DI',
	),
	array( // row #195
		'idiman' => 257,
		'idsarung' => 450,
		'nama' => 'LUKMAN HAKIM',
	),
	array( // row #196
		'idiman' => 260,
		'idsarung' => 452,
		'nama' => 'MOH IQBALUR ROHMAN',
	),
	array( // row #197 
		'idiman' => 265,
		'idsarung' => 463,
		'nama' => 'NUR ANDRIAN FEBRIANTO',
	),
	array( // row #198 , 
		'idiman' => 266,
		'idsarung' => 462,
		'nama' => 'ILHAM WAHYU BUDIANTO',
	),
	array( // row #199
		'idiman' => 267,
		'idsarung' => 366,
		'nama' => 'MOHAMMAD IRWANTO',
	),
	array( // row #200
		'idiman' => 268,
		'idsarung' => 338,
		'nama' => 'MUHAMMAD AFIQ MADANI',
	),
	array( // row #201
		'idiman' => 269,
		'idsarung' => 365,
		'nama' => 'FASTAJABA ALIF SUKUR',
	),
);
		return $santri;
	}
	/**
	 *	insert into larangan kasus
	*/
	private function insert_into_larangan_kasus($db_sarung , $db_iman){
		//@ create kasus table in sarung
		$table_name = "larangan_kasus_";
		$sql = sprintf('
			CREATE TABLE IF NOT EXISTS  %1$s(
				id INTEGER PRIMARY KEY NOT NULL ,
				idlarangan INTEGER NOT NULL,
				idadmind INTEGER NOT NULL,			
				tanggal date,
				catatan VARCHAR (50) DEFAULT "",
				updated_at DATETIME ,
				created_at DATETIME ,
				FOREIGN KEY fk_admind         (idadmind)   REFERENCES admind        (id) ON DELETE NO ACTION ON UPDATE CASCADE,
				FOREIGN KEY fk_larangan_meta  (idlarangan) REFERENCES larangan_meta (id) ON DELETE NO ACTION ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;' , $table_name);
		try{
			$result = $db_sarung->exec($sql);
		}
		catch (PDOException $e) {
			print $e->getMessage ();
		}
		//@ prepare
		$santries = $this->get_id_list();
		//@ get all data kasus in iman table
		$sql = "select * from kasusfu order by id ASC";
		$cases = $db_iman->query( $sql );
		foreach($cases as $case){
			$id  		= $case ['id'] ;
			$idsantri   = $case ['idSantri'] ;
			$idlarangan = $case ['idLarangan'] ;
			$tanggal    = $case ['terungkap'] ;
			//@ get id santri in sarung according to id in iman
			$idsantri 	= $this->get_id_on_sarung($idsantri , $santries);
			//@ insert into larangan_kasus table in sarung database
			$query = sprintf('INSERT INTO %1$s(id,idlarangan,idadmind,tanggal)VALUES(?,?,?,?)',$table_name);
			try{
				$values = array( $id , $idlarangan , $idsantri , $tanggal);
				$kasus = $db_sarung->prepare($query);
				$kasus->execute( $values);
			}
			catch (PDOException $e) {
				echo $e->getMessage ();
			}
		}
		//@ done
	}
	/**
	 *	insert larangan along with its session into sarung table
	*/
	private function insert_into_larangan_meta($db_sarung , $db_iman){
		/*
			session between sarung and iman are same for higher than 4 ,
			and 4 in sarung is same with 2 in iman
			and finally 3 in sarung is same with 1 in iman ,
			and the rest is no need since we dont have any tindakan notes
		*/
		//@ create table first for list of tindakan
		$table_name = "larangan_meta";
		$sql =  "CREATE TABLE IF NOT EXISTS $table_name( ".
				"id INT NOT NULL, ".
				"idsession INT NOT NULL, ".
				"idlarangan INT NOT NULL, ".
				"jenis enum('B','M','R') NOT NULL, ".
				"point INT NOT NULL, ".
				"hukuman varchar(70) NOT NULL, ".
				"updated_at DATETIME ,".
				"created_at DATETIME ,".
				"PRIMARY KEY ( id )  ,". 	
				"KEY larangan_nama_ibfk (idlarangan),".			
				"UNIQUE KEY larangan_unique (idsession, idlarangan), ".
				"FOREIGN KEY larangan_nama_ibfk (idlarangan) REFERENCES larangan_nama (id) ON DELETE NO ACTION ON UPDATE CASCADE".
				")ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$result = $db_sarung->exec($sql);
		//@ get session of iman
		$sql = "select * from sessionfu order by awal DESC";
		$session = $db_iman->query( $sql );
		//@ get tindakan list or right now it is called by larangan meta
		$sql = "select * from larangan order by id ASC";
		$larangan_meta = $db_iman->query( $sql );
		foreach($larangan_meta as $row){
			echo "TEST<br>";
			//@ get id larangan
			$larangan_obj  = $this->findLarangan($db_sarung , $db_iman , $row['namaLarangan']  );
			//@ get idsession;
			if( $row ['idSession'] == 2){
				$row ['idSession'] = 4;
			}
			elseif( $row ['idSession'] == 1){
				$row ['idSession'] = 3;
			}
			//@ insert into larangan_meta
			$query = sprintf('INSERT INTO %1$s(id,idsession,idlarangan,jenis,point,hukuman)
											   VALUES(?,?,?,?,?,?)',$table_name);			
			$values = array(  $row ['id'],
								$row ['idSession'],
								$larangan_obj->id,
								$row ['jenisLarangan'],
								$row ['pointLarangan'],
								addslashes( $row ['hukuman'])
			);
			//			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			try{
				$larangan = $db_sarung->prepare($query);
				$larangan->execute( $values );
			}
			catch (PDOException $e) {
				print $e->getMessage ();
			}
		}
		echo "Done to execute larangan_meta";
	}
	/**
	 *	find larangan id
	 *	return object
	**/
	private function findLarangan($db_sarung , $db , $name){
		//$name_db = Config::get('database.backupdb');
		$query  = sprintf('select * from larangan_nama as tmp where tmp.nama = ?');
		//$statement->execute($me->prepareBindings($bindings));
		$larangan = $db_sarung->prepare($query);
		$larangan->execute( array($name) );
		$larangan = $larangan->fetch();
		//$larangan = $larangan->fetchall();
		return (object)$larangan;
	}
}
/**
*/
class update_ujian extends update_tindakan{
    public function __construct(){
		parent::__construct();
    }
	/**
	 * the purpose is to change kalinilai from integer to float
	*/
	public function init_ujian(){
		/**
#ALTER TABLE ujian ADD rate FLOAT(5);
#UPDATE ujian SET rate=kalinilai;
#ALTER TABLE ujian MODIFY kalinilai FLOAT(5);
#UPDATE ujian SET kalinilai=rate;
#ALTER TABLE ujian DROP rate;	
		*/
		$query = "ALTER TABLE ujian ADD tmp FLOAT(5)";
		$this->exe_non_query($query);
		$query = "UPDATE ujian SET tmp=kalinilai";
		$this->exe_non_query($query);
		$query = "ALTER TABLE ujian MODIFY kalinilai FLOAT(5)";
		$this->exe_non_query($query);
		$query = "UPDATE ujian SET kalinilai=tmp";
		$this->exe_non_query($query);
		$query = "ALTER TABLE ujian DROP tmp";
		$this->exe_non_query($query);
	}
}
/**
 *	First Update
*/
class first_update extends update_ujian{
    /**
     *  I`m clueless for this constructor
     *  return none
    */    
    public function __construct(){
		parent::__construct();
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
	*/
	public function first_update(){
    	$this->prepare_tables();
        $this->create_super_admind();
        echo "Done<br>Next is to Insert into admind table and the update santri table<br>";
        $this->moving_data();
        echo "Done<br>Next is to remove unused santri columns<br>";
        $this->remove_unused_santri_cols();        
 		//! new
        $sql = sprintf('ALTER TABLE santri ADD CONSTRAINT constr_ID UNIQUE (idadmind)');
        $this->exe_non_query( $sql ) ;		
	}
    /**
     *  default view during running this application
     *  return none
    */    
    public function getIndex(){
        set_time_limit(1600);
        $this->set_db(Config::get("database.main_db"));
    	echo "Prepare both santri and admin tables<br>";
		//$this->first_update();
		//$this->second_update();
		//$this->init_third();
	    // $this->init_update_tindakan();
		$this->init_ujian();
		echo "Done";
    }
	/**
	 *	Give updates_at and created_at sarung
	 *	return none;
	*/
    public function second_update(){
		//@
		//
	    DB::beginTransaction();
		$status = false;
		try {
			
			$this->remove_surat();
			$this->remove_wali();
			$this->remove_pekerjaan();
			$this->remove_sekolah();
			$this->remove_table("perihal");	
			$array = array("kabupaten","kalender","kecamatan","kelasisi","kelasisireason","kelasroot",'login',"negara",
						   "pelajaran","propinsi","ujian","ujianpetugas","ujianruang","ujiansantri","session","desa","event","kelas",'kelasdetail','pesan',
						   );
			foreach($array as $table){
				$this->change_common_edit_add($table);
			}
			//@
			$array = array("jadwalpelajaran","job","jurusan","petugas","santri","saveid","savenis","ujianaddon","kalender_note");
			foreach($array as $table){
				$this->change_common($table);
			}
			$this->remove_iuran();
			$this->update_kelas_isi();
			$this->remove_table("perihaltype");			
			$this->update_ujian_santri();
			$this->move_jurusan_from_kel_detail_to_kelas();
			$this->del_column('kelas','LEVEL');
			$this->change_column_name( "santri" , "idSession" , "idsession"  ,"INT");
			$this->update_ujian();
			DB::commit();
		}
		catch (\Exception $e) {
			echo $e->getMessage();
			DB::rollback();
		}
	}
	private function update_ujian(){
		$this->del_column('ujian','idsession');
	}
	/**
	 *	this will move jurusan from kelas detail table to kelas table
	*/
	private function move_jurusan_from_kel_detail_to_kelas(){
		//@ add idjurusan column to kelas first , as well as constrain
    	$this->add_column('kelas' , 'idjurusan'  , ' int(11) NOT NULL DEFAULT 1 , 
    		ADD CONSTRAINT fk_jurusan FOREIGN KEY (idjurusan) REFERENCES jurusan (id) ON DELETE NO ACTION ON UPDATE CASCADE' );
		//@ get all idjurusan from kelas detail
		$kelas_detail = new Kelas_Detail_Model();
		//@ loop
		foreach($kelas_detail->get() as $item){
			//@ update idjurusan from kelas
			$kelas = new Kelas_Model();
			$kelas = $kelas->find($item->idkelas);
			$kelas->idjurusan = $item->idjurusan;
			$kelas->save();			
		}
		//@ done
	}
	private function remove_wali(){
    	$names = array('wali_ibfk_1' , 'wali_ibfk_2','wali_ibfk_3','wali_ibfk_4');
    	foreach ($names as $name) {
    		$this->del_constraint( "wali" , $name);
    	}
		$this->remove_table("wali");
	}
	/**
	 *
	**/
	private function update_kelas_isi(){
    	$names = array('kelasisi_ibfk_3');
    	foreach ($names as $name) {
    		$this->del_constraint( "kelasisi" , $name);
    	}
		$this->remove_table("kelasisireason");
		$names = array('startlevel','level' ,'idreason','idkelaslama');
    	foreach ($names as $name) {
			$this->del_column('kelasisi',$name);
    	}		
	}
	/**
	 *
	**/
	private function update_ujian_santri(){
		$names = array('kalinilai');
    	foreach ($names as $name) {
			$this->del_column('ujiansantri',$name);
    	}				
	}
	private function remove_surat(){
    	$names = array('suratout_ibfk_1' , 'suratout_ibfk_2','suratout_ibfk_3');
    	foreach ($names as $name) {
    		$this->del_constraint( "suratout" , $name);
    	}
    	$names = array('petugasaddon_ibfk_4');
    	foreach ($names as $name) {
    		$this->del_constraint( "petugasaddon" , $name);
    	}		
		$this->remove_table("suratout");
		$this->remove_table("suratin");
		$this->remove_table("sifat");
		
	}
	private function remove_sekolah(){
    	$names = array('petugas_ibfk_5');
    	foreach ($names as $name) {
    		$this->del_constraint( "petugas" , $name);
    	}		
		$this->remove_table("sekolah");		
	}
	private function change_desa(){
		//@ desa
		$this->change_column_name( "desa" , "waktu" , "created_at"  ,"DATETIME");
		$this->add_column("desa" , 'updated_at'  , ' DATETIME DEFAULT \'2014-01-01\' ' );		
	}
	private function change_event(){
		$table = "event";
		$this->change_column_name( $table , "waktu" , "created_at"  ,"DATETIME");
		$this->add_column($table , 'updated_at'  , ' DATETIME DEFAULT \'2014-01-01\' ' );		
	}
	
	private function change_common($table){
		$this->add_column($table , 'updated_at'  , ' DATETIME DEFAULT \'2014-01-01\' ' );		
		$this->add_column($table , 'created_at'  , ' DATETIME DEFAULT \'2014-01-01\' ' );		
	}
	private function change_common_edit_add($table){
		$this->change_column_name( $table , "waktu" , "created_at"  ,"DATETIME");
		$this->add_column($table , 'updated_at'  , ' DATETIME DEFAULT \'2014-01-01\' ' );		
	}
	private function remove_pekerjaan(){
		$this->remove_table("pekerjaan");		
	}
	
	private function remove_iuran(){
    	//! remove constrain first
    	$names = array('iuranjumlah_ibfk_1' , 'iuranjumlah_ibfk_2','iuranjumlah_ibfk_3','iuranjumlah_ibfk_4');
    	foreach ($names as $name) {
    		$this->del_constraint( "iuranjumlah" , $name);
    	}
    	$names = array('iuranbayar_ibfk_2' , 'iuranbayar_ibfk_1');
    	foreach ($names as $name) {
    		$this->del_constraint( "iuranbayar" , $name);
    	}
		$this->remove_table("iuranjumlah");
		$this->remove_table("iuranbayar");
		$this->remove_table("iuranjenis");
		$this->remove_table("iuranlist");
		$this->remove_table("totalbayarsantri");
	}
	
}