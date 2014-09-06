<?php
/**
*		All model should follow this class
*		@var means variabel which will be filled
*		to use this class
*		$alias = array( "id" , "divisi_name" , "divisisub_name" , 'jumlah' , 'tanggal' );
*		$obj = new Outcome_model( $alias ) ; (must)
*		$obj ->set_base_query( $this->get_base_query($alias) ); (must)
*		$obj->set_limit( $this->get_current_page() , $this->get_total_jump() ); (optional)
*		$obj->set_group(); (optional)
*		$obj->set_wheres( $wheres); (optional)
*		$data = $obj->get_model(); (Now $data contains every item on database table)
**/
abstract class Root_model {
	protected $base_query  ; 
	private $alias_name  = array();
	private $order = "";
	private $group = "" ;
	private $final_query = "";// Good for debug \
	protected $limit = array( 'jump' => 0 , 'from' => 0 );
	protected $pagenation  = "";
	private $wheres = array( array() ); /* Two dimenational Array */
	//! get from limit array
	protected function get_jump(){		return $this->limit ['jump'] ;	}
	protected function set_jump($val){	$this->limit ['jump'] = $val ;	}
	protected function get_start(){		return $this->limit ['from'] ;	}
	protected function set_start($val){	$this->limit ['from'] = $val ;	}
	
	/* @var is  $final_query*/
	protected function set_final_query($val){		return $final_query = $val;	}
	public function get_total_row(){ return $this->pagenation->getTotal();}
    protected function set_pagenation( $query , $where ){
        $posts = DB::select(DB::raw( $query ) , $where );
        $this->pagenation = Paginator::make($posts, count($posts),  $this->get_jump() );
        /*
			$pagination->getCurrentPage
			$pagination->getLastPage
			$pagination->getPerPage
			$pagination->getFrom
			$pagination->getTo
			$pagination->count
        */
    }
    public  function get_pagenation_link( $array = array() ){
        if( count( $array) > 0  )
            return $this->pagenation->appends( $array )->links();
        return $this->pagenation->links ( );
    }    
    public function get_pagenation(){    	return $this->pagenation;    }
	/* Make sure everything is correct since after this you cant change anythings ,
		And pagenation automatic availabel aftet this function has ran .
		this function is most important part in this class 
	*/
	public function get_model(){
		// setting default query
		$query = $this->get_base_query();
		// setting default query along with its where 
		$where_val = array();
		foreach ($this->wheres as $where ) {
			if( isset( $where ['text'] )){
				 $query .= " ". $where ['text'] . " "  ; // Space is to keep safe 
				$where_val [] = $where ['val'] ;
			}
		}
		//! setting group
		$query .= " " . $this->get_group() . " "; 
		// setting order
		$query .= " " . $this->get_order() . " "; 
		//! setting page nation
		if( $this->get_jump() > 0 )
			$this->set_pagenation( $query , $where_val);
		// setting limit
		$query .= $this->get_limit();	
		$this->set_final_query( $query );
		$posts = DB::select(DB::raw( $query ) 	 , $where_val ) ; 
		return $posts;
	}
	/* @var is  $order which is string */
	public function set_group($val){		$this->group = $val; 	}	
	/* @var is  $order which is string */
	public function get_group(){		return $this->group ; 	}
	/* @var is  $order which is string */
	public function set_order($val){		$this->order = $val; 	}	
	/* @var is  $order which is string */
	public function get_order(){		return $this->order ; 	}
	/* @var is  $final_query , you can use this for debugging*/
	public function get_final_query(){		return $this->final_query;	}
	/* @var is  $limit which is array */	
	public function set_limit( $from , $jump ){
		$this->set_start($from );
		$this->set_jump($jump);
	}
	/* @var is  $limit which is array */	
	public function get_limit(){
		if( $this->get_jump() > 0)
			return sprintf( ' limit  %1$s , %2$s ' , $this->get_start() , $this->get_jump()  ) ;
		return "";
	}
	/* @var is  $alias_name which is array */
	public function set_alias( $array) {
		if( is_array($array)){
			$this->alias_name = array();
			foreach ($array as $key => $value) {
				$this->alias_name [] = $value ;
			}
		}
		else{
			echo "set alias should be array";			
		}
	}
	/* 	@var is  $alias_name which is array */	
	public function get_alias_names(){		return $this->alias_name;	}
	/* 
		You want fo show particular data ? . @var is  $wheres which is array 
		$where = array( array ( 'text' => '', 'val' => '') 
	*/
	public function set_wheres( $additional ){
		$this->wheres = $additional ; 
	}
	public function get_wheres(){ 		return $this->wheres;	}
	/*Set where one by one */
	public function set_where ( $text , $value ){
		$array = array( 'text' => $text , 'val' => $value);
		$this->wheres [] = $array ;
	}


	protected function get_base_query(){		return $this->base_query;		}
	
	abstract protected function set_base_query( $query) ; 
}
